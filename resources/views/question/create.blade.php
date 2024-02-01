@extends('layout.default')
@section('title', 'Create New Question')
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <div class="text-sm-bold text-gray">Create New Question</div>
                <h1 class="mb-4"></h1>
                <form action="{{route('question-store')}}" method="post">
                    @csrf <!-- CSRF token for security -->
                    <div class="form-group">
                        <label for="question">Question Label</label>
                        <textarea  name="label" id="label" placeholder="Enter your label" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="question">Question Content</label>
                        <textarea  name="question" id="question" placeholder="Enter your question here" class="form-control">
                            </textarea>
                    </div>
                    <div class="form-group">
                        <label for="notes">Question precision</label>
                        <textarea type="text" name="notes" id="notes" placeholder="Please describe" class="form-control">Please describe</textarea>
                    </div>
                    <div class="form-group">
                        <label for="question_type">Answer type</label>
                        <select name="question_type" id="question_type" class="form-control" onchange="showOptions(this.value)">
                            <option value="text">Free text</option>
                            <option value="multiple_choice">Multiple Choice</option>
                        </select>
                    </div>

                    <div class="form-group" id="text_area_group" style="display:none;">
{{--                        <label for="text_answer">Text Answer</label>--}}
{{--                        <textarea name="text_answer" id="text_answer" class="form-control" placeholder="Enter text answer"></textarea>--}}
                    </div>

                    <div class="form-group" id="multiple_choice_group" style="display:none;">
                        <label>Multiple Choice Answers</label>
                        <div id="multiple_choice_options">
                            <!-- Options will be added here -->
                        </div>
                        <button type="button" onclick="addOption()" class="btn btn-info">Add Option</button>
                    </div>
                    <div class="form-group">
                        <label for="question_type">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">InActive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
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
            if (optionsContainer.children.length < 20) {
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
