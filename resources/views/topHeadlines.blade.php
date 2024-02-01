<x-app-layout>
    <div class="flex px-10 pt-10 justify-center">
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('news')">
                {{ __('All news') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('topHeadlines')" :active="true">
                {{ __('Top headlines') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('sources')">
                {{ __('Sources') }}
            </x-nav-link>
        </div>
    </div>
    <div class="flex justify-center mt-10 ">
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        Top headlines provide live top and breaking headlines for a country, specific category in a country, single source, 
        or multiple sources. You can also search with keywords. Articles are sorted by the earliest date published first.
        Top headlines are great for retrieving headlines for use with news tickers or similar.
        </p>
    </div>
    <x-flash-success />
<div class="mt-16 filter-options">
    
    <form action="" method="GET" class="flex justify-center mb-10">
        <div class="flex flex-col items-center">
            <label for="category">Category:</label>
            <select class="mr-5 form-control" name="category" id="category">
            @foreach($data['categories'] as $category => $categoryVal)
                @if($categoryVal == $options['category'])
                    <option value="{{ $categoryVal }}" selected>{{ $category }}</option>
                @else
                    <option value="{{ $categoryVal }}">{{ $category }}</option>
                @endif
            @endforeach
            </select>
        </div>
        <div class="flex flex-col items-center">
            <label for="country">Country:</label>
            <select class="mx-5 form-control" name="country" id="country">
            @foreach($data['countries'] as $country => $countryVal)
                @if($countryVal == $options['country'])
                    <option value="{{ $countryVal }}" selected>{{ $country }}</option>
                @else
                    <option value="{{ $countryVal }}">{{ $country }}</option>
                @endif
            @endforeach
            </select>
        </div>
        <div class="flex flex-col items-center">
            <label for="sources">Sources: </label>
            <input class="mx-5" type="text" id="sources" name="sources" value="{{$options['sources']}}">
        </div>
        <div class="flex flex-col items-center">
            <label for="q">Keywords:</label>
            <input class="mx-5" type="text" id="q" name="q" value="{{$options['q']}}">
        </div>
        <div class="flex flex-col items-center">
            <label for="pageSize">Results per page:</label>
            <input min="10" max="100" class="mx-5" id="number" type="number" value="{{$options['pageSize']}}" name="pageSize"/>
        </div>
        <div class="flex flex-col items-center">
            <label for="page">Page:</label>
            <input min="1" class="mx-5" id="number" type="number" value="{{$options['page']}}" name="page"/>
        </div>
        <div class="flex flex-col mx-5 items-center">
            <button class="bg-blue-500 text-white mx-4 p-2 rounded mx-auto" type="submit">Submit</button>
        </div>
    </form>
    <!--Pagination -->
    <div class="flex justify-center space-x-5 mb-10">
        @for($pages = 1; $pages <= $numOfPages; $pages++)
            @if($pages == $options['page'])
            <a class="bg-rose-500 px-3 py-1 rounded text-white motion-safe:hover:scale-[1.15]"
                href="topHeadlines?country={{$options['country']}}&category={{$options['category']}}&sources={{$options['sources']}}&q={{$options['q']}}&pageSize={{$options['pageSize']}}&page={{$pages}}">{{$pages}}</a>
            @else
            <a class="bg-blue-500 px-3 py-1 rounded text-white motion-safe:hover:scale-[1.15]"
                href="topHeadlines?country={{$options['country']}}&category={{$options['category']}}&sources={{$options['sources']}}&q={{$options['q']}}&pageSize={{$options['pageSize']}}&page={{$pages}}">{{$pages}}</a>
            @endif
        @endfor
    </div>
    <div class="mx-auto flex flex-col items-center">
            <!--Setting counter for articles -->
            @php
                $count=0;
            @endphp
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            <!--Articles -->
            @foreach ($articles as $article)
                @php $count+=1;
                $timestamp = strtotime($article['publishedAt']);
                $formattedDate = date('d.m.Y. H:i:s', $timestamp);
                @endphp
                <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent
                dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                    <div class="flex flex-col border-2 border-solid rounded">
                        <a href="{{ $article['url'] }}" class="">
                            <div class="flex flex-col main-image-div bg-cover rounded-lg px-10 pt-10 bg-black" style="background-image: url('{{ $article['urlToImage'] }}');">
                                <div class="mt-16" style="background-color: rgba(0, 0, 0, 0.6); ">
                                    <h1 class="p-2 text-xl font-semibold text-gray-900 dark:text-white rounded" style="text-shadow: 2px 2px 2px black; text-decoration: underline;">{{ $article['title'] }}</h1>
                                    @if(!empty($article['description']))
                                    <p class="p-2 text-white text-lg leading-relaxed rounded" style="text-shadow: 2px 2px 2px black;">{{ $article['description'] }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col items-end overflow-hidden" style="margin-top:10%;">
                                    <p class="mx-2 px-10 text-white text-lg leading-relaxed bg-opacity-50" style="width:60%; text-shadow: 2px 2px 2px black; margin-top: 8px; background-color: rgba(0, 0, 0, 0.7);">{{$formattedDate}}</p>
                                    @if(!empty($article['author']))
                                    <p class="mt-4 px-10 pb-2 text-white text-lg leading-relaxed" style="width:60%; text-shadow: 2px 2px 2px black; background-color: rgba(0, 0, 0, 0.7);"> Published by: {{ $article['author'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="flex flex-col items-center">
                    @if($article['title'] != '[Removed]' || $article['description'] != '[Removed]')
                    
                        @if(!isset($favorites[$article['url']]))
                            <form action="favorites" method="POST" class="my-5">
                                @csrf
                                <input type="hidden" name="url" value="{{ $article['url'] }}">
                                <input type="hidden" name="urlToImage" value="{{ $article['urlToImage'] }}">
                                <input type="hidden" name="title" value="{{ $article['title'] }}">
                                <input type="hidden" name="description" value="{{ $article['description'] }}">
                                <input type="hidden" name="author" value="{{ $article['author'] }}">
                                <input type="hidden" name="publishedAt" value="{{ $formattedDate }}">
                                <button class="hover:bg-sky-700 bg-sky-500 text-white  p-2 rounded mx-auto" type="submit">Add to favorite</button>
                            </form>
                        @else
                            <form action="favorites/{{ $favorites[$article['url']] }}" method="POST" class="mt-5 flex">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $favorites[$article['url']] }}">
                                <button class="hover:bg-rose-700 bg-rose-500 text-white mx-4 p-2 rounded mx-auto" type="submit">Remove from favorites</button>
                            </form>
                        @endif
                        <div class="border-2 border-solid flex flex-col rounded items-center">
                            <h1 class="mt-5 text-white">Comment section:</h1>
                            <form action="comments" method="POST" class="flex p-5">
                                @csrf
                                <input type="hidden" name="url" value="{{ $article['url'] }}">
                                <input type="hidden" name="title" value="{{ $article['title'] }}">
                                <textarea id="comment" name="comment" rows="2" cols="70" style="width:100%; resize: none;" placeholder="Enter your comment here."></textarea>
                                <button class="hover:bg-sky-700 bg-sky-500 text-white rounded mx-auto ml-1 px-1 " type="submit">Comment</button>
                            </form>
                            <div style="width:100%; height:150px;" class="overflow-auto mt-1">
                            @foreach ($comments[$article['url']] as $comment)
                            <div  class="m-4 p-4 text-white rounded flex flex-col" style="background-color: rgba(0, 0, 0, 0.7); text-shadow: 2px 2px 2px black;">
                                    <h1 class="mt-2">Author: {{ $comment->user->name }}</h1>
                                    <p class="mt-1">Comment: {{ $comment['comment'] }}</p>
                                    <p class="text-right py-2">{{ $comment['created_at'] }}</p>
                            </div>
                            @endforeach
                            </div>
                        </div>  
                    @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
        @if($count == 0)
            <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>
        @endif
    <div class="flex justify-center space-x-5 mt-10">
        @for($pages = 1; $pages <= $numOfPages; $pages++)
            @if($pages == $options['page'])
            <a class="bg-rose-500 px-3 py-1 rounded text-white motion-safe:hover:scale-[1.15]"
                href="topHeadlines?country={{$options['country']}}&category={{$options['category']}}&sources={{$options['sources']}}&q={{$options['q']}}&pageSize={{$options['pageSize']}}&page={{$pages}}">{{$pages}}</a>
            @else
            <a class="bg-blue-500 px-3 py-1 rounded text-white motion-safe:hover:scale-[1.15]"
                href="topHeadlines?country={{$options['country']}}&category={{$options['category']}}&sources={{$options['sources']}}&q={{$options['q']}}&pageSize={{$options['pageSize']}}&page={{$pages}}">{{$pages}}</a>
            @endif
        @endfor
    </div>
    <div class="flex justify-center space-x-4 py-10">
    {{ __("You're logged in!") }}
    </div>
</x-app-layout>