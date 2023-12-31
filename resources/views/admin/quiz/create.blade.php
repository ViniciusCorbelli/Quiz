<x-app-layout>
    <x-slot name="header">
        Criar Quiz
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="text-center card-title"></h5>
            <form method="POST" action="{{ route('quizzes.store') }}">
                @csrf
                <div class="mb-3 form-group">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}"
                        placeholder="">
                </div>
                <div class="mb-3 form-group">
                    <label for="descr" class="form-label">Descrição do Quiz</label>
                    <textarea type="text" name="descr" id="descr" class="form-control" value="{{ old('descr') }}" placeholder=""
                        rows="7"></textarea>
                </div>
                <div class="mb-3 form-group">
                    <input type="checkbox" id="isFinished" @if (old("finished_at")) checked @endif class="mt-1 form-check-input mt-0">
                    <label for="finished_at" class="form-label">Data de Conclusão</label>
                </div>
                <div id="finishedInput" @if (!old("finished_at"))   style="display: none" @endif class="mb-3 form-group">
                    <label for="finished_at" class="form-label">Data e Hora de Conclusão do Quiz</label>
                    <input type="datetime-local" value="{{ old('finished_at') }}" name="finished_at" id="finished_at"
                        class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="col-12 btn-block btn btn-outline-success">Criar Quiz</button>
                </div>
            </form>
        </div>
    </div>
    <x-slot name="js">
        <script>
            $("#isFinished").change(function() {
                if ($("#isFinished").is(":checked")) {
                    $("#finishedInput").show();
                } else {
                    $("#finishedInput").hide();
                }
            });

        </script>
    </x-slot>
</x-app-layout>
