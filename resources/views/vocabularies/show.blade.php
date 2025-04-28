<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết từ vựng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Tiếng Anh:</h3>
                        <p class="text-xl">{{ $vocabulary->english }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Tiếng Việt:</h3>
                        <p class="text-xl">{{ $vocabulary->vietnamese }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Phiên âm:</h3>
                        <p class="text-xl">{{ $vocabulary->pronunciation ?? 'Không có' }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">Hình ảnh:</h3>
                        @if($vocabulary->image_url)
                            <img src="{{ $vocabulary->image_url }}" alt="{{ $vocabulary->english }}" class="mt-2 max-w-md">
                        @else
                            <p>Không có hình ảnh</p>
                        @endif
                    </div>

                    <div class="flex space-x-4 mt-6">
                        <a href="{{ route('vocabularies.edit', $vocabulary->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Chỉnh sửa</a>
                        <a href="{{ route('vocabularies.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Quay lại</a>
                        <form action="{{ route('vocabularies.destroy', $vocabulary->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Bạn có chắc chắn muốn xóa từ này?')">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>