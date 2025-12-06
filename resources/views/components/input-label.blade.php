<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    
    {{-- Prefer $value if provided --}}
    @if(isset($value))
        {{ $value }}
    @endif

    {{-- Otherwise use slot --}}
    {{ $slot ?? '' }}

    {{-- If this label wraps a section --}}
    @hasSection('content')
        @yield('content')
    @endif

</label>
