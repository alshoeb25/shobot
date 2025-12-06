<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ShoBot Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind / Alpine -->
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar w-64 bg-white shadow-lg hidden md:flex md:flex-col">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-gray-800">
                ShoBot Admin
            </h1>
        </div>

        <nav class="p-4 space-y-1">
            @can('viewAny', App\Models\Organization::class)
            <a href="{{ route('admin.organizations.index') }}"
               class="block px-4 py-2 rounded-lg 
               {{ request()->is('admin/organizations*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-200' }}">
                Organizations
            </a>
            @endcan

            <a href="{{ route('admin.questions.index') ?? '#' }}"
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200">
                Bot Questions
            </a>

            <a href="{{ route('admin.leads.index') ?? '#' }}"
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200">
                Leads
            </a>

            <a href="/admin/dashboard"
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-200">
                Dashboard
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- 🔵 TOP HEADER WITH USER MENU -->
        <header class="bg-white shadow">
            <div class="max-w-full mx-auto px-6 py-4 flex justify-between items-center">

                <!-- Page Title -->
                <h2 class="text-xl font-semibold text-gray-900">
                    @yield('title', 'Admin Panel')
                </h2>

                <!-- User Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 bg-gray-100 rounded-lg shadow-sm hover:bg-gray-200">

                        <span class="text-gray-700 font-medium">
                            {{ Auth::user()->name }}
                        </span>

                        <svg class="w-5 h-5 text-gray-600"
                             fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md border">

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 hover:bg-gray-100 text-gray-700">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700">
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </header>

        <!-- Admin Page Content -->
        <main class="mx-auto max-w-7xl px-6 py-8 w-full">
            @yield('content')
        </main>

    </div>

</div>
@yield('scripts')
</body>
</html>
