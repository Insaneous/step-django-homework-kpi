<button {{$attributes->merge([
    'class' => 'bg-white text-black p-2 rounded-lg shadow-sm shadow-gray-300/80',
    ])}}>
    {{$slot}}
</button>