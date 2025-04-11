<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4 max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit Task</h1>
            <a href="{{ route('tasks.index') }}" class="text-gray-400 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>
        
        @if($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-gray-800 rounded-lg p-4">
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">{{ old('description', $task->description) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium mb-1">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date->format('Y-m-d\TH:i')) }}" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" id="status" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">
                        <option value="todo" @if(old('status', $task->status) == 'todo') selected @endif>Todo</option>
                        <option value="in_progress" @if(old('status', $task->status) == 'in_progress') selected @endif>In Progress</option>
                        <option value="completed" @if(old('status', $task->status) == 'completed') selected @endif>Completed</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="label" class="block text-sm font-medium mb-1">Label</label>
                    <select name="label" id="label" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">
                        <option value="">None</option>
                        <option value="work" @if(old('label', $task->label) == 'work') selected @endif>Work</option>
                        <option value="personal" @if(old('label', $task->label) == 'personal') selected @endif>Personal</option>
                        <option value="urgent" @if(old('label', $task->label) == 'urgent') selected @endif>Urgent</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium mb-1">Priority</label>
                    <select name="priority" id="priority" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">
                        <option value="medium" @if(old('priority', $task->priority) == 'medium') selected @endif>Medium</option>
                        <option value="high" @if(old('priority', $task->priority) == 'high') selected @endif>High</option>
                        <option value="low" @if(old('priority', $task->priority) == 'low') selected @endif>Low</option>
                    </select>
                </div>
                
                <div class="flex justify-between">
                    <a href="{{ route('tasks.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure you want to update this task?') ? true : false;">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>