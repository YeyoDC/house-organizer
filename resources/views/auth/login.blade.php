<x-guest-layout title="Login • {{ config('app.name') }} ">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="login-form" method="POST" action="{{route('login')}}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
            <x-secondary-button-link class="ms-3" href="{{route('register')}}">
                {{__('New? Register!')}}
            </x-secondary-button-link>
        </div>
    </form>
</x-guest-layout>


{{--here starts the other--}}
{{--<x-guest-layout title="Login • {{ config('app.name') }}">--}}
{{--    <!-- Alpine Login Form -->--}}
{{--    <div x-data="loginForm()" class="max-w-md mx-auto">--}}
{{--        <!-- Session Status (optional) -->--}}
{{--        <template x-if="status">--}}
{{--            <div class="mb-4 text-green-600" x-text="status"></div>--}}
{{--        </template>--}}

{{--        <!-- Error Message -->--}}
{{--        <template x-if="error">--}}
{{--            <div class="mb-4 text-red-600" x-text="error"></div>--}}
{{--        </template>--}}

{{--        <form @submit.prevent="submit">--}}
{{--            <!-- Email -->--}}
{{--            <div>--}}
{{--                <x-input-label for="email" :value="__('Email')" />--}}
{{--                <x-text-input id="email" class="block mt-1 w-full"--}}
{{--                              type="email"--}}
{{--                              name="email"--}}
{{--                              x-model="email"--}}
{{--                              required autofocus autocomplete="username" />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-input-label for="password" :value="__('Password')" />--}}
{{--                <x-text-input id="password" class="block mt-1 w-full"--}}
{{--                              type="password"--}}
{{--                              name="password"--}}
{{--                              x-model="password"--}}
{{--                              required autocomplete="current-password" />--}}
{{--            </div>--}}

{{--            <!-- Remember Me -->--}}
{{--            <div class="block mt-4">--}}
{{--                <label for="remember_me" class="inline-flex items-center">--}}
{{--                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" x-model="remember">--}}
{{--                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <!-- Submit -->--}}
{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <x-primary-button x-bind:disabled="loading">--}}
{{--                    <span x-show="!loading">{{ __('Log in') }}</span>--}}
{{--                    <span x-show="loading">{{ __('Logging in...') }}</span>--}}
{{--                </x-primary-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <!-- Alpine Script -->--}}
{{--    <script>--}}
{{--        function loginForm() {--}}
{{--            return {--}}
{{--                email: '',--}}
{{--                password: '',--}}
{{--                remember: false,--}}
{{--                loading: false,--}}
{{--                error: '',--}}
{{--                status: '',--}}
{{--                async submit() {--}}
{{--                    this.loading = true;--}}
{{--                    this.error = '';--}}
{{--                    this.status = '';--}}
{{--                    try {--}}
{{--                        const response = await fetch('/api/login', {--}}
{{--                            method: 'POST',--}}
{{--                            headers: {--}}
{{--                                'Content-Type': 'application/json',--}}
{{--                                'Accept': 'application/json',--}}
{{--                            },--}}
{{--                            body: JSON.stringify({--}}
{{--                                email: this.email,--}}
{{--                                password: this.password,--}}
{{--                                remember: this.remember--}}
{{--                            })--}}
{{--                        });--}}

{{--                        const result = await response.json();--}}

{{--                        if (!response.ok) {--}}
{{--                            this.error = result.message || 'Login failed.';--}}
{{--                            return;--}}
{{--                        }--}}

{{--                        this.status = 'Login successful. Redirecting...';--}}
{{--                        // Store token or redirect as needed--}}
{{--                        window.location.href = '/dashboard';--}}

{{--                    } catch (err) {--}}
{{--                        this.error = 'An unexpected error occurred.';--}}
{{--                    } finally {--}}
{{--                        this.loading = false;--}}
{{--                    }--}}
{{--                }--}}
{{--            };--}}
{{--        }--}}
{{--    </script>--}}
{{--</x-guest-layout>--}}



{{--<x-guest-layout title="Login • {{ config('app.name') }}">--}}
{{--    <!-- Session Status -->--}}
{{--    <x-auth-session-status class="mb-4" :status="session('status')" />--}}

{{--    <div x-data="loginForm()" x-init="init()">--}}
{{--        <form @submit.prevent="login">--}}
{{--            @csrf--}}

{{--            <!-- Email Address -->--}}
{{--            <div>--}}
{{--                <x-input-label for="email" :value="__('Email')" />--}}
{{--                <x-text-input--}}
{{--                    id="email"--}}
{{--                    class="block mt-1 w-full"--}}
{{--                    type="email"--}}
{{--                    name="email"--}}
{{--                    x-model="form.email"--}}
{{--                    required--}}
{{--                    autofocus--}}
{{--                    autocomplete="username"--}}
{{--                />--}}
{{--                <!-- Show Alpine.js validation errors -->--}}
{{--                <div x-show="errors.email" class="mt-2 text-sm text-red-600">--}}
{{--                    <span x-text="errors.email"></span>--}}
{{--                </div>--}}
{{--                <!-- Fallback to Laravel errors if no Alpine errors -->--}}
{{--                <template x-if="!errors.email">--}}
{{--                    <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--                </template>--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-input-label for="password" :value="__('Password')" />--}}
{{--                <x-text-input--}}
{{--                    id="password"--}}
{{--                    class="block mt-1 w-full"--}}
{{--                    type="password"--}}
{{--                    name="password"--}}
{{--                    x-model="form.password"--}}
{{--                    required--}}
{{--                    autocomplete="current-password"--}}
{{--                />--}}
{{--                <!-- Show Alpine.js validation errors -->--}}
{{--                <div x-show="errors.password" class="mt-2 text-sm text-red-600">--}}
{{--                    <span x-text="errors.password"></span>--}}
{{--                </div>--}}
{{--                <!-- Fallback to Laravel errors if no Alpine errors -->--}}
{{--                <template x-if="!errors.password">--}}
{{--                    <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--                </template>--}}
{{--            </div>--}}

{{--            <!-- Remember Me -->--}}
{{--            <div class="block mt-4">--}}
{{--                <label for="remember_me" class="inline-flex items-center">--}}
{{--                    <input--}}
{{--                        id="remember_me"--}}
{{--                        type="checkbox"--}}
{{--                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"--}}
{{--                        name="remember"--}}
{{--                        x-model="form.remember"--}}
{{--                    >--}}
{{--                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <!-- General Error/Success Messages -->--}}
{{--            <div x-show="message" class="mt-4">--}}
{{--                <div--}}
{{--                    :class="messageType === 'error' ? 'text-red-600 bg-red-50 border border-red-200' : 'text-green-600 bg-green-50 border border-green-200'"--}}
{{--                    class="rounded-md p-3 text-sm"--}}
{{--                >--}}
{{--                    <span x-text="message"></span>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--                <!-- Modified button to show loading state -->--}}
{{--                <button--}}
{{--                    type="submit"--}}
{{--                    :disabled="loading"--}}
{{--                    :class="loading ? 'opacity-50 cursor-not-allowed' : ''"--}}
{{--                    class="ms-3 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"--}}
{{--                >--}}
{{--                    <span x-show="!loading">{{ __('Log in') }}</span>--}}
{{--                    <span x-show="loading" class="flex items-center">--}}
{{--                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">--}}
{{--                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>--}}
{{--                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>--}}
{{--                        </svg>--}}
{{--                        {{ __('Logging in...') }}--}}
{{--                    </span>--}}
{{--                </button>--}}

{{--                <x-secondary-button-link class="ms-3" href="{{ route('register') }}">--}}
{{--                    {{ __('New? Register!') }}--}}
{{--                </x-secondary-button-link>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <script>--}}
{{--        function loginForm() {--}}
{{--            return {--}}
{{--                form: {--}}
{{--                    email: '',--}}
{{--                    password: '',--}}
{{--                    remember: false--}}
{{--                },--}}
{{--                errors: {},--}}
{{--                loading: false,--}}
{{--                message: '',--}}
{{--                messageType: '',--}}

{{--                init() {--}}
{{--                    // Pre-populate email from Laravel's old() helper if available--}}
{{--                    @if(old('email'))--}}
{{--                        this.form.email = '{{ old('email') }}';--}}
{{--                    @endif--}}
{{--                },--}}

{{--                async login() {--}}
{{--                    this.loading = true;--}}
{{--                    this.errors = {};--}}
{{--                    this.message = '';--}}

{{--                    try {--}}
{{--                        const response = await fetch('login', {--}}
{{--                            method: 'POST',--}}
{{--                            headers: {--}}
{{--                                'Content-Type': 'application/json',--}}
{{--                                'Accept': 'application/json',--}}
{{--                                'X-Client-Type' : 'web',--}}
{{--                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content--}}
{{--                            },--}}
{{--                            body: JSON.stringify(this.form)--}}
{{--                        });--}}

{{--                        const result = await response.json();--}}

{{--                        if (!response.ok) {--}}
{{--                            if (result.errors) {--}}
{{--                                // Handle Laravel validation errors--}}
{{--                                this.errors = {};--}}
{{--                                Object.keys(result.errors).forEach(field => {--}}
{{--                                    this.errors[field] = result.errors[field][0]; // Show first error only--}}
{{--                                });--}}
{{--                            }--}}
{{--                            this.message = result.message || 'Login failed';--}}
{{--                            this.messageType = 'error';--}}
{{--                            return;--}}
{{--                        }--}}

{{--                        // Success--}}
{{--                        if (result.token) {--}}
{{--                            localStorage.setItem('auth_token', result.token);--}}
{{--                        }--}}

{{--                        this.message = 'Login successful! Redirecting...';--}}
{{--                        this.messageType = 'success';--}}

{{--                        // Redirect after success--}}
{{--                        setTimeout(() => {--}}
{{--                            window.location.href = '{{ route('dashboard') }}';--}}
{{--                        }, 1000);--}}

{{--                    } catch (err) {--}}
{{--                        console.error('Login error:', err);--}}
{{--                        this.message = 'Network error. Please try again.';--}}
{{--                        this.messageType = 'error';--}}
{{--                    } finally {--}}
{{--                        this.loading = false;--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--</x-guest-layout>--}}
