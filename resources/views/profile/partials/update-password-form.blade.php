<script src="/js/profile.js"></script>

<section class="profile-card">
    <p class="section-desc">
        Hãy sử dụng mật khẩu mạnh để bảo vệ tài khoản của bạn tốt hơn.
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- Mật khẩu hiện tại --}}
        <div class="mb-3">
            <label class="profile-label">Mật khẩu hiện tại</label>

            <div class="password-wrapper">
                <input 
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="profile-input"
                    autocomplete="current-password"
                >

                <i class="fas fa-eye-slash password-toggle"
                   onclick="togglePassword('current_password', this)"></i>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" 
                           class="mt-1 text-danger" />
        </div>

        {{-- Mật khẩu mới --}}
        <div class="mb-3">
            <label class="profile-label">Mật khẩu mới</label>

            <div class="password-wrapper">
                <input 
                    id="new_password"
                    name="password"
                    type="password"
                    class="profile-input"
                    autocomplete="new-password"
                >

                <i class="fas fa-eye-slash password-toggle"
                   onclick="togglePassword('new_password', this)"></i>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" 
                           class="mt-1 text-danger" />
        </div>

        {{-- Xác nhận mật khẩu --}}
        <div class="mb-3">
            <label class="profile-label">Xác nhận mật khẩu</label>

            <div class="password-wrapper">
                <input 
                    id="confirm_password"
                    name="password_confirmation"
                    type="password"
                    class="profile-input"
                    autocomplete="new-password"
                >

                <i class="fas fa-eye-slash password-toggle"
                   onclick="togglePassword('confirm_password', this)"></i>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" 
                           class="mt-1 text-danger" />
        </div>

        <button class="profile-btn">
            <i class="fas fa-save mr-1"></i> Lưu thay đổi
        </button>

        @if (session('status') === 'password-updated')
            <p class="text-success mt-2">Đã lưu.</p>
        @endif

    </form>
</section>
