<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return redirect()->route('tasks.upcoming');
    }
    
    public function upcoming()
    {
        $upcomingTasks = Task::whereBetween('due_date', [
            now()->addDay(), 
            now()->addDays(2) 
        ])
        ->orderBy('due_date', 'asc')
        ->get();
            
        $todayTasks = Task::whereRaw("DATE(due_date) = DATE(?)", [now()])
            ->orderBy('due_date', 'asc')
            ->get();
            
        $thisWeekTasks = Task::whereRaw("due_date BETWEEN ? AND ?", [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->orderBy('due_date', 'asc')
            ->get();
            
        return view('tasks.upcoming', compact('upcomingTasks', 'todayTasks', 'thisWeekTasks'));
    }

    public function todo()
    {
    $todoTasks = Task::whereRaw("DATE(due_date) = DATE(?)", [now()])
        ->orderBy('due_date', 'asc')
        ->get();
        
    return view('tasks.todo', compact('todoTasks'));
    }

    public function calendar(Request $request)
    {
    // Get the selected month from the URL, default to current month
    $currentDate = $request->month ? 
        Carbon::createFromFormat('Y-m', $request->month) : 
        Carbon::now();

    // Get the selected day if provided, ensure it's cast to integer
    $selectedDate = $request->day ? 
        $currentDate->copy()->setDay((int)$request->day) : 
        Carbon::now();

    $daysInMonth = $currentDate->daysInMonth;

    // Using PostgreSQL extract() function to get day from timestamp
    $calendarTasks = Task::select('*', DB::raw('EXTRACT(DAY FROM due_date) as day_of_month'))
        ->whereRaw('EXTRACT(MONTH FROM due_date) = ?', [$currentDate->month])
        ->whereRaw('EXTRACT(YEAR FROM due_date) = ?', [$currentDate->year])
        ->get()
        ->groupBy('day_of_month');

    // Get tasks for the selected day
    $selectedTasks = Task::whereRaw("DATE(due_date) = DATE(?)", [$selectedDate])
        ->orderBy('due_date', 'asc')
        ->get();

    return view('tasks.calendar', compact(
        'currentDate',
        'selectedDate',
        'daysInMonth',
        'calendarTasks',
        'selectedTasks'
    ));
    }
    
    public function updateStatus(Request $request, Task $task)
    {
    $request->validate([
        'status' => 'required|in:todo,in_progress,completed'
    ]);

    $task->update([
        'status' => $request->status
    ]);

    $message = $request->status === 'completed' ? 'Task completed successfully!' : 'Task marked as todo';
    notify()->success($message);

    return response()->json([
        'success' => true,
        'message' => $message
    ]);
    }

    public function works()
    {
        $workTasks = Task::where('label', 'work')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tasks.works', compact('workTasks'));    
    }

    public function personals()
    {
        $personalTasks = Task::where('label', 'personal')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('tasks.personals', compact('personalTasks'));
    }
    public function create()
    {
        return view('tasks.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'label' => 'nullable|string|max:50',
            'priority' => 'nullable|string|in:high,medium,low',
        ]);
        
        Task::create($validated);
        
        return redirect()->route('tasks.upcoming')->with('success', 'Task created successfully');
    }
    
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }
    
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'label' => 'nullable|string|max:50',
            'priority' => 'nullable|string|in:high,medium,low',
            'status' => 'nullable|string|in:todo,in_progress,completed',
        ]);
        
        $task->update($validated);
        
        return redirect()->back()->with('success', 'Task updated successfully');
    }
    
    public function destroy(Task $task)
    {
        $task->delete();
        
        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}