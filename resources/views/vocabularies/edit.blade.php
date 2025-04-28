<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chỉnh sửa từ vựng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('vocabularies.update', $vocabulary->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="english" class="block text-gray-700 text-sm font-bold mb-2">Tiếng Anh:</label>
                            <input type="text" name="english" id="english" value="{{ $vocabulary->english }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="vietnamese" class="block text-gray-700 text-sm font-bold mb-2">Tiếng Việt:</label>
                            <input type="text" name="vietnamese" id="vietnamese" value="{{ $vocabulary->vietnamese }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="pronunciation" class="block text-gray-700 text-sm font-bold mb-2">Phiên âm:</label>
                            <input type="text" name="pronunciation" id="pronunciation" value="{{ $vocabulary->pronunciation }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="image_url" class="block text-gray-700 text-sm font-bold mb-2">URL hình ảnh:</label>
                            <input type="text" name="image_url" id="image_url" value="{{ $vocabulary->image_url }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cập nhật
                            </button>
                            <a href="{{ route('vocabularies.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>