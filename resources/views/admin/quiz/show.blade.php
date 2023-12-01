<x-app-layout>
    <x-slot name="header">
        Detalhes do Quiz
    </x-slot>
    <div class="row">
        <div class="mt-2 col-12 col-md-4">
            <ul class="list-group">
                @if ($quiz->my_rank)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Classificação <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-warning text-dark">{{ $quiz->my_rank }}</span>
                    </li>
                @endif
                @if ($quiz->details)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Número de Participantes <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-info rounded-pill">{{ $quiz->details['join_count'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pontuação Média: <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="badge bg-success rounded-pill">{{ $quiz->details['average'] }}</span>
                    </li>
                @endif
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Número de Perguntas: <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    <span class="badge bg-dark rounded-pill">{{ $quiz->questions->count() }}</span>
                </li>

            </ul>
            @if (count($quiz->topTen))
                <div class="mt-2 card">
                    <div class="card-header">
                        Top 10
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
                <div class="card text-light  bg-dark text-center">
                    Informações de Participação
                </div>
                <div class="card-body">
                    <div class="table-responsive-xxl">
                        <table class="table table-bordered table-dark">
                            <thead>
                                <tr>
                                    <th>Foto do Perfil</th>
                                    <th>Nome Completo</th>
                                    <th>Pontuação</th>
                                    <th>Corretas</th>
                                    <th>Erradas</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($quiz->results as $result)
                                    <tr>
                                        <th class="bg-light text-center text-dark"><img src="{{ asset($result->user->profile_photo_url) }}" class="mx-auto d-block rounded-circle" alt=""></th>
                                        <td class="bg-light text-center text-dark">{{ $result->user->name }}</td>
                                        <td class="bg-light text-center text-dark">{{ $result->point }}</td>

                                        <td class="bg-light text-center text-dark">{{ $result->correct }}</td>
                                        <td class="bg-light text-center text-dark">{{ $result->wrong }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
