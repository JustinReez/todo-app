@extends('layouts.app')

@section('content')
<div class="bg-gray-800 rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">{{ $currentDate->format('F Y') }}</h2>
        <div class="flex space-x-2">
            <a href="{{ route('tasks.calendar', ['month' => $currentDate->copy()->subMonth()->format('Y-m')]) }}" 
               class="p-1 rounded hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <a href="{{ route('tasks.calendar', ['month' => $currentDate->copy()->addMonth()->format('Y-m')]) }}" 
               class="p-1 rounded hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    
    <!-- Calendar grid -->
    <div class="grid grid-cols-7 gap-1 text-center">
        <!-- Days of week -->
        <div class="text-xs text-gray-400">S</div>
        <div class="text-xs text-gray-400">M</div>
        <div class="text-xs text-gray-400">T</div>
        <div class="text-xs text-gray-400">W</div>
        <div class="text-xs text-gray-400">T</div>
        <div class="text-xs text-gray-400">F</div>
        <div class="text-xs text-gray-400">S</div>
        
        <!-- Calendar days -->
        @php
            $firstDayOfMonth = $currentDate->copy()->startOfMonth()->dayOfWeek;
            $emptyCells = $firstDayOfMonth;
        @endphp
        
        @for ($i = 0; $i < $emptyCells; $i++)
            <div class="h-10 bg-gray-700 rounded"></div>
        @endfor
        
        @for ($day = 1; $day <= $daysInMonth; $day++)
            @php
                $date = $currentDate->copy()->setDay($day);
                $hasTask = isset($calendarTasks[$day]);
                $cellClass = $hasTask ? 'bg-red-500' : 'bg-gray-700';
                if ($date->isToday()) {
                    $cellClass = 'bg-blue-500';
                }
                if ($selectedDate && $date->isSameDay($selectedDate)) {
                    $cellClass .= ' ring-2 ring-yellow-500';
                }
            @endphp
            <a href="{{ route('tasks.calendar', ['month' => $currentDate->format('Y-m'), 'day' => $day]) }}"
               class="h-10 {{ $cellClass }} rounded flex items-center justify-center text-sm hover:opacity-75 transition-opacity">
                {{ $day }}
            </a>
        @endfor
    </div>
    
    <!-- Tasks for selected day -->
    <div class="mt-6">
        <h3 class="font-medium mb-3">Tasks for {{ $selectedDate ? $selectedDate->format('F j, Y') : Carbon\Carbon::now()->format('F j, Y') }}</h3>
        @forelse($selectedTasks as $task)
        <div class="bg-gray-700 p-3 rounded flex justify-between items-center mb-2">
            <div class="flex items-center">
                <input type="checkbox" class="mr-2" {{ $task->status == 'completed' ? 'checked' : '' }}>
                <span class="{{ $task->status == 'completed' ? 'line-through' : '' }}">{{ $task->title }}</span>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('tasks.edit', $task) }}" class="text-sm text-blue-400 hover:underline">Edit</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-400 hover:underline">Delete</button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-gray-500 text-center py-2">No tasks for selected day</div>
        @endforelse
    </div>
</div>
@endsection