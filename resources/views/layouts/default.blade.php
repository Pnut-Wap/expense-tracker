<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css">

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
