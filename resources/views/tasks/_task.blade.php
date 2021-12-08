<?php
    if (!isset($task) || !$task instanceof \App\Models\Task) {
        throw new Exception('Undefined $task, requires Task');
    }
    $api = new \App\Api\TasksApiItem($task, user());
    $jsonState = json_encode($api);
?>
<div class="task-list">
    <task-item :task="{{ $jsonState }}" :open="true"></task-item>
</div>
