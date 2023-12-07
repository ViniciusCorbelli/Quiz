<x-app-layout>
    <x-slot name="header">
        TRIVIA
    </x-slot>
    <div class="row">
        <div class="col-md-8">
            <div class="m-5 list-group">
                @foreach ($quizzes as $quiz)
                    <a href="{{ route('quiz.detail', $quiz->slug) }}"
                        class="mt-2 list-group-item list-group-item-action flex-column align-items-start"
                        aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1 display-6">{{ $quiz->title }}</h5>
                            @if ($quiz->finished_at)
                                <small
                                    class="text-dark">{{ \Carbon\Carbon::parse($quiz->finished_at)->diffForHumans()}}</small>
                            @else
                                <small class="text-dark">Não especificado</small>
                            @endif
                        </div>
                        <p class="mb-1">{{ Str::limit($quiz->descr, 100) }}</p>
                        <small class="text-muted ">Total {{ $quiz->questions_count }} Pergunta</small>
                    </a>
                @endforeach

                @if($quizzes->hasPages())
                    <div class="shadow-lg p-3 mt-5 mb-5 bg-body rounded"> <b>
                            {{ $quizzes->links() }}</b></div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
