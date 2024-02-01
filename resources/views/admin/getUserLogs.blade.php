<x-app-layout>
    <div class="flex flex-col justify-center items-center pt-5">            
        <h1 class="mt-6 mb-6 text-xl font-semibold text-gray-900 dark:text-black">User logs</h1>
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        As an admin, you can modify all user data here. 
        You can modify user profile data, edit comments, edit users favorite articles 
        and promote a user to an admin. Also you can 
        look at the history of activity logs
        </p>
        @php 
            $count=0;
        @endphp
        <table class="my-10 p-5 bg-white rounded shadow-sm sm:rounded-lg" style="width:70%">
            <thead>
                <div>
                    <tr class="border-b">
                        <th>User ID</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Created at</th>
                    </tr>
                </div>
                
            </thead>
            <tbody>
            @foreach ($userLogs as $logs)
                @php $count+=1;
                @endphp 
                <tr class="border-b">
                    <td class="p-5">{{$logs['user_id']}}</td>
                    @if($logs['action'] == 'create')
                        <td class="px-5 bg-emerald-500">{{$logs['action']}}</td>
                    @elseif($logs['action'] == 'update')
                        <td class="px-5 bg-yellow-300">{{$logs['action']}}</td>
                    @else
                        <td class="px-5 bg-red-500">{{$logs['action']}}</td>
                    @endif
                    <td class="px-5">{{$logs['description']}}</td>
                    <td class="px-5 ">{{$logs['created_at']}}</td>
                    
                </tr>                                      
            @endforeach 
            </tbody>            
        </table>  
        @if($count == 0)
            <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>
        @endif       
    </div>

</x-app-layout>


