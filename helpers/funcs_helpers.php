<?php

function eDate($value, $format = 'n/j/Y')
{
    if (empty($value)) {
        return '';
    }
    if ($value instanceof \Carbon\Carbon) {
        return $value->format($format);
    }
    if (is_numeric($value)) {
        return date($format, (int)$value);
    }
    $ts = strtotime($value);
    if ($ts) {
        return date($format, $ts);
    }
    return $value;
}

/**
* Format times
* @param $value
* @param string $format
* @return bool|string
*/
function eTime($value, $format = 'g:i A')
{
   if (empty($value)) {
       return '';
   }
   if ($value instanceof \Carbon\Carbon) {
       if (carbonEmpty($value)) {
           return '';
       }
       return $value->format($format);
   }
   /*if (is_numeric($value)) {
       return date($format, (int)$value);
   }*/
   $ts = strtotime($value);
   if ($ts) {
       return date($format, $ts);
   }
   return $value;
}

function eFirstLast($p)
{
    $person = app('App\Utilities\PersonLookup')->toPerson($p);
    return "{$person->getFirst()} {$person->getLast()}";
}

function eLastFirst($p)
{
    $person = app('App\Utilities\PersonLookup')->toPerson($p);
    if ($person->firstname) {
        return "{$person->lastname}, {$person->firstname}";
    }
    return $person->lastname;
}

function eOrEmpty($value, $empty = 'missing')
{
    if ($value) {
        return e($value);
    } else {
        return '<span class="empty">' . e($empty) . '</span>';
    }
}

function eYesNo($value, $empty = '')
{
    if ($value === null || $value === '') {
        return $empty;
    }
    if ($value === 'Y') {
        return 'Yes';
    }
    if ($value === 'N') {
        return 'No';
    }
    return ($value) ? 'Yes' : 'No';
}

function isAjax()
{
    return request()->ajax();
}

function projectNumber($model, $htmlWrap = false)
{
    if ($model instanceof \App\Models\Order) {
        $model = $model->project_id;
    }
    if ($model instanceof \App\Models\Project) {
        $model = $model->id;
    }
    if ($htmlWrap) {
        return sprintf('<span class="project-number">TREQ%06d</span>', $model);
    }
    return sprintf('TREQ%06d', $model);
}

function scrubUwnetid($value)
{
    $atPos = strpos($value, '@');
    if ($atPos !== false) {
        $value = substr($value, 0, $atPos);
    }
    return strtolower(trim($value));
}

function scrubUpper($value)
{
    return strtoupper(trim(strip_tags($value)));
}

function sqlInclude($filename, $substitutions = [])
{
    $sql = file_get_contents($filename);
    foreach ($substitutions as $placeholder => $value) {
        $sql = str_replace($placeholder, $value, $sql);
    }
    return $sql;
}

/**
 * @param string|null $uwnetid
 * @return \App\Auth\User
 */
function user($uwnetid = null)
{
    return app('UserProvider')->getUser($uwnetid);
}

/**
 * User information transformed for Rollbar.com error logging
 * @see config/logging.php config('logging.channels.rollbar.person_fn')
 * @return array
 */
function user_rollbar()
{
    $u = user();
    return [
        'id' => $u->person_id,
        'username' => $u->uwnetid,
    ];
}

function hasRole($role, $user = null)
{
    return app('acl')->hasRole($role, $user);
}

function array_to_options($array)
{
    $out = [];
    foreach ($array as $item) {
        $out[$item] = $item;
    }
    return $out;
}

function checked($value, $optionValue)
{
    if (is_array($value)) {
        return in_array($optionValue, $value) ? ' checked="checked" ' : '';
    }
    return $optionValue == $value ? ' checked="checked" ' : '';
}

function selected($value, $optionValue)
{
    if (is_array($value)) {
        return in_array($optionValue, $value) ? ' selected="selected" ' : '';
    }
    return $optionValue == $value ? ' selected="selected" ' : '';
}

function optionId($id, $value)
{
    return \Illuminate\Support\Str::snake("{$id}_{$value}");
}

function setting($name)
{
    return app('App\Utilities\SettingsCache')->get($name);
}

function downloadHref()
{
    $out = $_SERVER['REQUEST_URI'];
    if (strpos($out, 'format=csv')) {
        return $out;
    }
    if (empty($_SERVER['QUERY_STRING'])) {
        return $_SERVER['REQUEST_URI'].'?format=csv';
    }
    return $_SERVER['REQUEST_URI'].'&format=csv';
}

function wantsCsv()
{
    return request('format') == 'csv';
}

function csvQuote($value)
{
    // strip new line characters
    if (strpos($value, "\n") !== false) {
        $value = str_replace("\r", '', $value);
        $value = str_replace("\n", ' ', $value);
    }
    // if it has a comma in it, it needs help
    if (strpos($value,',') !== false) {
        // first escape " with and extra "
        $value = str_replace('"', '""', $value);
        return '"' . $value . '"';
    }
    // the string is safe as is
    return $value;
}

function echoCsvRow(array $data)
{
    $first = true;
    foreach ($data as $value) {
        if (!$first) {
            echo ',';
        }
        $first = false;
        echo csvQuote($value);
    }
    echo PHP_EOL;
}
