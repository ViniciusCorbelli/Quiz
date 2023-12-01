<x-app-layout>
    <x-slot name="header">
        Atualizar Quiz
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="text-center card-title"></h5>
            <form method="POST" action="{{ route('quizzes.update', $quiz->id) }}">
                @method('PUT')
                @csrf
                <div class="mb-3 form-group">
                    <label for="title" class="form-label">Título do Quiz</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $quiz->title }}"
                        placeholder="">
                </div>
                <div class="mb-3 form-group">
                    <label for="descr" class="form-label">Descrição do Quiz</label>
                    <textarea type="text" name="descr" id="descr" class="form-control" placeholder="" rows="7">{{ $quiz->descr }}</textarea>
                </div>
                <div class="mb-3 form-group">
                    <label for="status" class="form-label">Status do Quiz</label>
                    <select class="form-control" name="status" id="status">
                        <option @if ($quiz->questions_count < 4) disabled @endif
                            @if ($quiz->status === 'publish') selected @endif value="publish">
                            Ativo
                        </option>
                        <option @if ($quiz->status === 'passive') selected @endif value="passive">Inativo</option>
                        <option @if ($quiz->status === 'draft') selected @endif value="draft">Rascunho</option>
                    </select>
                </div>

                <div class="mb-3 form-group">
                    <input type="checkbox" id="isFinished" @if ($quiz->finished_at) checked @endif
                        class="mt-1 form-check-input mt-0">
                    <label for="finished_at" class="form-label">Data de Conclusão</label>
                </div>
                <div id="finishedInput" @if (!$quiz->finished_at) style="display: none" @endif
                    class="mb-3 form-group">
                    <label for="finished_at" class="form-label">Data e Hora de Conclusão do Quiz</label>
                    <input type="datetime-local" value="{{ $quiz->finished_at}}" name="finished_at" id="finished_at"
                        class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="col-12 btn-block btn btn-outline-success">Atualizar Quiz</button>
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
