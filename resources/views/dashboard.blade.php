<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Bạn đã đăng nhập thành công!") }}
                </div>
            </div>
            
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quản lý ứng dụng</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('vocabularies.index') }}" class="block p-6 bg-blue-100 hover:bg-blue-200 rounded-lg">
                            <h4 class="text-xl font-bold mb-2">Quản lý từ vựng</h4>
                            <p>Thêm, sửa, xóa và xem danh sách từ vựng Anh-Việt</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="block p-6 bg-green-100 hover:bg-green-200 rounded-lg">
                            <h4 class="text-xl font-bold mb-2">Quản lý tài khoản</h4>
                            <p>Cập nhật thông tin cá nhân và mật khẩu</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

## 8. Cập nhật Dashboard

Chỉnh sửa file `resources/views/dashboard.blade.php` để thêm liên kết đến quản lý từ vựng:
