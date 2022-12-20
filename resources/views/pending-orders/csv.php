<?php

$filename = 'treq_'.date('Y-m-d').'.csv';

header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Pragma: public');
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename='.$filename);

echoCsvRow([
    'Project ID',
    'Requestor/Project Owner',
    'Submitted Date',
    'Submitted By',
    'Title',
    'Order Type',
    'Assigned Fiscal Person',
    'Last Action',
    'Last Action By',
    'Last Action Date',
    'Stage',
    'Next Actor',
    'On-Call',
    'OneDrive Folder URL'
]);

foreach ($orders as $order) {
    echoCsvRow([
        $order->project_id,
        eFirstLast($order->project->person_id),
        eDate($order->submitted_at),
        eFirstLast($order->submitter),
        $order->project->title,
        $order->typeName(),
        eFirstLast($order->assigned_to),
        $order->tracking->last_action ?? ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage,
        $order->tracking->last_actor ?? eFirstLast($order->submitted_by),
        $order->tracking->last_at ? eDate($order->tracking->last_at) : eDate($order->created_at),
        $order->tracking->next_action ?? ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage,
        $order->tracking->next_actors ?? '',
        $order->on_call ?? 0,
        $order->project->folder_url ?? ''
    ]);
}
