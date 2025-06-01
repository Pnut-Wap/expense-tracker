<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Wrapper -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-4 hidden md:block">
            <h2 class="text-2xl font-bold mb-8">Admin Panel</h2>
            <nav class="space-y-4">
                <ul>
                    <li>
                        <a href="#" class="block p-3 hover:bg-gray-100 hover:text-black">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="#" class="block p-3 hover:bg-gray-100 hover:text-black">
                            Users
                        </a>
                    </li>

                    <li>
                        <a href="#" class="block p-3 hover:bg-gray-100 hover:text-black">
                            Reports
                        </a>
                    </li>

                    <li>
                        <a href="#" class="block p-3 hover:bg-gray-100 hover:text-black">
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="bg-white shadow p-4 flex items-center justify-between">
                <h1 class="text-xl font-bold">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Administrator</span>
                    <img src="https://i.pravatar.cc/40" alt="User Avatar" class="rounded-full w-10 h-10" />
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="text-sm text-gray-500">Users</h3>
                        <p class="text-2xl font-bold">1,245</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="text-sm text-gray-500">Revenue</h3>
                        <p class="text-2xl font-bold">$34,000</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="text-sm text-gray-500">Orders</h3>
                        <p class="text-2xl font-bold">320</p>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="text-sm text-gray-500">Tickets</h3>
                        <p class="text-2xl font-bold">12</p>
                    </div>
                </div>

                <!-- More content can go here -->
                <div class="mt-10 bg-white rounded-xl p-6 shadow">
                    <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                    <ul class="space-y-2 text-sm">
                        <li>✅ User John signed up</li>
                        <li>💰 New order #1234 received</li>
                        <li>📧 Support ticket #4321 opened</li>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
