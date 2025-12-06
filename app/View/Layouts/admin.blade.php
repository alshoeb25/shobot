<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom styles -->
    @stack('styles')
</head>

<body class="bg-gray-100">

    <!-- Sidebar + Header Wrapper -->
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 border-b">
                <h2 class="text-xl font-bold">Admin Panel</h2>
            </div>

            <nav class="mt-4">
                <a href="{{ route('admin.organizations.index') }}"
                    class="block px-4 py-2 hover:bg-gray-200 {{ request()->is('admin/organizations*') ? 'bg-gray-200 font-bold' : '' }}">
                    Organizations
                </a>

                <a href="{{ route('admin.questions.index') }}"
                    class="block px-4 py-2 hover:bg-gray-200">
                    Bot Questions
                </a>

                <a href="{{ route('admin.leads.index') }}"
                    class="block px-4 py-2 hover:bg-gray-200">
                    Leads
                </a>

                <a href="{{ url('/dashboard') }}"
                    class="block px-4 py-2 hover:bg-gray-200">
                    Dashboard
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">

            <!-- Page Title -->
            @hasSection('title')
            <h1 class="text-2xl font-bold mb-4">@yield('title')</h1>
            @endhasSection

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')

        </main>

    </div>

    @yield('scripts')
</body>
</html>
