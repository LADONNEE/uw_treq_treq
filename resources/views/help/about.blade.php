@extends('help.help-layout')
@section('title', 'Help: About')
@section('help-content')

    <h1 class="mb-4">About TREQ</h1>

    <p>
        TREQ (Travel & Requisitions) is a request tracking system for soliciting review, approval, and
        action from the UW Undergraduate Academic Affairs's Fiscal Office. It is used by college faculty and staff.
    </p>

    <p>
        Requests are processed through TREQ:
    </p>

    <ul class="bullet">
        <li>
            To facilitate and document proper review and approval of transactions.
        </li>
        <li>
            To ensure policy is followed, accounting is correct, and reimbursement is made promptly.
        </li>
        <li>
            To provide shared visibility into workflow. Users know where their requests stand and
            fiscal office has clear record of outstanding requests.
        </li>
    </ul>

    <h2 class="mt-4">Travel</h2>

    <p>
        Travel is a major use case for TREQ. It supports documentation of Travel Pre-Authorization
        as well as Travel Reimbursement requests.
    </p>

    <h2 class="mt-4">Projects and Orders</h2>

    <p>
        TREQ uses Projects and Orders to organize requests.
    </p>

    <p>
        A Project is a single thing being done for the college that has a business owner and
        business purpose. In the case of travel a single Trip is the Project. A recruiting
        event or a faculty retreat might be other examples of a Project.
    </p>

    <p>
        Each Project has one or more Orders which are items that need review, approval, and
        action. For example a Trip (Project) might have both a Pre-Authorization (an Order)
        and a Reimbursement Request (a second Order, probably submitted at a later date).
    </p>

    <p>
        Grouping multiple Orders within a Project saves you some data entry and allows the
        Orders to be viewed in relation to each other.
    </p>
@stop
