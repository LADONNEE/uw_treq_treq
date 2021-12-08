<?php

namespace Tests\Workflows\Templates;

use App\Workflows\Templates\SimpleOrder;
use App\Workflows\Templates\TemplateFactory;
use App\Workflows\Templates\TravelPreAuth;
use App\Workflows\Templates\TravelReimbursement;
use PHPUnit\Framework\TestCase;

class TemplateFactoryTest extends TestCase
{
    public function test_it_instantiates()
    {
        $it = new TemplateFactory();

        $this->assertInstanceOf(TemplateFactory::class, $it);
    }

    public function test_unexpected_type_provides_default_template()
    {
        $it = new TemplateFactory();

        $this->assertInstanceOf(SimpleOrder::class, $it->get('unknown'));
    }

    public function test_empty_type_provides_default_template()
    {
        $it = new TemplateFactory();

        $this->assertInstanceOf(SimpleOrder::class, $it->get(null));
    }

    public function test_type_travel_pre_auth_provides_appropriate_template()
    {
        $it = new TemplateFactory();

        $this->assertInstanceOf(TravelPreAuth::class, $it->get('travel-pre-auth'));
    }

    public function test_type_travel_reimbursement_provides_appropriate_template()
    {
        $it = new TemplateFactory();

        $this->assertInstanceOf(TravelReimbursement::class, $it->get('travel-reimbursement'));
    }
}
