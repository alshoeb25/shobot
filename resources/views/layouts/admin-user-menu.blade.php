<!-- User Menu (Desktop) -->
<div x-data="{ userMenuOpen: false }" class="hidden sm:flex sm:items-center sm:ms-6 relative">

    <!-- Trigger -->
    <button @click="userMenuOpen = !userMenuOpen"
            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-700 bg-white border border-gray-200 hover:bg-gray-50">
        
        <span>{{ Auth::user()->name }}</span>

        <svg class="w-4 h-4 ml-2 text-gray-500"
             fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
         x-transition
         class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50">

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




<!-- Mobile Hamburger Menu -->
<div class="-me-2 flex items-center sm:hidden">

    <button @click="mobileOpen = !mobileOpen"
            class="p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700">

        <!-- Icon: Menu -->
        <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>

        <!-- Icon: Close -->
        <svg x-show="mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>

    </button>
</div>
