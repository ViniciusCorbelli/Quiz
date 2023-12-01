<x-app-layout>
    <x-slot name="header">
        Detalhes do questionário
    </x-slot>
    <div class="row">
        <div class="mt-2 col-12 col-md-4">
            <ul class="list-group">
                @if ($quiz->my_rank)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Posição <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-warning text-dark">{{ $quiz->my_rank }}</span>
                    </li>
                @endif
                @if ($quiz->my_result)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Ponto <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-success rounded-pill">{{ $quiz->my_result->point }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Certo <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-primary rounded-pill">{{ $quiz->my_result->correct }}</span>
                        Errado
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-warning rounded-pill">{{ $quiz->my_result->wrong }}</span>
                    </li>
                @endif
                @if ($quiz->details)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Número de participantes <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-info rounded-pill">{{ $quiz->details['join_count'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pontuação Média: <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-success rounded-pill">{{ $quiz->details['average'] }}</span>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Número de perguntas: <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    <span class="badge bg-dark rounded-pill">{{ $quiz->questions_count }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Prazo final para teste: <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    <p class="text-danger ">
                        <span @if ($quiz->finished_at) title="($quiz->finished_at)" @endif
                            class="badge bg-danger rounded-pill">
                            @if ($quiz->finished_at)
                                {{ \Carbon\Carbon::parse($quiz->finished_at)->diffForHumans(now()) . ' está acabando' }}
                            @else
                            Sem informações de data
                            @endif
                        </span>
                </li>
            </ul>
            @if (count($quiz->topTen))
                <div class="mt-2 card">
                    <div class="card-header">
                        10 melhores
                    </div>
                    <ul class="list-group">
                        @foreach ($quiz->topTen as $result)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <strong>{{ $loop->iteration }}.</strong>
                                <img src="{{ $result->user->profile_photo_url }}" class="w-8 rounded-circle float-left"
                                    alt="">
                                <span @if (auth()->user()->id == $result->user_id) class="badge bg-warning text-dark" @endif>
                                    {{ $result->user->name }}</span>
                                <span class="badge bg-dark rounded-pill"><i class="fa fa-hand-pointer m-1"
                                        aria-hidden="true"></i>{{ $result->point }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="mt-2 col-12 col-md-8">
            <div class="card">
                <div class="card text-dark  bg-light text-center">
                    <img class="card-img-center img-fluid mx-auto d-block"
                        src="https://www.securecare.com/wp-content/uploads/2021/03/page-header-background.jpg"
                        alt="Card image cap">
                    <div class="card-img-overlay">
                        <div class="mt-3 text-white card-header">
                            {{ $quiz->title }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Bem-vindo!</strong> Depois de obter informações detalhadas sobre o questionário, clique no botão.
                            Você pode começar clicando.
                            </button>
                        </div>
                        <div class="card-footer text-dark">
                            <p class="card-text">{{ $quiz->descr }}</p>
                        </div>
                    </div>
                </div>
                @if (!$quiz->my_result)
                    <a href="{{ route('quiz.join', $quiz->slug) }}" class="btn mt-2 col-12 btn-outline-dark">Começar</a>
                @elseif ($quiz->finished_at>now())
                    <a href="{{ route('quiz.join', $quiz->slug) }}" class="btn mt-2 col-12 btn-outline-success">Resultados do questionário
                        </a>
                @endif
                <br>
            </div>
        </div>
    </div>
</x-app-layout>
