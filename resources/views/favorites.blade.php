<?php 

?>
<x-app-layout>

    <div class="flex justify-center pt-5">            
        <h1 class="mt-6 mb-6 text-xl font-semibold text-gray-900 dark:text-black">Favorite articles</h1>
    </div>

    <div class="flex justify-center my-10">
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        Your favorite articles are listed on this page. 
        You can add your favorite article on one of the 
        main pages by clicking the "Add to favorite" button. 
        Here you can remove them using the "Remove from favorite" button. 
        </p>
    </div>
<div class="mx-auto flex flex-col items-center">
            <!--Articles -->
            @php 
                $count=0;
            @endphp
        <div class="max-w-7xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            <!--Articles -->
            @foreach ($favorites as $favorite)
                @php $count+=1;
                @endphp                                       
                <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent 
                dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                    <div class="flex flex-col">
                        <a href="{{ $favorite['url'] }}" >
                            <div class="flex flex-col main-image-div bg-cover rounded-lg px-10 pt-10 bg-black" style="background-image: url('{{ $favorite['urlToImage'] }}');">
                                <div class="mt-16" style="background-color: rgba(0, 0, 0, 0.6); ">
                                    <h1 class="p-2 text-xl font-semibold text-gray-900 dark:text-white rounded" style="text-shadow: 2px 2px 2px black; text-decoration: underline;">{{ $favorite['title'] }}</h1>
                                    @if(!empty($favorite['description']))
                                    <p class="p-2 text-white text-lg leading-relaxed rounded" style="text-shadow: 2px 2px 2px black;">{{ $favorite['description'] }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col items-end overflow-hidden" style="margin-top:10%;">
                                    <p class="mx-2 px-10 text-white text-lg leading-relaxed bg-opacity-50" style="width:60%; text-shadow: 2px 2px 2px black; margin-top: 8px; background-color: rgba(0, 0, 0, 0.7);">{{$favorite['publishedAt']}}</p>
                                    @if(!empty($favorite['author']))
                                    <p class="mt-4 px-10 pb-2 text-white text-lg leading-relaxed" style="width:60%; text-shadow: 2px 2px 2px black; background-color: rgba(0, 0, 0, 0.7);"> Published by: {{ $favorite['author'] }}</p>
                                    @endif
                                   
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="flex flex-col items-center">  
                    <form action="favorites/{{ $favorite['id'] }}" method="POST" class="mt-5">
                        @csrf
                        @method('delete')
                        <button class="hover:bg-rose-700 bg-rose-500 text-white mx-4 p-2 rounded mx-auto" type="submit">Remove from favorites</button>
                    </form>
                    </div>
                </div>                      
            @endforeach                  
            </div>         
        </div>        
    </div>   
    @if($count == 0)
        <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>
    @endif       
</div> 

<div class="flex px-10 pt-10 justify-center">
    
</div>     
</x-app-layout>


