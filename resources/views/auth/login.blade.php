<x-layout class="items-center">
    <x-form action="" method="POST">
        <h2 class="text-xl font-semibold mb-4">Welcome!</h2>
        @csrf
        <label for="email">Email</label>
        <x-input type="email" name="email" required />
        @error('email')
        <p class="text-red-500 text-xs my-1">{{$message}}</p>
        @enderror
        <label for="password">Password</label>
        <x-input type="password" name="password" required />
        <x-button class="mt-4">Login</x-button>
    </x-form>
    <div class="absolute top-0 left-0 text-xl">
        <h1>admin@insaneous.dev</h1>
        <h1>admin</h1>
    </div>
</x-layout>