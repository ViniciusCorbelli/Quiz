<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Result;

class MainController extends Controller
{
    public function dashboard()
    {
        $quizzes = Quiz::where('status', 'publish')->where(function ($query) {
            $query->whereNull('finished_at')->orWhere('finished_at', '>', now());
        })->withCount('questions')->paginate(10);
        $results =  auth()->user()->results;
        return view('dashboard', compact('quizzes', 'results'));
    }
    public function quiz_detail($slug)
    {
        $quiz = Quiz::whereSlug($slug)->with('my_result', 'topTen.user')->withCount('questions')->first() ?? abort(404, 'Questionário não encontrado!');
        return view('quiz_detail', compact('quiz'));
    }
    public function quiz($slug)
    {
        $quiz = Quiz::whereSlug($slug)->with('questions.my_answer', 'my_result')->first() ?? abort(404, 'Questionário não encontrado');
        if ($quiz->my_result) {
            toastr()->success('Você foi direcionado para a página de resultados do questionário.', 'Gerenciamento de questionários');
            return view('quiz_result', compact('quiz'));
        }

        return view('quiz', compact('quiz'));
    }
    public function result(Request $request, $slug)
    {
        $quiz = Quiz::with('questions')->whereSlug($slug)->first() ?? abort(404, 'Questionário não encontrado');
        $correct = 0;
        if ($quiz->my_result) {
            abort(404, 'Você já participou deste quiz antes.');
        }
        foreach ($quiz->questions as $question) {
            Answer::create([
                'user_id' => auth()->user()->id,
                'question_id' => $question->id,
                'answer' => $request->post($question->id)
            ]);
            if ($question->correct_answer === $request->post($question->id)) {
                $correct += 1;
            }
        }

        $point = round((100 / count($quiz->questions)) * $correct);
        $wrong = count($quiz->questions) - $correct;

        $create =  Result::create([
            'user_id' => auth()->user()->id,
            'quiz_id' => $quiz->id,
            'point' =>  $point,
            'correct' => $correct,
            'wrong' => $wrong,
        ]);

        if ($create) {
            toastr()->success($quiz->title . ' Você completou o quiz com sucesso! (' . $point . ')');
            return redirect()->route('dashboard');
        } else {
            toastr()->error('Há um problema!', 'Gerenciamento de questionários');
            return redirect()->back();
        }
    }
}
