<x-layout class="overflow-hidden">
    <div class="bg-white text-black rounded-xl w-[80vw] max-h-[88vh] mt-20 p-1">
        <div class="flex gap-4 items-center">
            <div class="rounded-t-xl bg-blue-600 p-4 text-white">Dashboard</div>
            @if (in_array(auth()->user()->role_id, [1, 2]))
                <a href="{{ route('users') }}">Users</a>
            @endif
            <a href="{{ route('tasks') }}">Tasks</a>
        </div>
        <div class="flex justify-between gap-4 p-10 rounded-xl rounded-tl-none bg-blue-600 shadow-lg shadow-blue-600/80 text-white h-[50%]">
            @if (in_array(auth()->user()->role_id, [1, 2]))
            <div class="w-[50%] pb-10">
                <h1 class="text-2xl mb-2">Tasks</h1>
                <div class='h-[100%] w-[100%] bg-white p-4 rounded-lg text-black flex justify-between'>
                    @foreach (['All'=>'',
                    'Done' => 'DONE', 
                    'Expired' => 'EXPIRED', 
                    'New' => 'NEW',
                    'In progress' => 'IN PROGRESS',
                    'Cancelled' => 'CANCELED'] as $key => $value)
                    <div class="w-[100%] h-[100%] flex flex-col items-center">
                        <p class="text-nowrap">{{$key}}</p>
                        <div class="w-[100%] h-[100%] flex flex-col items-center justify-end">
                            <div class="bg-blue-600 w-[40%]
                            h-[{{$value?
                            (count(auth()->user()->department->tasks->where('status', 'like', $value))/count(auth()->user()->department->tasks))*100
                            :100}}%]"></div>
                            <div class="h-[2px] w-[100%] bg-black"></div>
                            <p>{{$value?count(auth()->user()->department->tasks->where('status', 'like', $value)):count(auth()->user()->department->tasks)}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h1 class="text-2xl mb-2">Users</h1>
                <div class="bg-white text-black rounded-lg p-4">
                    <table>
                        <thead>
                            <tr class="border-b-2 border-gray-300 text-gray-400 text-left">
                                <th>Email</th>
                                <th>Assigned</th>
                                <th>Done</th>
                                <th>Expired</th>
                                <th>New</th>
                                <th class="text-nowrap">In progress</th>
                                <th>Canceled</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b-2 border-gray-300">
                                    <td>{{$user->email}}</td>
                                    <td class="text-center">{{count($user->tasks)}}</td>
                                    <td class="text-center">{{count($user->tasks->where('status', 'like', 'DONE'))}}</td>
                                    <td class="text-center">{{count($user->tasks->where('status', 'like', 'EXPIRED'))}}</td>
                                    <td class="text-center">{{count($user->tasks->where('status', 'like', 'NEW'))}}</td>
                                    <td class="text-center">{{count($user->tasks->where('status', 'like', 'IN PROGRESS'))}}</td>
                                    <td class="text-center">{{count($user->tasks->where('status', 'like', 'CANCELED'))}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="h-[100%] w-[100%] pb-10">
                <h1 class="text-2xl mb-2">Tasks</h1>
                <div class='h-[100%] w-[100%] bg-white p-4 rounded-lg text-black flex justify-between'>
                    @foreach (['All'=>'',
                    'Done' => 'DONE', 
                    'Expired' => 'EXPIRED', 
                    'New' => 'NEW',
                    'In progress' => 'IN PROGRESS',
                    'Cancelled' => 'CANCELED'] as $key => $value)
                    <div class="w-[100%] h-[100%] flex flex-col items-center">
                        <p class="text-lg">{{$key}}</p>
                        <div class="w-[100%] h-[100%] flex flex-col items-center justify-end">
                            <div class="bg-blue-600 w-[40%]
                            h-[{{$value?
                            (count(auth()->user()->tasks->where('status', 'like', $value))/count(auth()->user()->tasks))*100
                            :100}}%]"></div>
                            <div class="h-[2px] w-[100%] bg-black"></div>
                            <p>{{$value?count(auth()->user()->tasks->where('status', 'like', $value)):count(auth()->user()->tasks)}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layout>