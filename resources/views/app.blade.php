<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI for Material Science</title>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-200">
    <nav class="bg-white dark:bg-gray-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex space-x-7">
                    <a href="#" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 dark:text-gray-300 text-lg">MetaEther</span>
                    </a>
                </div>
                <button id="darkModeToggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 flex-grow flex flex-col">
        <div id="ai-messages" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 h-96 overflow-y-auto">
            <div class="mb-4">
                <p class="text-gray-700 dark:text-gray-300">Welcome to AI Material Science. How can I assist you today?</p>
            </div>
        </div>

        <div class="mt-auto">
            <form id="chat-form" hx-post="{{ route('ai.analyze') }}" hx-target="#ai-messages" hx-swap="beforeend" hx-trigger="submit" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                @csrf
                <div class="flex items-center">
                    <input type="text" id="material" name="material" placeholder="Enter a material to analyze..." 
                           class="flex-grow px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                    <button type="submit" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700">
                        Analyze
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white dark:bg-gray-800 text-center p-4 mt-8">
        <p class="text-gray-500 dark:text-gray-400">&copy; 2024 AI Material Science. All rights reserved.</p>
    </footer>

    <script>
        document.body.addEventListener('htmx:afterRequest', function(event) {
            if (event.detail.successful) {
                const response = JSON.parse(event.detail.xhr.responseText);
                const messagesContainer = document.getElementById('ai-messages');
                const messageDiv = document.createElement('div');
                messageDiv.className = 'mb-4';
                messageDiv.innerHTML = `
                    <p class="font-bold">Analysis for ${response.material}:</p>
                    <p class="text-gray-700 dark:text-gray-300">${response.analysis}</p>
                `;
                messagesContainer.appendChild(messageDiv);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                document.getElementById('material').value = '';
            } else {
                console.error('Error:', event.detail.xhr.responseText);
            }
        });

        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        darkModeToggle.addEventListener('click', function() {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        });

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            html.classList.add('dark');
        }
    </script>
</body>
</html>