<div class="mb-3">
    @if($project->folder_deleted)

        <div class="one-drive-link one-drive-link--missing">
            <a>
                <span class="one-drive-link__icon">@icon('folder-times')</span>
                <span class="one-drive-link__text">Folder was Deleted</span>
                <span class="one-drive-link__label">{{ $project->folder_deleted }}</span>
            </a>
        </div>

    @elseif($project->folder_url)

        <div class="one-drive-link">
            <a href="{{ $project->folder_url }}" target="_treq_files">
                <span class="one-drive-link__icon">@icon('folder')</span>
                <span class="one-drive-link__text">Open OneDrive Folder</span>
                <span class="one-drive-link__label">{{ $project->folder_name }}</span>
            </a>
        </div>

    @else

        <div class="one-drive-link one-drive-link--missing">
            <a href="mailto:ifinance@uw.edu?subject=TREQ: request for OneDrive folder creation&body=Hi, I need a TREQ OneDrive folder please. Thanks">
                <span class="one-drive-link__icon">@icon('folder')</span>
                <span class="one-drive-link__text">Missing OneDrive Folder</span>
                <span class="one-drive-link__label">
                    Click here to send an email to ask fiscal contact to set up a OneDrive folder
                </span>
            </a>
        </div>

    @endif
</div>
