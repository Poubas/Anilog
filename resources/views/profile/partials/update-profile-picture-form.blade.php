<!-- filepath: /home/magro/facul/anilog/anilog-app/resources/views/profile/partials/update-profile-picture-form.blade.php -->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile picture.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.updatePicture') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
        </div>

        @if (Auth::user()->profile_picture)
            <div class="mt-4">
                <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-full h-20 w-20 object-cover">
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-picture-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>