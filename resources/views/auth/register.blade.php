<x-guest-layout>
    <h1 class="text-center">Registration</h1><br>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        $(document).on('input', function() {
        //  $('#errordiv').remove();
         $('.text-sm').find('li').remove();
        });
    </script>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- CID -->
        <div class="mt-4">
            <x-input-label for="cid" :value="__('CID Number')" />
            <x-text-input id="cid" class="block mt-1 w-full" type="number" name="cid" :value="old('cid')" required
                autofocus autocomplete="cid" maxlength="11" />
            <span id="cid-error" style="color: red;"></span>
            <x-input-error :messages="$errors->get('cid')" class="mt-2" />
        </div>

        <!-- Organization -->
        <div class="mt-4">
            <x-input-label for="organization" :value="__('Organization Name')" />
            <select id="organization" class="block mt-1 w-full" name="organization" required autofocus>
                <option value="">Select an organization</option>
                @foreach($organizations as $organization)
                <option value="{{ $organization->id }}">{{ $organization->org_name}}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('organization')" class="mt-2"   />
        </div>
        {{-- <div class="mt-4">
            <x-input-label for="organization" :value="__('Organization Name')" />
            <x-text-input id="organization" class="block mt-1 w-full" type="text" name="organization"
                :value="old('organization')" required autofocus autocomplete="organization" />
            <x-input-error :messages="$errors->get('organization')" class="mt-2" />
        </div> --}}

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mobile number -->
        <div class="mt-4">
            <x-input-label for="contact" :value="__('Mobile Number')" />
            <x-text-input id="contact" class="block mt-1 w-full" type="number" name="contact" :value="old('contact')"
                required autofocus autocomplete="contact" maxlength="8" />
            <span id="phone-error" style="color: red;"></span>
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Multiple CID photos -->
        <div class="mt-4">
            <x-input-label for="files" :value="__('Upload CID (Front)')" />
            <input id="files" name="files[]" type="file" class="mt-1 block w-full" accept=".jpg, .jpeg, .png, .pdf"
                required multiple />
            <x-input-error class="mt-2" :messages="$errors->get('files.*')" />
        </div>

        <!--CID photo-->
        {{-- <div class="mt-4">
            <x-input-label for="file" :value="__('Upload File')" />
            <input id="file" name="file" type="file" class="mt-1 block w-full" accept=".jpg, .jpeg, .png, .pdf"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('file')" />
        </div> --}}

        <div class="flex items-center justify-right mt-4">
            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
            {{-- <a
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="/">
                {{ __('Login') }}
            </a> --}}
        </div>

        <script>
            const inputElement_cid = document.getElementById('cid');
            const phoneErrorElement_cid = document.getElementById('cid-error');
            const inputElement = document.getElementById('contact');
            const phoneErrorElement = document.getElementById('phone-error');
    
            inputElement.addEventListener('blur', function() {
                
                const inputValue = inputElement.value.trim();
                const isValid = inputValue.length === 8 && (inputValue.startsWith('16') || inputValue.startsWith('17'));
    
                // Update error message based on validation result
                if (isValid) {
                    phoneErrorElement.textContent = '';
                } else {
                    phoneErrorElement.textContent = 'Invalid mobile number. Please start with 16 or 17 and use 8 digits.';
                }
            });

            inputElement_cid.addEventListener('blur', function() {
                
                const inputValue = inputElement_cid.value.trim();
                const isValid = inputValue.length === 11;
    
                // Update error message based on validation result
                if (isValid) {
                    phoneErrorElement_cid.textContent = '';
                } else {
                    phoneErrorElement_cid.textContent = 'CID should be 8 digits numbers.';
                }
            });
        </script>
    </form>
</x-guest-layout>