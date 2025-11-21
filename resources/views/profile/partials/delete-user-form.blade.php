<section class="profile-card">
<div class="profile-section">


    <p class="section-desc">
        Sau khi xóa, toàn bộ dữ liệu của bạn sẽ bị xóa vĩnh viễn. Hãy chắc chắn trước khi thực hiện.
    </p>

    <button class="delete-btn"
            x-data
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        <i class="fas fa-trash mr-2"></i> Xóa tài khoản
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()">
        <form class="p-4" method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <h4 class="mb-3 text-danger">Bạn có chắc muốn xóa tài khoản?</h4>

            <label class="profile-label">Nhập mật khẩu để xác nhận</label>
            <input type="password" name="password" class="profile-input">

            <button class="delete-btn mt-3">Xóa vĩnh viễn</button>
        </form>
    </x-modal>
</div>


</section>
