<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Quiz;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::withCount('questions');

        if (request()->get('title')) {
            $quizzes = $quizzes->where('title', 'LIKE', '%' . request()->get('title') . '%');
        }
        if (request()->get('status')) {
            $quizzes = $quizzes->where('status', request()->get('status'));
        }
        if (request()->get('questionsCount')) {
            $quizzes = $quizzes->where('questionsCount', request()->get('questionsCount'));
        }
        $quizzes = $quizzes->paginate(5);
        return view('admin.quiz.list', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizCreateRequest $request)
    {
        $insert = Quiz::create($request->post());

        if ($insert) {
            toastr()->success($request->title . ' O questionário foi adicionado com sucesso.!', 'Gerenciamento de questionários');
            return redirect()->route('quizzes.index');
        } else {
            toastr()->error('Há um problema!', 'Gerenciamento de questionários');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::find($id)->with('topTen.user', 'results.user')->first() ?? abort(404, 'Quiz Bulunamadı');
        if ($quiz) {
            toastr()->success('Você foi direcionado para os detalhes do questionário.', 'Gerenciamento de questionários');
            return view('admin.quiz.show', compact('quiz'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::withCount('questions')->find($id) ?? abort(404, 'Nenhum questionário foi encontrado.');
        return view('admin.quiz.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizUpdateRequest $request, $id)
    {
        Quiz::find($id) ?? abort(404, 'Nenhum questionário foi encontrado.');
        $update =  Quiz::where('id', $id)->first()->update($request->except(['_method', '_token']));
        if ($update) {
            toastr()->success($request->title . ' O questionário nomeado foi atualizado com sucesso.!', 'Gerenciamento de questionários');
            return redirect()->route('quizzes.index');
        } else {
            toastr()->error('Há um problema!', 'Gerenciamento de questionários');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Quiz::find($id) ?? abort(404, 'Nenhum questionário foi encontrado.');
        $delete = Quiz::where('id', $id)->delete();
        if ($delete) {
            toastr()->success('Questionário excluído com sucesso!', 'Gerenciamento de questionários');
            return redirect()->back();
        } else {
            toastr()->error('Ocorreu um erro ao excluir!', 'Gerenciamento de questionários');
        }
    }
}
