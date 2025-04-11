<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4 max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Create New Task</h1>
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
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500" required autofocus>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium mb-1">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="label" class="block text-sm font-medium mb-1">Label</label>
                    <select name="label" id="label" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">
                        <option value="">None</option>
                        <option value="work" @if(old('label') == 'work') selected @endif>Work</option>
                        <option value="personal" @if(old('label') == 'personal') selected @endif>Personal</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium mb-1">Priority</label>
                    <select name="priority" id="priority" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-blue-500">
                        <option value="medium" @if(old('priority') == 'medium') selected @endif>Medium</option>
                        <option value="high" @if(old('priority') == 'high') selected @endif>High</option>
                        <option value="low" @if(old('priority') == 'low') selected @endif>Low</option>
                    </select>
                </div>
                
                <div class="flex justify-between">
                    <a href="{{ route('tasks.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>