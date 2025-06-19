<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-teal-700 dark:text-teal-200 leading-tight">
            {{ $blog->title }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto p-8 bg-gradient-to-br from-teal-50 to-white dark:from-gray-900 dark:to-gray-800 rounded-2xl">
        <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl overflow-hidden">
            <div class="p-8">
                <h3 class="text-3xl font-bold text-teal-600 dark:text-teal-300 mb-4">{{ $blog->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    By <span class="font-medium text-teal-500 dark:text-teal-400">{{ $user->name ?? 'Unknown Author' }}</span>
                    on
                    <span class="text-teal-500 dark:text-teal-400">{{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Unknown Date' }}</span>
                </p>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 mb-8">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <!-- Comment Section -->
                <div class="mt-8">
                    <h4 class="text-xl font-semibold text-teal-600 dark:text-teal-300 mb-4">Comments</h4>

                    <!-- Display Comments -->
                    @if ($blog->comments->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">No comments yet. Be the first to comment!</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($blog->comments as $comment)
                                <div class="border-l-4 border-teal-500 pl-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        By <span class="font-medium text-teal-500 dark:text-teal-400">{{ $comment->user->name ?? 'Unknown Author' }}</span>
                                        on
                                        <span class="text-teal-500 dark:text-teal-400">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Comment Form -->
                    @auth
                        <div class="mt-6">
                            <h5 class="text-lg font-medium text-teal-600 dark:text-teal-300 mb-2">Add a Comment</h5>
                            @if (session('success'))
                                <div class="text-green-600 dark:text-green-400 mb-4">{{ session('success') }}</div>
                            @endif
                            <form action="{{ route('comment.store', $blog->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <textarea name="content" rows="4" class="w-full p-3 border border-teal-300 dark:border-teal-700 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Write your comment here..." required></textarea>
                                    @error('content')
                                        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-600 transition-colors duration-200">
                                    Post Comment
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 mt-4">Please <a href="{{ route('login') }}" class="text-teal-500 hover:text-teal-600">log in</a> to post a comment.</p>
                    @endif
                </div>

                <a href="{{ route('blog') }}"
                   class="inline-block mt-6 text-teal-600 dark:text-teal-300 font-medium hover:text-teal-700 dark:hover:text-teal-200 transition-colors duration-200">
                    Back to Blogs
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
