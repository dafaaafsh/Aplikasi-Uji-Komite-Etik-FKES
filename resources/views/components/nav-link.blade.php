@props(['active' => false])

<a {{ $attributes }}
class="{{ $active ? 'bg-blue-800 text-white font-bold' : 'bg-gray-200 hover:bg-blue-200 font-medium' }} 
block md:py-4 py-2 px-8">
{{ $slot }}
</a>