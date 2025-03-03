<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="text-xl flex justify-center">Register New User</h1>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <!-- <label class="block text-gray-700 text-sm font-bold mb-1" for="surname">
                Last Name
            </label>
            <input class="w-full bg-gray-200 text-gray-700 border rounded py-2 px-3 focus:outline-none focus:bg-white" 
                id="surname" type="text" name="surname" value="{{ old('surname') }}" required> -->
                <x-input-label for="surname" :value="__('Last Name')" />
            <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <!-- <label class="block text-gray-700 text-sm font-bold mb-1">
            Company name
            </label>
            <input class="w-full bg-gray-200 text-gray-700 border rounded py-2 px-3 focus:outline-none focus:bg-white" 
            id="company" type="text" name="company" value="{{ old('company') }}" required> -->
            <x-input-label for="company" :value="__('Company Name')" />
            <x-text-input id="company" class="block mt-1 w-full" type="text" name="company" :value="old('company')" required autofocus autocomplete="company" />
            <x-input-error :messages="$errors->get('company')" class="mt-2" />
        </div>

        <div class="mt-4">
            <!-- <label class="block text-gray-700 text-sm font-bold mb-1">
            Country
            </label>
            <input class="w-full bg-gray-200 text-gray-700 border rounded py-2 px-3 focus:outline-none focus:bg-white" 
            id="country" type="text" name="country" value="{{ old('country') }}" required> -->
            <x-input-label for="country" :value="__('Country')" />
            <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus autocomplete="country" />
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />

            <select class="w-full bg-gray-200 text-gray-700 border rounded py-2 px-3 focus:outline-none focus:bg-white" 
            id="role" name="role" required>
            <option value="">Select a Role</option>
                    <option value="Beekeeper" {{ old('role') == 'Beekeeper' ? 'selected' : '' }}>Beekeeper</option>
                    <option value="Laboratory employee" {{ old('role') == 'Laboratory employee' ? 'selected' : '' }}>Laboratory employee</option>
                    <option value="Packaging company" {{ old('role') == 'Packaging company' ? 'selected' : '' }}>Packaging company</option>
                    <option value="Wholesaler" {{ old('role') == 'Wholesaler' ? 'selected' : '' }}>Wholesaler</option>
                    <option value="Beekeeping association" {{ old('role') == 'Beekeeping association' ? 'selected' : '' }}>Beekeeping association</option>
                    <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                </select>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
