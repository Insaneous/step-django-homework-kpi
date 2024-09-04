<x-layout class="overflow-hidden">
    <div class="bg-white text-black rounded-xl w-[80vw] max-h-[88vh] mt-20">
        <div class="flex gap-4 items-center px-1 pt-1">
            <a href="{{ route('admin-users') }}" class="pl-4">Users</a>
            <div class="rounded-t-xl bg-blue-600 p-4 text-white">Roles</div>
            <a href="{{ route('admin-departments') }}">Departments</a>
            <a href="{{ route('admin-tasks', 1) }}">Tasks</a>
        </div>
        <div class="overflow-y-scroll max-h-[80vh]">
            <x-form class="text-white" :action="route('create-role')" method="POST">
                @csrf
                <div class="flex flex-col">
                    <label for="name">Name</label>
                    <x-input type="text" name="name" />
                </div>
                <x-button class="mt-6">Create</x-button>
            </x-form>
            <form class="flex w-[100%] px-4">
                <x-input type="text" placeholder="Search role" class="w-[100%] pr-8" name='search' />
                <button class="text-gray-400 -ml-6">⌕</button>
            </form>
            <div class="p-4">
                <div class="flex border-b-2 justify-between gap-1 border-gray-300 text-gray-400 items-center -mt-3">
                    <p class="w-[100%] overflow-hidden text-nowrap">Name</p>
                    <p class="w-8">Edit</p>
                    <p class="w-8">Del</p>
                </div>
                @foreach ($roles as $role)
                    <div class="flex border-b-2 gap-1 border-gray-300 pb-1 items-center">
                        <p class="w-[100%] overflow-hidden text-nowrap">{{$role->name}}</p>
                        @if ($role->id != 1)
                            <a href="{{ route('edit-role', $role->id) }}"><x-button class="!bg-blue-600 !py-[0.2rem] mt-1 text-white w-8">✎</x-button></a>
                            <form action="{{ route('edit-role', $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-button class="!bg-blue-600 !py-[0.2rem] mt-1 text-white w-8">🞭</x-button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>