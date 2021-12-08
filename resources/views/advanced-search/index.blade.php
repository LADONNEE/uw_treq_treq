@extends('layout/default')
@section('title', 'Search Orders')
@section('content')
    <div>
        <div class="panel panel-ribbon mw-1200">
            <h1 class="ml-3 mb-4">Advanced Search</h1>

            <form method="get" action="{!! route('advanced-search') !!}#results">
                <input type="hidden" name="go" value="1">
                <div class="d-flex form-input--no-margin ml-3">
                <span class="mr-3">
                    @inputBlock('start_date', [
                        'label' => 'Start Date',
                        'class' => 'form-input__date',
                        'placeholder' => 'm/d/yyyy'
                    ])
                </span>
                    @inputBlock('end_date', [
                        'label' => 'End Date',
                        'class' => 'form-input__date',
                        'placeholder' => 'm/d/yyyy'
                    ])
                </div>
                <p class="form-group__help mb-3 ml-4">
                    Show orders submitted between these dates. Leave blank to search all orders.
                </p>

                <div class="col-md-6">
                    @inputBlock('project_title', 'Project Title')
                    @inputBlock('project_owner', 'Project Owner / Submitted By')
                    @inputBlock('traveler')
                </div>

                <div class="d-flex ml-3">
                <span class="mr-3">
                    @inputBlock('depart', [
                        'label' => 'Trips Occurring After Date',
                        'class' => 'form-input__date',
                        'placeholder' => 'm/d/yyyy'
                    ])
                </span>
                    @inputBlock('return', [
                    'label' => 'Trips Occurring Before Date',
                    'class' => 'form-input__date',
                    'placeholder' => 'm/d/yyyy'
                    ])
                </div>

                <div class="col-md-6">
                    <div id="js-budget">
                        @input('budget_id', ['id' => 'js-budget-id'])
                        @inputBlock('budget_search', [
                            'label' => 'Budget',
                            'data-for' => 'js-budget-id',
                            'class' => 'budget-typeahead'
                        ])
                    </div>

                    @inputBlock('pca_code', 'PCA Code')
                    @inputBlock('items')
                    @inputBlock('reference_number', [
                        'label' => 'Reference Number',
                        'help' => 'Search reference numbers for Ariba, ProCard, CTI, ISD, or JV.'
                    ])

                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            @if($searchRan)
                <h2 class="mt-5 mb-3" id="results">Matching Orders</h2>

                @if(count($orders) > 0)
                    @include('home._table-status', $orders)
                @else
                    <div class="empty-table">No matching orders</div>
                @endif
            @endif
        </div>
    </div>
@stop
