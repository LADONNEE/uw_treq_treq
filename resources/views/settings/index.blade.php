@extends('layout/default')
@section('title', 'Settings')
@section('content')
    <div class="panel panel-ribbon mw-800">
        <h1 class="mt-3">Settings</h1>

        <table class="table mt-3">
            <thead>
            <tr>
                <th>Setting</th>
                <th>Value</th>
                <th style="width: 50%;">Help</th>
            </tr>
            </thead>

            <tbody>

            <tr data-name="current-biennium" data-value="{{ $settings['current-biennium'] }}" class="js-settings-start pointer">
                <td class="js-proper-case">current-biennium</td>
                <td>{{ $settings['current-biennium'] }}</td>
                <td class="text-sm">
                    Biennium start year. Current fiscal biennium searched by budget suggestion tool.
                </td>
            </tr>

            <tr data-name="fiscal-contact-default" data-value="{{ $settings['fiscal-contact-default'] }}" class="js-settings-start pointer">
                <td class="js-proper-case">fiscal-contact-default</td>
                <td>{{ $settings['fiscal-contact-default'] }}</td>
                <td class="text-sm">
                    UW NetID only, not email. User who will be fiscal contact in cases where orders
                    are submitted with no budgets.
                </td>
            </tr>

            <tr data-name="seattle-sales-tax" data-value="{{ $settings['seattle-sales-tax'] }}" class="js-settings-start pointer">
                <td class="js-proper-case">seattle-sales-tax</td>
                <td>{{ $settings['seattle-sales-tax'] }}</td>
                <td class="text-sm">
                    Seattle Sales Tax Rate as decimal value between 0 and 1.
                    (e.g. enter 10.25% as <strong class="monospace">0.1025</strong>).
                    This is the default sales tax rate when a user adds tax to items.
                </td>
            </tr>

            </tbody>
        </table>

        @if(hasRole('settings'))

            <div id="js-setting-form" class="my-3 p-3 rounded bg-light" style="display: none; max-width: 400px;">
                <h2>Change Setting</h2>
                <form method="post" action="{{ action('SettingsController@store') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="setting_name" id="js-setting-name">
                    <div class="form-group">
                        <label for="value" id="js-setting-label">Unknown Setting</label>
                        <input type="text" name="value" value="" id="js-setting-value" class="form-control">
                    </div>
                    <div class="my-4">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button class="btn btn-secondary" type="submit" id="js-setting-cancel">Cancel</button>
                    </div>
                </form>
            </div>

        @endif
    </div>
@stop
