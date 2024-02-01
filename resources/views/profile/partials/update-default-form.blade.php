<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Default Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's default information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        
        <div class="flex flex-col">
            <x-input-label for="country" :value="__('Country')" />
            <select class="mt-1 block w-full" name="country" id="country">
            @foreach($data['countries'] as $country => $countryVal)
                @if($countryVal == $options['country'])
                    <option value="{{ $countryVal }}" selected>{{ $country }}</option>   
                @else
                    <option value="{{ $countryVal }}">{{ $country }}</option>
                @endif  
            @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <x-input-label for="language" :value="__('Language')" />
            <select class="mt-1 block w-full" name="language" id="language">
            @foreach($data['languages'] as $language => $languageVal)
                @if($languageVal == $options['language'])
                    <option value="{{ $languageVal }}" selected>{{ $language }}</option>
                @else
                    <option value="{{ $languageVal }}">{{ $language }}</option>
                @endif  
            @endforeach
            </select>
        </div>

        <div class="flex flex-col">
            <x-input-label for="category" :value="__('Category')" />
            <select class="mt-1 block w-full" name="category" id="category">
            @foreach($data['categories'] as $category => $categoryVal)
                @if($categoryVal == $options['category'])
                    <option value="{{ $categoryVal }}" selected>{{ $category }}</option>   
                @else
                    <option value="{{ $categoryVal }}">{{ $category }}</option>
                @endif  
            @endforeach
            </select>
        </div>
        

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
