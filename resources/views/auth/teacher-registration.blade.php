<x-guest-layout>
    <h1 class="mb-10 text-center text-2xl font-bold text-gray-700 dark:text-gray-300">
        Teacher Registration</h1>

    @if (session('success'))
        <div class="mb-4 rounded-lg border bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg border bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <x-text-input type="hidden" name="role" value="teacher" />

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" placeholder="Your Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Mobile -->
        <div>
            <x-input-label for="mobile" :value="__('Mobile')" class="mt-4" />
            <x-text-input id="mobile" class="mt-1 block w-full" type="tel" name="mobile" :value="old('mobile')"
                required placeholder="10 digit Mobile Number" />
            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
        </div>

        <!-- Standards -->
        <x-input-label for="standards" :value="__('Select Classes')" class="mt-4" />
        <div id="standards" class="flex flex-wrap">
            @foreach ($standards as $standard)
                <div class="flex w-32 items-center gap-2 p-2">
                    <x-text-input id="standard{{ $standard->id }}" class="p-2" type="checkbox" name="standard_id[]"
                        value="{{ $standard->id }}" />
                    <x-input-label for="standard{{ $standard->id }}" :value="$standard->name" class="inline" />
                </div>
            @endforeach
        </div>

        <!-- Code -->
        <div class="mt-4">
            <x-input-label for="code" :value="__('Code')" />
            <x-text-input id="code" class="mt-1 block w-full" type="text" name="code" required
                placeholder="Your School Code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
