<?php

$filename = 'treq_'.date('Y-m-d').'.csv';

header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename='.$filename);

echoCsvRow([
    'ID',
    'Project ID',
    'Type',
    'Stage',
    'submitted_at',
    'submitted_by',
    'amount',
    'active_at',
    'notified_at',
    'assigned_to',
    'on_call',
    'created_at',
    'updated_at',

]);

foreach ($reportdata as $order) {
    echoCsvRow([
        $order->id,
        $order->project_id,
        $order->type,
        $order->stage,
        $order->submitted_at?? '',
        $order->submitted_by,
        $order->amount?? '',
        $order->active_at?? '',
        $order->notified_at?? '',
        $order->assigned_to?? '',
        $order->on_call?? '',
        $order->created_at,
        $order->updated_at
        // eFirstLast($order->project->person_id),
        // eDate($order->submitted_at),
        // eFirstLast($order->submitter),
        // $order->project->title,
        // $order->typeName(),
        // eFirstLast($order->assigned_to),
        // $order->tracking->last_action ?? $order->stage,
        // $order->tracking->last_actor ?? eFirstLast($order->submitted_by),
        // $order->tracking->last_at ? eDate($order->tracking->last_at) : eDate($order->created_at),
        // $order->tracking->next_action ?? $order->stage,
        // $order->tracking->next_actors ?? '',
        // $order->on_call ?? 0,
        // $order->project->folder_url ?? ''
    ]);
}
