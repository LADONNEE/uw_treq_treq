<div class="order-menu order-menu--with-help my-4">
    <?php
    /** @var array $types */
    $type = $types[0]; // ('travel-pre-auth', 'Travel Pre-Authorization', 'plane-departure')
    ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Use before travel to receive Dean's level authorization, calculate projected expenses and assign to a budget.</p>

            <div class="order-menu__examples">Details</div>
            <ul>
                <li>For use by all UWORG permanent, temporary or student staff and on behalf of non-UW travelers</li>
                <li>Describe purpose of travel</li>
                <li>Estimate costs and assign to a budget</li>
                <li>Specify if personal time will be taken</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[1]; // (self::TRAVEL_REIMBURSEMENT, 'Travel Reimbursement', 'plane-arrival') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Use after trip has occurred or to submit mileage reimbursements.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Mileage reimbursement</li>
                <li>After travel for a pre-authorized trip</li>
                <li>Travel missing pre-authorization (reimbursed as allowed)</li>
                <li>Travel by staff, student and non-UW traveler</li>
            </ul>
        </div>
    </div>


    <?php //$type = $types[1]; // ('pre-auth', 'Other Pre-Authorization', 'ballot-check') ?>
    <?php /* <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Set up standing orders, get approval for events and regulated expenses.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Water service</li>
                <li>Subscriptions and technology fees</li>
                <li>Recurring advertising</li>
                <li>Events with multiple expenses</li>
                <li>Graduation (venue, food, balloons)</li>
                <li>Senior Presentations (room rental, food, parking)</li>
            </ul>
        </div>
    </div>
    */
    ?>

    <?php $type = $types[2]; // ('reimbursement', 'Other Reimbursement', 'receipt') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Use for purchases already made with your own funds unrelated to travel.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Supplies</li>
                <li>Membership</li>
                <li>Subscriptions</li>
                <li>Food</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[3]; // ('purchase', 'Make a Purchase', 'box-alt') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Have fiscal team order and pay for requested items.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Food</li>
                <li>Programmatic expenses</li>
                <li>Orders over $10,000</li>
                <li>Honorarium</li>
            </ul>
        </div>
    </div>

    

    <?php $type = $types[4]; // ('invoice', 'Pay an Invoice', 'file-invoice') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Submit an invoice for goods/services already received.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Consultant Payment</li>
                <li>Membership dues</li>
            </ul>
        </div>
    </div>
</div>
