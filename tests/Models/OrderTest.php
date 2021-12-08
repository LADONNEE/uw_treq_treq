<?php

namespace Tests\Models;

use App\Models\Order;
use App\Workflows\Templates\Template;
use App\Workflows\Templates\TravelPreAuth;
use App\Workflows\Templates\TravelReimbursement;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_it_provides_its_own_workflow_template()
    {
        $it = new Order();

        $this->assertInstanceOf(Template::class, $it->template());
    }

    public function test_it_provides_workflow_template_based_on_order_type()
    {
        $it = new Order(['type' => 'travel-pre-auth']);

        $this->assertInstanceOf(TravelPreAuth::class, $it->template());

        $it->type = 'travel-reimbursement';
        $this->assertInstanceOf(TravelReimbursement::class, $it->template());
    }

    public function test_it_reports_is_submitted_when_submitted_at_is_set()
    {
        $it = new Order();

        $this->assertFalse($it->isSubmitted(), 'submitted_at is empty');

        $it->submitted_at = now();

        $this->assertTrue($it->isSubmitted(), 'submitted_at has date value');
    }
}
