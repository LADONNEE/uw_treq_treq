@extends('layout/default')
@section('title', 'Manage Questions')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manage Questions</h1>
                <a href="{{ route('question-create') }}" class="btn btn-info">Create</a>
            </div>


            <div class="panel-full-width mb-5">
                <table class="table-tight sortable">
                    <thead>
                    <tr>
                        <th>Question Label </th>
                        <th >Question #</th>
                        <th style="width:15%;">Question Type</th>

                        <th style="width:20%;">Status</th>
                        <th style="width:20%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)

                        <tr>
                            <td>
                                {{$question->label}}
                            </td>
                            <td>{{ strlen($question->question) > 50 ? substr($question->question, 0, 50) . '...' : $question->question }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $question->question_type)) }}</td>



                            <td>
                                {{$question->status}}
                            </td>
                            <td>
                                <a href="{{ route('question-edit',$question->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('question-delete',$question->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


        </section>
    </div>
@stop
