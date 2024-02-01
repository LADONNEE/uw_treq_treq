@extends('layout/default')
@section('title', 'Manage Workflow')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Manage Workflow Content</h1>
            </div>


            <div class="panel-full-width mb-5">
                <table class="table-tight sortable">
                    <thead>
                    <tr>
                        <th>Title</th>
{{--                        <th>Content</th>--}}
                        <th style="width:20%;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($help as $data)

                        <tr>
                            <td>
                                {{$data->title}}
                            </td>
{{--                            <td>{!!  strlen($data->content) > 50 ? substr($data->content, 0, 50) . '...' : $data->content  !!}</td>--}}

                            <td>
                                <a href="{{ route('workflowmanagement-edit',$data->id) }}" class="btn btn-primary btn-sm"><i
                                        class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


        </section>
    </div>
@stop
