@php
    $segments = request()->segments();
    $url = url('/');
@endphp

<nav class="bg-white px-4 py-2 rounded" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2 text-gray-700">
        <li>
            <a href="{{ url('/') }}" class="text-gray-600 hover:underline">
                <x-heroicon-s-home class="w-5 h-5 inline" />
            </a>
        </li>
        @foreach ($segments as $index => $segment)
            <li>
                <span class="mx-2 text-gray-400">/</span>
            </li>
            <li>
                @php
                    $url .= '/' . $segment;
                    $isLast = $index === count($segments) - 1;
                    $label = ucfirst(str_replace('-', ' ', $segment));
                @endphp
                @if ($isLast)
                    <span class="font-semibold text-gray-900">{{ $label }}</span>
                @else
                    <a href="{{ $url }}" class="text-gray-600 hover:underline">{{ $label }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
