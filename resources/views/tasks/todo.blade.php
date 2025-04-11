@extends('layouts.app')

@section('content')
<div class="bg-gray-800 rounded-lg p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Todo Tasks</h2>
        <div class="flex space-x-2">
            <button class="p-1 rounded hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
    
    <div class="space-y-2">
        <!-- Filter tabs -->
        <div class="flex space-x-2 mb-4">
            <button class="bg-gray-700 px-3 py-1 rounded text-sm font-medium">All</button>
        </div>
        
        <!-- Todo Tasks Section -->
        <div class="mt-4">
            <h3 class="font-medium mb-3">Todo</h3>
            @forelse($todoTasks as $task)
            <div class="bg-gray-700 p-3 rounded flex justify-between items-center mb-2">
                <div class="flex items-center">
                    <input type="checkbox" class="mr-2 task-checkbox"
                    data-task-id="{{ $task->id }}"
                    {{ $task->status === 'completed' ? 'checked' : '' }}>
                    <span>{{ $task->title }}</span>
                </div>
                <div class="flex space-x-2">
                    <span class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</span>
                    <a href="{{ route('tasks.edit', $task) }}" class="text-sm text-blue-400 hover:underline">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-400 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-gray-500 text-center py-4">No todo tasks</div>
            @endforelse
        </div>
        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const taskId = this.dataset.taskId;
                    const status = this.checked ? 'completed' : 'todo';
                    
                    fetch(`/tasks/${taskId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ status })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message);
                            if (status === 'completed') {
                                this.closest('.bg-gray-700').classList.add('opacity-50');
                                setTimeout(() => {
                                    this.closest('.bg-gray-700').remove();
                                }, 500);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Error updating task status', 'error');
                        this.checked = !this.checked;
                    });
                });
            });
        });
        </script>
        @endpush
@endsection
