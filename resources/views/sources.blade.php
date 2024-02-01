<?php 

?>
<x-app-layout>

    <div class="flex px-10 pt-10 justify-center">      
        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('news')">
                {{ __('All news') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('topHeadlines')" >
                {{ __('Top headlines') }}
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('sources')" :active="true">
                {{ __('Sources') }}
            </x-nav-link>
        </div>
    </div>
    <div class="flex justify-center mt-10">
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        Sources return the subset of news publishers that top headlines are available from. 
        It's mainly a convenience that you can use to keep track of the publishers 
        available, and you can pipe it straight through to your top headlines.
        </p>
    </div>

<div class="mt-16">
    <form action="" method="GET" class="flex justify-center items-center pl-10 pb-5">
        @csrf
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
            <label for="language">Language:</label>
            <select class="mx-5 form-control" name="language" id="language">
            @foreach($data['languages'] as $language => $languageVal)
                @if($languageVal == $options['language'])
                    <option value="{{ $languageVal }}" selected>{{ $language }}</option>
                @else
                    <option value="{{ $languageVal }}">{{ $language }}</option>
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
        <div class="flex flex-col items-center mx-5">
            <button class="bg-blue-500 text-white mx-4 p-2 rounded mx-auto" type="submit">Submit</button>
        </div>
    </form>
    
    
    <div class="grid grid-cols-1 px-10 md:grid-cols-2 gap-6 lg:gap-8"> 
        <!--Articles -->
        <?php $count=0;?>
        @foreach ($sources as $source)
            <?php 
            //Using counter so we can know the number of articles (if no articles echo no articles)
            $count+=1;
            ?>
            <a href="" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent 
                dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.03] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">                           
                <div class="bg-cover rounded-lg" style="background-image: url('');">
                <div class="mt-16 rounded" style="background-color: rgba(0, 0, 0, 0.6); ">
                    <h2 class="mt-6 p-10 text-xl font-semibold text-gray-900 dark:text-white" style="text-shadow: 2px 2px 2px black;">{{ $source['name'] }}</h2>
                    <p class="mt-4 px-10 pb-10 text-white text-lg leading-relaxed">{{ $source['description'] }}</p>
                </div>
                    
                </div>            
            </a>                   
                                                                                                    
        @endforeach                         
    </div>  
    @if($count == 0){
        <p style='color:red;padding-top:50px;text-align:center;'>No items to display.</p>"
    }
    @endif         
</div>
<div class="flex px-10 pt-10 justify-center">
    
</div>     
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
