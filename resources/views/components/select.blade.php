<select {{$attributes->merge([
    'class' => 'border-solid border-gray-300 border-[2px] text-black p-1 rounded-lg mt-2',
    ])}}>
    {{$slot}}
</select>