<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="flex justify-center pt-5">            
        <h1 class="mt-6 mb-6 text-xl font-semibold text-gray-900 dark:text-black">User: {{ $user['name'] }}</h1>
    </div>

    <div class="flex justify-center my-4">
        <p style="width:50%;" class="p-3 bg-white overflow-hidden rounded shadow-sm sm:rounded-lg">
        As an admin, you can modify all user data here. 
        You can modify user profile data, edit comments, 
        edit users favorite articles and promote a user to an admin. 
        Also you can look at the history of activity logs
        
        </p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col items-center">
                <div style="width:60%;">
                <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('User Default Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's default information.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <x-input-label for="isAdmin" :value="__('Administrator')" />
                                <select class="mt-1 block w-full" name="isAdmin" id="isAdmin">
                                @foreach($data['isAdmin'] as $admin => $adminVal)
                                    @if($adminVal == $user['is_admin'])
                                        <option value="{{ $adminVal }}">{{ $admin }}</option>
                                    @else
                                        <option value="{{ $adminVal }}" selected>{{ $admin }}</option>   
                                    @endif  
                                @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <x-input-label for="country" :value="__('Country')" />
                                <select class="mt-1 block w-full" name="country" id="country">
                                @foreach($data['countries'] as $country => $countryVal)
                                    @if($countryVal == $user['country'])
                                        <option value="{{ $countryVal }}" selected>{{ $country }}</option>   
                                    @else
                                        <option value="{{ $countryVal }}">{{ $country }}</option>
                                    @endif  
                                @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="language" :value="__('Language')" />
                                <select class="mt-1 block w-full" name="language" id="language">
                                @foreach($data['languages'] as $language => $languageVal)
                                    @if($languageVal == $user['language'])
                                        <option value="{{ $languageVal }}" selected>{{ $language }}</option>
                                    @else
                                        <option value="{{ $languageVal }}">{{ $language }}</option>
                                    @endif  
                                @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                <select class="mt-1 block w-full" name="category" id="category">
                                @foreach($data['categories'] as $category => $categoryVal)
                                    @if($categoryVal == $user['category'])
                                        <option value="{{ $categoryVal }}" selected>{{ $category }}</option>   
                                    @else
                                        <option value="{{ $categoryVal }}">{{ $category }}</option>
                                    @endif  
                                @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <input class="mt-1 block w-full" type="text" value="{{$user['name']}}" name="name">
                            </div>
                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                            <p class="mt-1 text-sm text-gray-600 text-right">
                                Created at: {{$user['created_at']}} <br>
                                Updated at: {{$user['updated_at']}}
                            </p>
                            <button class="hover:bg-sky-700 bg-sky-500 text-white rounded mx-auto ml-1 p-3" type="submit">Update</button>
                        </section>     
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



