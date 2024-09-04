<x-layout class="overflow-hidden">
    <div class="bg-white text-black rounded-xl w-[80vw] max-h-[88vh] mt-20">
        <div class="flex gap-4 items-center px-1 pt-1">
            <a href="{{ route('admin-users') }}" class="pl-4">Users</a>
            <a href="{{ route('admin-roles') }}">Roles</a>
            <a href="{{ route('admin-departments') }}">Departments</a>
            <div class="rounded-t-xl bg-blue-600 p-4 text-white">Tasks</div>
        </div>
        <div class="overflow-y-scroll max-h-[80vh]">
            <div class="flex gap-4 ml-1 px-10 pt-10 rounded-t-xl -mb-8 bg-blue-600">
                @foreach ($departments as $department)
                    <a href="{{ route('admin-tasks', $department->id) }}"><x-button>{{$department->name}}</x-button></a>
                @endforeach
            </div>
            <x-form class="text-white" :action="route('create-task')" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="number" hidden name="department_id" value="{{$department->id}}">
                <div class="flex justify-between">
                    <div class="flex flex-col w-[31%]">
                        <label for="title">Title</label>
                        <x-input type="text" name="title" />
                    </div>
                    <div class="flex flex-col w-[31%]">
                        <label for="deadline">Deadline</label>
                        <x-input type="datetime-local" name="deadline" />
                    </div>
                    <div class="flex flex-col w-[31%]">
                        <label for="priority">Priority</label>
                        <x-select name="priority">
                            <option value='Low'>Low</option>
                            <option value='Medium' selected>Medium</option>
                            <option value='High'>High</option>
                        </x-select>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label for="content">Content</label>
                    <textarea name="content" rows="3" 
                    class="border-solid border-gray-300 border-[2px] my-2 p-1 text-black rounded-lg resize-none"></textarea>
                </div>
                <div class="flex justify-between">
                    <div class="flex flex-col w-[48%]">
                        <label for="assignees">Assignees</label>
                        <x-select name="assignees[]" multiple class="h-10">
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="flex flex-col w-[48%]">
                        <label for="file">Attachment</label>
                        <x-input type="file" name="file" class="bg-white"/>
                    </div>
                </div>
                <x-button class="mt-6">Create</x-button>
            </x-form>
            <form class="flex w-[100%] px-4">
                <x-input type="text" placeholder="Search task" class="w-[100%] pr-8" name='search' />
                <button class="text-gray-400 -ml-6">⌕</button>
            </form>
            <div class="px-4">
                <div class="flex border-b-2 gap-1 border-gray-300 text-gray-400 items-center">
                    <a href="?sort=id&order={{request('order') == 'asc'?'desc':'asc'}}" class="w-[5%] overflow-hidden text-nowrap">
                        <p>ID {{request('sort') == 'id' && request('order')?request('order') == 'asc'?'↑':'↓':''}}</p></a>
                    <a href="?sort=title&order={{request('order') == 'asc'?'desc':'asc'}}" class="w-[25%] overflow-hidden text-nowrap">
                        <p>Title {{request('sort') == 'title' && request('order')?request('order') == 'asc'?'↑':'↓':''}}</p></a>
                    <a href="?sort=status&order={{request('order') == 'asc'?'desc':'asc'}}" class="w-[15%] overflow-hidden text-nowrap px-1">
                        <p>Status {{request('sort') == 'status' && request('order')?request('order') == 'asc'?'↑':'↓':''}}</p></a>
                    <a href="?sort=priority&order={{request('order') == 'asc'?'desc':'asc'}}" class="w-[10%] overflow-hidden text-nowrap px-1">
                        <p>Priority {{request('sort') == 'priority' && request('order')?request('order') == 'asc'?'↑':'↓':''}}</p></a>
                    <a href="?sort=user_id&order={{request('order') == 'asc'?'desc':'asc'}}" class="w-[20%] overflow-hidden text-nowrap">
                        <p>Reporter {{request('sort') == 'user_id' && request('order')?request('order') == 'asc'?'↑':'↓':''}}</p></a>
                    <p class="w-[20%] overflow-hidden text-nowrap">Assignees</p>
                    <p class="w-10 overflow-hidden text-nowrap">Edit</p>
                    <p class="w-10 overflow-hidden text-nowrap">Del</p>
                </div>
                @foreach ($tasks as $task)
                    <div class="flex border-b-2 border-gray-300 py-1 items-center">
                        <a href="{{ route('task', $task->id) }}" class="flex w-[100%] gap-1">
                            <p class="w-[5%] overflow-hidden text-nowrap">{{$task->id}}</p>
                            <p class="w-[25%] text-wrap">{{$task->title}}</p>
                            <div class="w-[15%] flex">
                                <p class="{{$task->status=='NEW'?'bg-gray-200/50':''}}
                                    {{$task->status=='IN PROGRESS'?'bg-yellow-500/50':''}} 
                                    {{$task->status=='DONE'?'bg-green-500/50':''}} 
                                    {{$task->status=='CANCELED'?'bg-red-500/50':''}} 
                                    {{$task->status=='EXPIRED'?'bg-red-500/50':''}} 
                                    rounded px-1 text-nowrap" id="status">{{$task->status}}</p>
                            </div>
                            <div class="w-[10%] flex">
                                <p class="{{$task->priority=='Low'?'bg-gray-200/50':''}} 
                                    {{$task->priority=='Medium'?'bg-yellow-500/50':''}}
                                    {{$task->priority=='High'?'bg-red-500/50':''}}
                                    rounded px-1 text-nowrap" id="priority">{{$task->priority}}</p>
                            </div>
                            <p class="w-[20%] overflow-hidden text-nowrap">{{$task->user->email}}</p>
                            <p class="w-[20%] text-wrap">
                                @forelse ($task->users as $user)
                                    {{$user->email}}@if ($loop->remaining > 0), @endif
                                @empty
                                    Unassigned
                                @endforelse
                            </p>
                        </a>
                        <a href="{{ route('edit-task', $task->id) }}"><x-button class="!bg-blue-600 !py-[0.2rem] mt-1 text-white w-8">✎</x-button></a>
                        <form action="{{ route('edit-task', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-button class="!bg-blue-600 !py-[0.2rem] mt-1 ml-1 text-white w-8">🞭</x-button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>