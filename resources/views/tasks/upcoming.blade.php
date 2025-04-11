@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <!-- Upcoming Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Upcoming</h2>
        
        <div class="space-y-2">
            @forelse($upcomingTasks as $task)
            <div class="bg-gray-800 dark rounded-lg p-4 flex items-center">
                <div class="w-6 h-6 {{ $task->priority == 'high' ? 'bg-red-500' : ($task->priority == 'medium' ? 'bg-blue-500' : 'bg-gray-300') }} rounded-full mr-3"></div>
                <div class="flex-grow">
                    <div>{{ $task->title }}</div>
                    @if($task->category || $task->due_date)
                    <div class="flex items-center mt-1">
                        @if($task->category)
                        <span class="text-sm text-gray-500 mr-2">{{ $task->category }}</span>
                        @endif
                        @if($task->due_date)
                        <span class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-y') }}
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-gray-500 text-center py-4">No upcoming tasks</div>
            @endforelse
        </div>
    </div>
    
    <div class="flex flex-wrap -mx-2">
        <!-- Today Section -->
        <div class="w-full md:w-1/2 px-2 mb-6">
            <h2 class="text-2xl font-bold mb-4">Today</h2>
            
            <div class="space-y-2">
                @forelse($todayTasks as $task)
                <div class="bg-gray-800 rounded-lg p-4 flex items-center">
                    <div class="w-6 h-6 {{ $task->priority == 'high' ? 'bg-red-500' : ($task->priority == 'medium' ? 'bg-blue-500' : 'bg-gray-300') }} rounded-full mr-3"></div>
                    <div class="flex-grow">
                    <div>{{ $task->title }}</div>
                    @if($task->due_date)
                    <div class="text-sm text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-y') }}
                    </div>
                    @endif
                    </div>
                </div>
                @empty
                <div class="text-gray-500 text-center py-4">No tasks for today</div>
                @endforelse
            </div>
        </div>
        
        <!-- This Week Section -->
        <div class="w-full md:w-1/2 px-2 mb-6">
            <h2 class="text-2xl font-bold mb-4">This Week</h2>
            
            <div class="space-y-2">
                @forelse($thisWeekTasks as $task)
                <div class="bg-gray-800 rounded-lg p-4 flex items-center">
                    <div class="w-6 h-6 {{ $task->priority == 'high' ? 'bg-red-500' : ($task->priority == 'medium' ? 'bg-blue-500' : 'bg-gray-300') }} rounded-full mr-3"></div>
                    <div class="flex-grow">
                    <div>{{ $task->title }}</div>
                    @if($task->due_date)
                    <div class="text-sm text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-y') }}
                    </div>
                    @endif
                    </div>
                </div>
                @empty
                <div class="text-gray-500 text-center py-4">No tasks for this week</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection