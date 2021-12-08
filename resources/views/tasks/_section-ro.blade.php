<section class="task-list">
    @foreach($order->tasks as $task)
        <?php $v = new App\Api\TasksApiItem($task, user()); ?>

        <div class="task task-collapsed">
            <div class="task__icon">
                <i class="{{ $v->iconClasses() }}"></i>
            </div>
            <div class="task__body">
                <div class="task__name">{{ $v->name }}</div>
            </div>
            <div class="task__collapse"></div>
        </div>

    @endforeach
</section>
