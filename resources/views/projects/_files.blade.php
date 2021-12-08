<?php
if (!isset($project) && isset($order)) {
    $project = $order->project;
}
?>
<section class="mt-5">
    <h2 class="text-lg">Attachments</h2>

    @include('projects._folder-link')

    <div class="field">
        <div class="field__label mb-2">Project Folder Name</div>
        <div class="field__value">
            @projectNumber($project)
        </div>
    </div>

    <div class="field">
        <div class="field__label mb-2">About Attachments</div>
        <div class="field__value">
            <p class="mt-0">
                The fiscal team will provide you a OneDrive folder to upload your files
                related to this project. If you don't have a folder, or don't have access
                to the provided folder, contact your project's fiscal contact.
                <a href="{{ route('help', 'attachments') }}" target="_help">
                    More attachment help @icon('external-link')
                </a>
            </p>
        </div>
    </div>

</section>
