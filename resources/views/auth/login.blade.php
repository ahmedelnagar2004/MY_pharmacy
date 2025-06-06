<x-guest-layout>
    <div class="card-header bg-success text-white text-center">
        <h3>{{ __('تسجيل الدخول') }}</h3>
    </div>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">{{ __('تذكرني') }}</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('نسيت كلمة المرور؟') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4">
        <div class="text-center mb-3">
            <span class="divider">{{ __('أو تسجيل الدخول باستخدام') }}</span>
        </div>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('socialite.redirect', 'google') }}" class="btn btn-outline-danger w-100">
                <i class="fab fa-google me-2"></i>Google
            </a>
            
            <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn btn-outline-primary w-100">
                <i class="fab fa-facebook-f me-2"></i>Facebook
            </a>
        </div>
    </div>
</x-guest-layout>



