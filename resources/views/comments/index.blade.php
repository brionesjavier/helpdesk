

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('comments.store', $ticketId) }}" method="POST">
                        @csrf
                        <textarea name="content" required></textarea>
                        <button type="submit">Comentar</button>
                    </form>
                    
                    <ul>
                        @foreach($comments as $comment)
                            <li>{{ $comment->content }} - {{ $comment->created_at }}</li>
                        @endforeach
                    </ul>

                </div>
               
            </div>
        </div>
    </div>
</x-app-layout>