<form {{$attributes->merge([
    'class' => 'flex flex-col p-10 min-w-96 rounded-xl bg-blue-600 shadow-lg shadow-blue-600/80 ml-1',
    'action' => $action,
    'method' => $method
    ])}}>
    {{$slot}}
</form>