@extends('layout.default')
@section('title', 'Edit Question')
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <div class="text-sm-bold text-gray">Edit Question</div>
                <h1 class="mb-4"></h1>
                <form action="{{route('question-update',$question->id)}}" method="post">
                    @csrf <!-- CSRF token for security -->

                    <div class="form-group">
                        <label for="question">Question</label>
                        <input type="text" name="question" value="{{$question->question}}" id="question" placeholder="Enter your question here" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="question">Question Notes</label>
                        <textarea type="text" name="notes"  id="notes" placeholder="Enter your note" class="form-control">{{$question->notes}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="question">Question Label</label>
                        <textarea  name="label" id="label" placeholder="Enter your label" class="form-control">{{$question->label}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="question_type">Question Type</label>
                        <select name="question_type" id="question_type" class="form-control" onchange="showOptions(this.value)">
                            <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text Area</option>
                            <option value="multiple_choice" {{ $question->question_type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                        </select>
                    </div>

                    <div class="form-group" id="text_area_group" style="{{ $question->question_type == 'text' ? '' : 'display:none;' }}">
                        {{-- ... --}}
                    </div>

                    <div class="form-group" id="multiple_choice_group" style="{{ $question->question_type == 'multiple_choice' ? '' : 'display:none;' }}">
                        <label>Multiple Choice Answers</label>
                        <div id="multiple_choice_options">
                            {{-- Unserialize and display options --}}
                            @php
                                $options = unserialize($question->options); // Assuming 'options' is the serialized field
                            @endphp
                            @if(is_array($options))
                                @foreach($options as $option)
                                    <div class="form-row align-items-center mb-2">
                                        <div class="col">
                                            <input type="text" name="options[]" value="{{ $option }}" class="form-control">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger" onclick="deleteOption(this.parentNode.parentNode)"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addOption()" class="btn btn-info">Add Option</button>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active" {{ $question->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $question->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Update</button>
                </form>



            </div>
            <div class="page-with-help__help">
                <h2>Help: Create a Question</h2>

                {{--                @include('projects._help')--}}
            </div>
        </div>
    </div>
    <script>
        function showOptions(value) {
            if (value === 'text') {
                document.getElementById('text_area_group').style.display = 'block';
                document.getElementById('multiple_choice_group').style.display = 'none';
            } else if (value === 'multiple_choice') {
                document.getElementById('multiple_choice_group').style.display = 'block';
                document.getElementById('text_area_group').style.display = 'none';
            }
        }

        function addOption() {
            const optionsContainer = document.getElementById('multiple_choice_options');
            if (optionsContainer.children.length < 4) {
                const optionDiv = document.createElement('div');
                optionDiv.setAttribute('class', 'form-row align-items-center mb-2');

                const inputDiv = document.createElement('div');
                inputDiv.setAttribute('class', 'col');

                const newOption = document.createElement('input');
                newOption.setAttribute('type', 'text');
                newOption.setAttribute('name', 'options[]');
                newOption.setAttribute('class', 'form-control');
                newOption.setAttribute('placeholder', 'Option');

                inputDiv.appendChild(newOption);
                optionDiv.appendChild(inputDiv);

                const buttonDiv = document.createElement('div');
                buttonDiv.setAttribute('class', 'col-auto');

                const deleteButton = document.createElement('button');
                deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>'; // Font Awesome icon
                deleteButton.setAttribute('type', 'button');
                deleteButton.setAttribute('class', 'btn btn-danger');
                deleteButton.onclick = function() { deleteOption(optionDiv); };

                buttonDiv.appendChild(deleteButton);
                optionDiv.appendChild(buttonDiv);

                optionsContainer.appendChild(optionDiv);
            } else {
                alert('You can only add up to 4 options.');
            }
        }

        function deleteOption(optionElement) {
            const optionsContainer = document.getElementById('multiple_choice_options');
            optionsContainer.removeChild(optionElement);
        }


    </script>

@stop
