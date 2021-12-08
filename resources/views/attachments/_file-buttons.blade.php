<div class="field my-3">
    <div class="field__label mb-2">Create folder in OneDrive named</div>
    <div class="field__value">
        <div class="input-group">
            <input type="text" id="js-project-number" class="form-control" value="{{ projectNumber($project) }}" readonly>
            <div class="input-group-append">
                <button class="btn btn-secondary js-copy-input" data-copy="js-project-number" type="button">Copy</button>
            </div>
        </div>
    </div>
</div>

@include('projects._folder-link')
