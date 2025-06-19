<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-teal-700 dark:text-teal-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div x-data="{ showUpdateModal: null, showAddModal: false }"
        class="max-w-6xl mx-auto p-6 bg-gradient-to-br from-teal-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-lg relative">
        <h3 class="text-lg font-semibold text-teal-600 dark:text-teal-300 mb-4">Your Blogs</h3>
        <button @click="showAddModal = true"
            class="bg-teal-600 text-white rounded-lg py-2 px-4 mb-4 hover:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-400 transition-colors duration-200">Add
            Blog</button>

        <table class="w-full border-collapse">
            <thead class="bg-teal-100 dark:bg-teal-900">
                <tr>
                    <th
                        class="border border-teal-200 dark:border-teal-700 px-4 py-2 text-left text-teal-600 dark:text-teal-200">
                        Title</th>
                    <th
                        class="border border-teal-200 dark:border-teal-700 px-4 py-2 text-left text-teal-600 dark:text-teal-200">
                        Content</th>
                    <th
                        class="border border-teal-200 dark:border-teal-700 px-4 py-2 text-left text-teal-600 dark:text-teal-200">
                        Created At</th>
                    <th
                        class="border border-teal-200 dark:border-teal-700 px-4 py-2 text-left text-teal-600 dark:text-teal-200">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->blogs as $blog)
                    <tr
                        class="border border-teal-200 dark:border-teal-700 hover:bg-teal-50 dark:hover:bg-gray-800 transition-colors duration-200">
                        <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $blog->title }}</td>
                        <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ Str::limit($blog->content, 100) }}
                        </td>
                        <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $blog->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <button @click="showUpdateModal = {{ $blog->id }}"
                                class="text-teal-500 hover:text-teal-600 dark:hover:text-teal-400">Update</button>
                            <form action="{{ route('blog.destroy', $blog->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-600 dark:hover:text-red-400">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Update Modal -->
                    <div x-show="showUpdateModal === {{ $blog->id }}" x-cloak
                        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96 shadow-xl">
                            <h3 class="text-lg font-semibold text-teal-600 dark:text-teal-300 mb-4">Update Blog</h3>
                            <form action="{{route('blog.update', $blog->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" name="title" value="{{ $blog->title }}"
                                    class="w-full p-2 border border-teal-200 dark:border-teal-700 rounded-lg mb-2 bg-teal-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                <textarea name="content" rows="4"
                                    class="w-full p-2 border border-teal-200 dark:border-teal-700 rounded-lg mb-2 bg-teal-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">{{ $blog->content }}</textarea>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="showUpdateModal = null"
                                        class="bg-gray-400 dark:bg-gray-600 px-4 py-2 rounded-lg text-white hover:bg-gray-500 dark:hover:bg-gray-500 transition-colors duration-200">Cancel</button>
                                    <button type="submit"
                                        class="bg-teal-600 px-4 py-2 rounded-lg text-white hover:bg-teal-700 dark:hover:bg-teal-500 transition-colors duration-200">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Add Modal -->
        <div x-show="showAddModal" x-cloak
            class="fixed inset–0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96 shadow-xl">
                <h3 class="text-lg font-semibold text-teal-600 dark:text-teal-300 mb-4">Add Blog</h3>
                <form action="{{ route('blog.store') }}" method="POST">
                    @csrf
                    <input type="text" name="title" placeholder="Enter blog title"
                        class="w-full p-2 border border-teal-200 dark:border-teal-700 rounded-lg mb-2 bg-teal-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                        required>
                    <textarea name="content" rows="4" placeholder="Enter blog content"
                        class="w-full p-2 border border-teal-200 dark:border-teal-700 rounded-lg mb-2 bg-teal-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                        required></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAddModal = false"
                            class="bg-gray-400 dark:bg-gray-600 px-4 py-2 rounded-lg text-white hover:bg-gray-500 dark:hover:bg-gray-500 transition-colors duration-200">Cancel</button>
                        <button type="submit"
                            class="bg-teal-600 px-4 py-2 rounded-lg text-white hover:bg-teal-700 dark:hover:bg-teal-500 transition-colors duration-200">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
