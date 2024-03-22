<?php

namespace App\Http\Controllers;


use App\Models\Question;
use Illuminate\Http\Request;
use Utilws\Formkit\RandomString;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('question.index', compact('questions'));
    }

    public function create()
    {
        return view('question.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'question_type' => 'required',
        ]);

        if ($request->input('question_type') == 'multiple_choice') {
            $request->validate([
                'options' => 'required|array|min:1', // Validate options only for multiple_choice
            ]);
        }

        // Process the label input
        $labelInput = $request->input('label');
        $randomIdValue = new RandomString();
        $processedLabel = preg_replace(array('/[^\w\s]+/', '/[^a-z0-9]+/'), array('', '_'), strtolower(trim($labelInput))) . $randomIdValue->generate(4);

        // Ensure the label is unique
        // $baseLabel = $processedLabel;
        // $counter = 1;
        // while (Question::where('item', $processedLabel)->exists()) {
        //     $processedLabel = $baseLabel . '_' . $counter;
        //     $counter++;
        // }

        // Create the question
        Question::create([
            'question' => $request->input('question'),
            'notes' => $request->input('notes'),
            'label' => $request->input('label'),
            'question_required' => $request->input('question_required'),
            'question_type' => $request->input('question_type'),
            'options' => isset($request->options) ? serialize($request->options) : null,
            'status' => $request->input('status'),
            'item' => $processedLabel, // Save the processed label
        ]);

        return redirect()->route('question-index');
    }

    public function edit($id)
    {
        $question = Question::find($id);
        return view('question.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'question_type' => 'required',
        ]);

        if ($request->input('question_type') == 'multiple_choice') {
            $request->validate([
                'options' => 'required|array|min:1', // Validate options only for multiple_choice
            ]);
        }
        $question = Question::find($id);
        $question->question = $request->input('question');
        $question->notes = $request->input('notes');
        $question->question_type = $request->input('question_type');
        $question->options = serialize($request->options);
        $question->status = $request->input('status');
        $question->label = $request->input('label');
        $question->question_required = $request->input('question_required');
        $question->save();
        return redirect()->route('question-index');
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return redirect()->route('question-index');
    }
}
