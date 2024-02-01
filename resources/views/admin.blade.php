<x-app-layout>
    <div class="flex flex-col justify-center items-center pt-5">            
        <h1 class="mt-6 mb-6 text-xl font-semibold text-gray-900 dark:text-black">Admin Back Office</h1>
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        As an admin, you can modify all user data here. 
        You can modify user profile data, edit comments, edit users favorite articles 
        and promote a user to an admin. Also you can 
        look at the history of activity logs
        </p>
        @php 
            $count=0;
        @endphp
        <table class="my-10 p-5 bg-white rounded shadow-sm sm:rounded-lg">
            <thead>
                <div>
                    <tr class="border-b">
                        <th>User ID</th>
                        <th>Name</th>
                        <th>E-mail</th>
                    </tr>
                </div>
                
            </thead>
            <tbody>
            @foreach ($users as $user)
                @php $count+=1;
                @endphp 
                <tr class="border-b">
                    <td class="p-5">{{$user['id']}}</td>
                    <td class="px-5">{{$user['name']}}</td>
                    <td class="px-5">{{$user['email']}}</td>
                    <td class="px-5 "><a class="bg-blue-500 text-white p-3 rounded" href="admin/profile?id={{$user['id']}}">Profile</a></td>
                    <td class="px-5"><a class="bg-blue-500 text-white p-3 rounded" href="admin/comments?id={{$user['id']}}">Comments</a></td>
                    <td class="px-5"><a class="bg-blue-500 text-white p-3 rounded" href="admin/favorites?id={{$user['id']}}">Favorites</a></td>
                </tr>                                      
            @endforeach 
            </tbody>            
        </table>
        <a class="bg-blue-500 text-white p-3 mt-5 rounded" href="admin/logs">User logs</a>  
        @if($count == 0)
            <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>
        @endif       
    </div>

</x-app-layout>


