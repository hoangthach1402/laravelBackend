<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý từ vựng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($message = Session::get('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ $message }}</span>
                    </div>
                    @endif

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('vocabularies.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Thêm từ mới</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiếng Anh</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiếng Việt</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phiên âm</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hình ảnh</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vocabularies as $vocabulary)
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $vocabulary->id }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $vocabulary->english }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $vocabulary->vietnamese }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">{{ $vocabulary->pronunciation }}</td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        @if($vocabulary->image_url)
                                        <img src="{{ $vocabulary->image_url }}" alt="{{ $vocabulary->english }}" class="h-10 w-10 object-cover">
                                        @else
                                        Không có hình
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('vocabularies.show', $vocabulary->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Xem</a>
                                            <a href="{{ route('vocabularies.edit', $vocabulary->id) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Sửa</a>
                                            <form action="{{ route('vocabularies.destroy', $vocabulary->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa từ này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">Xóa</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $vocabularies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>