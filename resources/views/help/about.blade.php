@extends('help.help-layout')
@section('title', 'Help: About')
@section('help-content')

    <h1 class="mb-4">About TREQ</h1>

    <p>
        TREQ (Travel & Requisitions) is a request tracking system for soliciting review, approval, and
        action from the UW Information School's fiscal staff. It is used by all Information School staff.
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
            To provide shared visibility into workflow. Users know where their requests are in processing, 
            and the shared environment has a clear record of outstanding requests and workflows.
        </li>
    </ul>

    <h2 class="mt-4">Who uses TREQ?</h2>

    <ul class="bullet">
        <li>
            All travelers
        </li>
        <li>
            Anyone seeking reimbursement
        </li>
        <li>
            Anyone needing an invoice paid via Ariba for services already rendered
        </li>
        <li>
            Anyone needing external purchasing made via Ariba or via a fiscal staff procard
        </li>
    </ul>



    <h2 class="mt-4">When are the TREQ modules used?</h2>

    <ul class="bullet">
        <li>
            <u>Travel Pre-authorization</u> - Every UWORG employee (including students) needs pre-authorization to travel, 
            unless the expenses will be for mileage reimbursement only. Also use if requesting approval for travel on behalf of non-UW travelers. 
            </li>
        <li>
            <u>Travel Reimbursement</u> - Every UWORG employee (including students) will use to submit a request for travel reimbursement, 
            including for mileage reimbursement. You may also request reimbursement on behalf of a non-UW traveler. 
        </li>
        <li>
            <u>Reimbursement</u> - Every UWORG employee (including students) who is seeking reimbursement for purchases made on behalf of the UW. 
        </li>
        <li>
            <u>Make a Purchase</u> - Any employee needing assistance in purchasing goods/services from an external vendor either via Ariba or fiscal staff procard. 
        </li>
        <li>
            <u>Pay an Invoice</u> - Any employee needing assistance paying an invoice either via Ariba or fiscal staff procard for goods or services already received.  
        </li>
    </ul>


    <h2 class="mt-4">What if you have a procurement memo on file giving pre-approval for purchasing?</h2>

    <ul class="bullet">
        <li>
            If you have one for internal campus purchasing, you don't need to use TREQ (TREQ is only used for external vendors).
        </li>
        <li>
            If you have one for external vendor purchasing but you need assistance from fiscal staff in making the purchase or paying an invoice, you will still use TREQ.
        </li>
        
    </ul>


    <h2 class="mt-4">Projects and Orders</h2>

    <p>
        TREQ uses Projects and Orders to organize requests.
    </p>

    <p>
        A Project is a single thing being done that has a requestor and business purpose. 
        Multiple Orders (requests) may or may not be needed to be submitted to complete the Project. 
        In most instances, the user will only need to submit one Order or request to accomplish the task and complete the Project. 
        An example of this would be when requesting reimbursement for purchasing an Item. 
        In other instances, the user will submit multiple Orders or requests associated with the same Project, 
        e.g. submitting requests for multiple invoices to be paid over time related to a standing order with a vendor. 
    </p>

    <p>
        Each Project has one or more Orders which are items that need review, approval, and action. 
        For example, a Trip (Project) might have both a Pre-Authorization (an Order) 
        and a Reimbursement Request (a second Order, probably submitted at a later date).  
    </p>

    <p>
        Grouping multiple Orders within a Project saves the user some data entry 
        and allows the Orders to be viewed in relation to one another. 
    </p>
@stop
