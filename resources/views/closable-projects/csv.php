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
    'OneDrive Folder URL',
    'Trip ID',
    'Trip Destination',
    'Trip Depart at',
    'Trip Return at',
    'Trip Traveler',
    'Trip Person ID',
    'Trip Traveler Title',
    'Trip Traveler Email',
    'Trip Traveler Phone',
    'Trip Non uw',
    'Trip Personnal time',
    'Trip Personnal time dates',
    'Trip honorarium',
    'Trip Created At',
    'Trip Updated At',
    'Trip Depart At Time',
    'Trip Return At Time',
    'Trip Nuwt Adress Line1',
    'Trip Nuwt Adress Line2',
    'Trip Nuwt City',
    'Trip Nuwt State Province',
    'Trip Nuwt Zipcode',
    'Trip Nuwt Country',
    'Trip State'

]);

foreach ($reportdata as $project) {
    echoCsvRow([
        $project->id,
        $project->title,
        $project->person_id,
        $project->purpose,
        $project->is_travel,
        $project->is_food,
        $project->is_gift_card,
        $project->is_rsp,
        $project->folder_url,
        $project->folder_name,
        $project->folder_deleted,
        $project->closed_at,
        $project->closed_by,
        $project->created_at,
        $project->updated_at,
        $project->trip?->id,
        $project->trip?->traveler_phone,
        $project->id,
        $project->trip?->depart_at,
        $project->trip?->return_at,
        $project->trip?->traveler,
        $project->trip?->person_id,
        $project->trip?->traveler_title,
        $project->trip?->traveler_email,
        $project->trip?->traveler_phone,
        $project->trip?->non_uw,
        $project->trip?->personal_time,
        $project->trip?->personal_time_dates,
        $project->trip?->honorarium,
        $project->trip?->created_at,
        $project->trip?->updated_at,
        $project->trip?->depart_at_time,
        $project->trip?->nuwt_address_line1,
        $project->trip?->nuwt_address_line2,
        $project->trip?->nuwt_city,
        $project->trip?->nuwt_state_province,
        $project->trip?->nuwt_zipcode,
        $project->trip?->nuwt_country,
        $project->trip?->state
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
