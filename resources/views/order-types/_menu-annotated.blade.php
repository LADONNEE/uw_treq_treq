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
            <p>Use before travel to calculate and reserve estimated costs.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>When the main details of a trip are understood ahead of time</li>
                <li>Verify what is allowed and how much may be spent</li>
                <li>Determine available funding or notify if funding capped</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[1]; // ('pre-auth', 'Other Pre-Authorization', 'ballot-check') ?>
    <div>
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

    <?php $type = $types[2]; // ('purchase', 'Make a Purchase', 'box-alt') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Have fiscal team order and pay for requested items.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Food</li>
                <li>On Campus charges to other departments</li>
                <li>Orders over $10,000</li>
                <li>RSP (P2I or Revolving Fund Check)</li>
                <li>Honorarium</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[3]; // (self::TRAVEL_REIMBURSEMENT, 'Travel Reimbursement', 'plane-arrival') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Use after trip has occurred including submitting mileage.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Mileage reimbursement</li>
                <li>After travel for a pre-authorized trip</li>
                <li>Travel missing pre-authorization (reimbursed as allowed)</li>
                <li>Travel by PI</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[4]; // ('reimbursement', 'Other Reimbursement', 'receipt') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Use for purchases already made with your own funds.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Books or Supplies</li>
                <li>Membership</li>
                <li>Subscriptions</li>
            </ul>
        </div>
    </div>

    <?php $type = $types[5]; // ('invoice', 'Pay an Invoice', 'file-invoice') ?>
    <div>
        <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
            <span>@icon($type->icon)</span> {{ $type->name }}
        </a>
        <div class="order-menu__help">
            <p>Submit an invoice that does not have a prior pre-approval.</p>

            <div class="order-menu__examples">Examples</div>
            <ul>
                <li>Substitute teacher payment</li>
                <li>Consultant Payment</li>
                <li>Transcription/translation invoices</li>
            </ul>
        </div>
    </div>
</div>
