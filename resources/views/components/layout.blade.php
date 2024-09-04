<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
    <style>
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 30%
        }
        th {
            padding-right: 0.25rem;
        }
    </style>
</head>
<body>
    <header class="absolute w-screen h-10 flex flex-row-reverse gap-8 items-center p-8 text-white">
        <x-header />
    </header>
    <main {{$attributes->merge([
        'class' => 'w-screen h-screen flex justify-center bg-black text-white'
        ])}}>
        {{$slot}}
    </main>
    <footer>
        
    </footer>
</body>
</html>