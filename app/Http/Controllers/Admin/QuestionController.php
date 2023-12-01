<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionUpdateRequest;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $quiz = Quiz::whereId($id)->with('questions')->first() ?? abort(404, 'Questionário não encontrado.');
        return view('admin.question.list', compact('quiz'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $quiz = Quiz::find($id);
        return view('admin.question.create', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionCreateRequest $request, $id)
    {
        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName);
            $request->merge([
                'image' => $fileNameWithUpload
            ]);
        }

        $insert = Quiz::find($id)->questions()->create($request->post());
        if ($insert) {
            toastr()->success($request->title . ' A pergunta nomeada foi criada com sucesso!', 'Gerenciamento de perguntas');
            return redirect()->route('quizzes.index', $id);
        } else {
            toastr()->error('Há um problema!', 'Gerenciamento de perguntas');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($quiz_id, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quiz_id, $question_id)
    {
        $question = Quiz::find($quiz_id)->questions()->whereId($question_id)->first() ?? abort(404, 'Nenhuma página encontrada.');
        return view('admin.question.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionUpdateRequest $request, $quiz_id, $question_id)
    {
        if ($request->hasFile('image')) {
            $fileName = Str::slug($request->question) . '.' . $request->image->extension();
            $fileNameWithUpload = 'uploads/' . $fileName;
            $request->image->move(public_path('uploads'), $fileName);
            $request->merge([
                'image' => $fileNameWithUpload
            ]);
        }

        $update = Quiz::find($quiz_id)->questions()->whereId($question_id)->first()->update($request->post());
        if ($update) {
            toastr()->success($request->title . ' A pergunta nomeada foi atualizada com sucesso.!', 'Gerenciamento de perguntas');
            return redirect()->route('questions.index', $quiz_id);
        } else {
            toastr()->error('Há um problema!', 'Gerenciamento de perguntas');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz_id, $question_id)
    {
        $delete = Quiz::find($quiz_id)->questions()->whereId($question_id)->delete();
        if ($delete) {
            toastr()->success('Pergunta excluída com sucesso!', 'Gerenciamento de perguntas');
            return redirect()->route('questions.index', $quiz_id);
        } else {
            toastr()->error('Ocorreu um erro ao excluir!', 'Gerenciamento de perguntas');
        }
    }
}
