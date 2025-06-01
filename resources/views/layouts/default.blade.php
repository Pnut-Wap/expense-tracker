<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">

        <x-sidebar />

        <div class="flex-1 flex flex-col">

            <x-topbar />

            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
