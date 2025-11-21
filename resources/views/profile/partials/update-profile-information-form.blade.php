<section class="profile-card">

   
<div class="profile-container">
    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        {{-- Họ tên --}}
        <label class="profile-label" for="name">
            <i class="fas fa-user mr-1"></i> Họ và tên
        </label>
        <input
            id="name"
            name="name"
            type="text"
            class="profile-input"
            value="{{ old('name', $user->name) }}"
            required
        >
        <x-input-error :messages="$errors->get('name')" class="mt-1" />

        {{-- Email --}}
        <label class="profile-label mt-3" for="email">
            <i class="fas fa-envelope mr-1"></i> Email
        </label>
        <input
            id="email"
            name="email"
            type="email"
            class="profile-input"
            value="{{ old('email', $user->email) }}"
            required
        >
        <x-input-error :messages="$errors->get('email')" class="mt-1" />

        <button class="profile-btn">
            <i class="fas fa-save mr-1"></i> Lưu thay đổi
        </button>

    </form>
</div>

</section>
