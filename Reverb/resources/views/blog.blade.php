<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-teal- personally text-teal-700 dark:text-teal-200 leading-tight">
            {{ __('Your Blogs') }}
        </h2>
    </x-slot>
    <div x-data="{showUpdateModal: null, showAddModal: false}" class="max-w-6xl mx-auto p-8 bg-gradient-to-br from-teal-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl">
        <h3 class="text-xl font-semibold text-teal-600 dark:text-teal-300 mb-6">Explore Your Blog Posts</h3>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl overflow-hidden">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-teal-700 dark:text-teal-200 mb-8">Recent Blog Posts</h3>

                        <!-- Blog Grid Layout -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="blog-list">
                            @foreach($blogs as $blog)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden blog-item transform transition duration-300 hover:scale-105 hover:shadow-xl border border-teal-100 dark:border-teal-900"
                                id="blog-{{ $blog->id }}"
                            >
                                <div class="p-6">
                                    <h4 class="text-lg font-semibold text-teal-600 dark:text-teal-300">{{ $blog->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        By <span class="font-medium text-teal-500 dark:text-teal-400">{{ $blog->user->name ?? 'Unknown Author' }}</span>
                                        on
                                        <span class="text-teal-500 dark:text-teal-400">{{ $blog->created_at ? $blog->created_at->format('M d, Y его') : 'Unknown Date' }}</span>
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 mt-3 text-sm line-clamp-3">{{ Str::limit($blog->content, 120) }}</p>
                                    <a
                                        href="{{ route('blog.show', $blog->id) }}"
                                        class="inline-block mt-4 text-teal-600 dark:text-teal-300 font-medium hover:text-teal-700 dark:hover:text-teal-200 transition-colors duration-200"
                                    >
                                        Read More
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
