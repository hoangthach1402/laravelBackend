<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">Tên</label>
            <input id="name" type="text" name="name" required autofocus>
        </div>

        <!-- Email Address -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password">Mật khẩu</label>
            <input id="password" type="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation">Nhập lại mật khẩu</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">
                Đăng ký
            </button>
        </div>
    </form>
</x-guest-layout>
