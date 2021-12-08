<section class="task-list">
    @foreach($order->tasks as $task)
        <?php $v = new App\Api\TasksApiItem($task, user()); ?>

        <div class="task task-collapsed">
            <div class="task__icon">
                <i class="{{ $v->iconClasses() }}"></i>
            </div>
            <div class="task__body">
                <div class="task__name">
                    @if($task->completed_at)
                        <div>{{ $v->name }}</div>
                        <div>{{ $v->responseSummary }} ({{ $task->completer->uwnetid }}) {{ eDate($task->completed_at) }}</div>
                    @else
                        {{ $v->name }} (not complete)
                    @endif
                </div>
            </div>
            <div class="task__collapse"></div>
        </div>

    @endforeach
</section>
