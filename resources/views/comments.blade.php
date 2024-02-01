<x-app-layout>

    <div class="flex justify-center pt-5">            
        <h1 class="mt-6 mb-6 text-xl font-semibold text-gray-900 dark:text-black">My comments</h1>
    </div>

    <div class="flex justify-center my-10">
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        Your personal comments are listed on this page. 
        You can edit your comment by clicking the "Edit comment" button. 
        Here you can remove them using the "Remove comment" button. 
        
        </p>
    </div>
<div class="mx-auto flex flex-col items-center">
            <!--Articles -->
            @php 
                $count=0;
            @endphp
        <div class="max-w-7xl mx-auto" style="width:60%;">
            <!--Articles -->
            @foreach ($comments as $comment)
                @php $count+=1;
                @endphp                                       
                <div  class="mt-6 p-4 text-white rounded flex flex-col" style="background-color: rgba(0, 0, 0, 0.7); text-shadow: 2px 2px 2px black;">
                    <a class="m-2" href="{{ $comment['url'] }}">Article url: {{ $comment['url'] }}"</a>
                    <h1 class="mt-2">Author: {{ $comment->user->name }}</h1>
                    <!--Edit comment -->
                    <form action="comments/{{ $comment['id'] }}" method="POST" class="mt-10 flex">
                        @csrf
                        @method('patch')
                        <textarea class="text-black" id="comment" name="comment" rows="2" cols="70" style="width:100%; resize: none;" placeholder="Enter your comment here.">{{$comment['comment']}}</textarea>
                        <button class="hover:bg-sky-700 bg-sky-500 text-white rounded mx-auto ml-1 px-1 " type="submit">Edit comment</button>
                    </form>
                    <p class="text-right py-4">Created at: {{ $comment['created_at'] }}</p>
                    <!-- Remove comment -->
                    <form action="comments/{{ $comment['id'] }}" method="POST" class="mt-5 flex">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" value="{{ $comment['id'] }}">
                    <button class="hover:bg-rose-700 bg-rose-500 text-white mx-4 p-2 rounded mx-auto" type="submit">Remove comment</button>
                    </form>     
                </div>
                                       
            @endforeach                        
        </div>        
    </div>   
    @if($count == 0)
        <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>
    @endif       
</div> 

<div class="flex px-10 pt-10 justify-center">
    
</div>     
</x-app-layout>


