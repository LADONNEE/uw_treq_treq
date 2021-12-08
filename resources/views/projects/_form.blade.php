<div style="max-width: 600px;">
    @inputBlock('title', [
        'label' => 'Project Title',
    ])
    @input('person_id', ['id' => 'js-person-id'])
    @inputBlock('owner_search', [
        'label' => 'Project Owner',
        'class' => 'person-typeahead',
        'data-for' => 'js-person-id',
    ])
    @inputBlock('purpose', [
        'label' => 'Business Purpose',
        'rows' => 5
    ])
    @inputBlock('is_food', 'Food')
    @inputBlock('rsp_option', 'Research Subject Payments')

</div>

<div class="my-4">
    <button class="btn btn-primary">Save &amp; Continue</button>
</div>
