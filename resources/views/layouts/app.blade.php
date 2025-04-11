<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 p-4">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Task Management</h1>
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('tasks.upcoming') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 @if(request()->routeIs('tasks.upcoming')) bg-blue-500 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z" />
                                <path d="M11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>Upcoming</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.todo') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 @if(request()->routeIs('tasks.todo')) bg-blue-500 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            <span>Todo</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.calendar') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 @if(request()->routeIs('tasks.calendar')) bg-blue-500 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span>Calendar</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Labels</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('tasks.works') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            <div class="h-4 w-4 rounded bg-red-500 mr-3"></div>
                            <span>Work</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.personals') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            <div class="h-4 w-4 rounded bg-blue-500 mr-3"></div>
                            <span>Personal</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mt-8">
                <a href="{{ route('tasks.create') }}" class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded text-white transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Task
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div id="notification" class="fixed top-4 right-4 hidden">
                <div class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg">
                    <p id="notification-message"></p>
                </div>
            </div>
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Content will change based on the selected page -->
            @yield('content')
            @stack('scripts')
        </div>
    </div>
    <script>
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notification-message');
            
            notificationMessage.textContent = message;
            notification.classList.remove('hidden');
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }
        </script>
        @stack('scripts')
</body>
</html>