<x-layout class="overflow-hidden">
    <div class="bg-white text-black rounded-xl w-[80vw] max-h-[88vh] mt-20">
        <div class="flex gap-4 items-center pt-1">
            <a href="{{ route('index') }}" class="pl-6">Dashboard</a>
            <div class="rounded-xl bg-blue-600 p-4 !pb-10 -mb-6 text-white">Users</div>
            <a href="{{ route('tasks') }}">Tasks</a>
        </div>
        <div class="overflow-y-scroll max-h-[80vh]">
            <x-form class="text-white" :action="route('create-user')" method="POST">
                @csrf
                <div class="flex justify-between">
                    <div class="flex flex-col w-[31%]">
                        <label for="email">Email</label>
                        <x-input type="email" name="email" />
                    </div>
                    <div class="flex flex-col w-[31%]">
                        <label for="name">First Name</label>
                        <x-input type="text" name="name" />
                    </div>
                    <div class="flex flex-col w-[31%]">
                        <label for="lastname">Last Name</label>
                        <x-input type="text" name="lastname" />
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="flex flex-col w-[48%]">
                        <label for="password">Password</label>
                        <x-input type="password" name="password" />
                    </div>
                    <div class="flex flex-col w-[48%]">
                        <label for="password_confirmation">Confirm Password</label>
                        <x-input type="password" name="password_confirmation" />
                    </div>
                </div>
                <x-button class="mt-6">Create</x-button>
            </x-form>
            <form class="flex w-[100%] px-4">
                <x-input type="text" placeholder="Search user" class="w-[100%] pr-8" name='search' />
                <button class="text-gray-400 -ml-6">⌕</button>
            </form>
            <div class="p-2">
                <div class="p-2 overflow-y-scroll max-h-[27vh]">
                    <div class="flex border-b-2 gap-1 border-gray-300 text-gray-400 items-center -mt-3">
                        <p class="w-[15%] overflow-hidden text-nowrap">Name</p>
                        <p class="w-[15%] overflow-hidden text-nowrap">Lastname</p>
                        <p class="w-[45%] overflow-hidden text-nowrap">Email</p>
                        <p class="w-[20%] overflow-hidden text-nowrap">Tasks</p>
                        <p class="w-8 overflow-hidden text-nowrap">Edit</p>
                        <p class="w-8 overflow-hidden text-nowrap">Del</p>
                    </div>
                    @foreach ($users as $user)
                        <div class="flex border-b-2 border-gray-300 pb-1 items-center">
                            <p class="w-[15%] overflow-hidden text-nowrap">{{$user->name}}</p>
                            <p class="w-[15%] overflow-hidden text-nowrap">{{$user->lastname}}</p>
                            <p class="w-[45%] overflow-hidden text-nowrap">{{$user->email}}</p>
                            <p class="w-[19%] overflow-hidden text-nowrap">{{count($user->tasks)}}</p>
                            @if ($user->role_id != 1)
                                <a href="{{ route('edit-user', $user->id) }}"><x-button class="!bg-blue-600 !py-[0.2rem] mt-1 text-white w-8">✎</x-button></a>
                                <form action="{{ route('edit-user', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button class="!bg-blue-600 !py-[0.2rem] mt-1 ml-1 text-white w-8">🞭</x-button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>