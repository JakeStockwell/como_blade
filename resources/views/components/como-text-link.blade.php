<a {{ $attributes->merge(
    ['class' => 'block w-full px-4 py-0 text-left text-sm leading-5 text-gray-700 hover:text-white' 
    ]) }}>{{ $slot }}</a>