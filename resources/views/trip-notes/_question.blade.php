<?php

/** @var $question Uworgws\Formkit\Input */
$questionName = $question->getName();
$value = $question->getFormValue();
$questionError = $question->getError();
$qiv = $question->getInputView();
$id = $qiv->get('id');
$label = $qiv->get('label');
$yesId = "{$id}_y";
$noId = "{$id}_n";

/** @var $note Uworgws\Formkit\Input */
$noteError = $note->getError();
$niv = $note->getInputView();
$noteId = $niv->get('id');
$noteBoxId = "{$noteId}_box";
$noteLabel = $niv->get('label');

?>
<div class="trip-note">
    <div class="trip-note__question">
        <h3 class="trip-note__legend">{{ $label }}</h3>
        <div>
            <div class="trip-notes__answers">
                <div class="form-check form-check-inline">
                    <input class="form-check-input js-trip-notes" data-target="{{ $noteBoxId }}" type="radio" name="{{ $questionName }}" id="{{ $yesId }}" value="Y" {!! checked($value, 'Y') !!}>
                    <label class="form-check-label" for="{{ $yesId }}">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input js-trip-notes" data-target="{{ $noteBoxId }}" type="radio" name="{{ $questionName }}" id="{{ $noId }}" value="N" {!! checked($value, 'N') !!}>
                    <label class="form-check-label" for="{{ $noId }}">No</label>
                </div>
            </div>
            @if($questionError)
                <div class="form-group__error text-right">{{ $questionError }}</div>
            @endif
        </div>
    </div>
    <div class="trip-note__note" id="{{ $noteBoxId }}">
        <div class="form-group{{ ($noteError) ? ' has-error' : '' }}">
            <label class="form-group__label" for="{{ $noteId }}">{{ $noteLabel }}</label>
            @include('inputs.input', ['input' => $note])
            @if($noteError)
                <div class="form-group__error">{{ $noteError }}</div>
            @endif
        </div>
    </div>
</div>
