<x-layout class="overflow-hidden">
    <div class="bg-white text-black rounded-xl w-[80vw] max-h-[88vh] mt-20">
        <div class="flex gap-4 items-center pt-1">
            <a href="{{ route('index') }}" class="pl-6">Dashboard</a>
            @if (in_array(auth()->user()->role_id, [1, 2]))
                <a href="{{ route('users') }}">Users</a>
            @endif
            <a href="{{ route('tasks') }}"><div class="rounded-t-xl bg-blue-600 p-4 text-white">Tasks</div></a>
        </div>
        <div class="overflow-y-scroll max-h-[80vh]">
            <div class='ml-1 flex flex-col p-10 gap-2 rounded-xl bg-blue-600 shadow-lg shadow-blue-600/80 text-white'>
                <div class="text-2xl flex justify-between gap-8">
                    <h1 class="text-wrap break-words">{{$task->title}}</h1>
                    <h1>{{$task->user->email}}</h1>
                </div>
                <div class="h-[1px] bg-white"></div>
                <div class="flex justify-between border-b border-white pb-2 gap-2">
                    <div>
                        <p>{{$task->content}}</p>
                    </div>
                    <div class="flex flex-col border-l gap-2 border-white px-4">
                        <div class="flex gap-2 justify-between">
                            <label for="status">Status:</label>
                            <p class="{{$task->status=='NEW'?'bg-gray-200/50':''}}
                                {{$task->status=='IN PROGRESS'?'bg-yellow-500/50':''}} 
                                {{$task->status=='DONE'?'bg-green-500/50':''}} 
                                {{$task->status=='CANCELED'?'bg-red-500/50':''}} 
                                {{$task->status=='EXPIRED'?'bg-red-500/50':''}} 
                                rounded px-1 text-lg text-nowrap" id="status">{{$task->status}}</p>
                            @if ($assigned)
                            @if ($task->status == 'NEW')
                            <div>
                                <a href="{{route('progress-task', $task->id)}}" class="underline">In progress</a>
                            </div> 
                            @elseif ($task->status=='IN PROGRESS' || $task->status=='CANCELED')
                            <div>
                                <a href="{{route('done-task', $task->id)}}" class="underline">Done</a>
                            </div> 
                            @endif
                            @endif
                            @if ($task->user_id == auth()->id() && $task->status == 'DONE')
                            <div>
                                <a href="{{route('cancel-task', $task->id)}}" class="underline">Cancel</a>
                            </div> 
                            @endif
                        </div>
                        <div class="flex gap-2 justify-between">
                            <label for="priority">Prioity:</label>
                            <p class="{{$task->priority=='Low'?'bg-gray-200/50':''}} 
                                {{$task->priority=='Medium'?'bg-yellow-500/50':''}}
                                {{$task->priority=='High'?'bg-red-500/50':''}}
                                rounded px-1 text-lg text-nowrap" id="priority">{{$task->priority}}</p>
                        </div>
                        <div class="flex gap-2 flex-col" id="assignees">
                            @forelse ($task->users as $user)
                                @if ($loop->first)
                                    <label for="assignees">Assignees:</label>
                                @endif
                                    <p class="bg-gray-200/50 rounded px-1 text-lg">
                                    {{$user->email}}
                                    </p>
                                    @if ($user->id == auth()->id())
                                    <div>
                                        <a href="{{route('deassign-task', $task->id)}}"><x-button>De-assign me</x-button></a>
                                    </div>
                                    @endif
                                @empty
                                    <p class="font-bold">Unassigned</p>
                            @endforelse
                            @if (!$assigned)
                            <div>
                                <a href="{{route('assign-task', $task->id)}}"><x-button>Assign to me</x-button></a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        @if ($task->file)
                        <a href="{{asset('storage/' . $task->file)}}" download><x-button>Download attachment 📎</x-button></a>
                        @endif
                    </div>
                    <div class="flex">
                        @if (in_array(auth()->user()->role_id, [1, 2]))
                        <form action="{{route('mark-task', $task->id)}}" method="POST" class="flex gap-4 items-center">
                            @csrf
                            @foreach (['Speed' => 'speed_rating', 
                            'Accuracy' => 'accuracy_rating',
                            'Quality' => 'quality_rating'] as $key => $value)
                                <div class="flex flex-col">
                                    <label for="{{$value}}">{{$key}}:</label>
                                    <x-input name='{{$value}}' value='{{$task->$value}}' type='number' min='1' max='12' />
                                </div>
                            @endforeach
                            <x-button>Rate</x-button>
                        </form>
                        @else
                            <div class="flex gap-8 mr-4">
                            @foreach (['Speed' => 'speed_rating', 
                            'Accuracy' => 'accuracy_rating',
                            'Quality' => 'quality_rating'] as $key => $value)
                                <div class="flex flex-col items-start">
                                    <label>{{$key}}:</label>
                                    <p class="bg-gray-200/50 rounded px-1 text-lg">{{$task->$value}}</p>
                                </div>
                            @endforeach
                            </div>
                        @endif
                        @foreach (['deadline'=>'Deadline:',
                        'started_at' => 'Started at:',
                        'done_at' => 'Done at:'] as $key => $value)
                            <div class="px-4">
                                <label for="{{$key}}">{{$value}}</label>
                                <p id="{{$key}}" class='bg-gray-200/50 rounded px-1 text-lg'>{{date('d-m-Y h:i', strtotime($task->$key))}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="p-4">
                <form action="{{route('create-comment', $task->id)}}" class="flex flex-col" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="content" class="text-lg">Comment:</label>
                    <div class="flex">
                        <textarea name="content" rows="2" 
                        class="border-solid border-gray-300 border-[2px] my-2 p-1 text-black rounded-lg resize-none w-[100%]"></textarea>
                    </div>
                    <div class="flex justify-between items-center">
                        <x-input type="file" name="file" class="bg-white"/>
                        <x-button class="!bg-blue-600 text-white px-4">➤</x-button>
                    </div>
                </form>
                @foreach ($task->comments as $comment)
                    <div class="border-t border-gray-300">
                        <div class="text-gray-500 flex justify-between">
                            <p>{{$comment->user->email}} commented:</p>
                            <p>{{date('d-m-Y h:i', strtotime($comment->created_at))}}</p>
                        </div>
                        <p class="px-2">{{$comment->content}}</p>
                        <div class="flex justify-between">
                            <div>
                                @if ($comment->file)
                                    <a href="{{asset('storage/' . $comment->file)}}" download class="text-gray-500 underline px-2">
                                        Download attachment 📎
                                    </a>
                                @endif
                            </div>
                            @if ($comment->user_id == auth()->id())
                            <form action="{{route('edit-comment', $task->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 underline">Delete</button>
                            </form>
                            @endif
                        </div>
                        @if ($comment->user_id == auth()->id())
                        <form action="{{route('edit-comment', $comment->id)}}" class="flex flex-col" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="flex">
                                <textarea name="content" rows="2" placeholder="Edit Comment" 
                                class="border-solid border-gray-300 border-[2px] my-2 p-1 text-black rounded-lg resize-none w-[100%]"></textarea>
                            </div>
                            <div class="flex justify-between items-center">
                                <x-input type="file" name="file" class="bg-white"/>
                                <x-button class="!bg-blue-600 text-white px-4">➤</x-button>
                            </div>
                        </form>
                        @endif
                        @if ($comment->reply)
                            <div class="border-t border-gray-300 px-4">
                                <div class="text-gray-500 flex justify-between">
                                    <p>{{$task->user->email}} replied:</p>
                                    <p>{{date('d-m-Y h:i', strtotime($comment->updated_at))}}</p>
                                </div>
                                <p class="px-2">{{$comment->reply}}</p>
                            </div>
                        @endif
                        @if ($task->user_id == auth()->id())
                            <form action="{{route('reply-comment', $comment->id)}}" class="flex" method="POST">
                                @csrf
                                @method("PATCH")
                                <textarea name="reply" rows="1" placeholder="{{$comment->reply?'Edit reply':'Reply'}}" 
                                class="border-solid border-gray-300 border-[2px] my-2 p-1 pr-8 text-black rounded-lg resize-none w-[100%]"></textarea>
                                <button class="text-gray-400 -ml-6">➤</button>
                            </form>  
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>