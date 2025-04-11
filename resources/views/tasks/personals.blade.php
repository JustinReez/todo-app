@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Personal Tasks</h1>
        <div class="h-4 w-4 rounded bg-blue-500"></div>
    </div>

    @if($personalTasks->isEmpty())
        <div class="bg-gray-800 rounded-lg p-6 text-center">
            <p class="text-gray-400">No personal tasks found</p>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($personalTasks as $task)
                <div class="bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                        <span class="text-sm text-gray-400">Due: {{ $task->due_date->format('M d, Y') }}</span>
                    </div>
                    @if($task->description)
                        <p class="text-gray-400 mt-2">{{ $task->description }}</p>
                    @endif
                    <div class="flex items-center mt-4 space-x-4">
                        <span class="px-2 py-1 text-sm rounded-full {{ $task->status === 'completed' ? 'bg-green-500' : ($task->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        @if($task->priority)
                            <span class="px-2 py-1 text-sm rounded-full {{ $task->priority === 'high' ? 'bg-red-500' : ($task->priority === 'medium' ? 'bg-yellow-500' : 'bg-blue-500') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection