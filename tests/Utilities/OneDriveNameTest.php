<?php

namespace Tests\Utilities;

use App\Models\Order;
use App\Utilities\FlashMessage;
use App\Utilities\OneDriveName;
use Tests\TestCase;

class OneDriveNameTest extends TestCase
{
    const URL = 'https://uwnetid-my.sharepoint.com/personal/nbedani_uw_edu/_layouts/15/onedrive.aspx?id=%2Fpersonal%2Fnbedani%5Fuw%5Fedu%2FDocuments%2Fuwenv%5Ftreq%2FUser%20Folders';
    const OG_UAA_FISCAL_URL = 'https://uwnetid-my.sharepoint.com/personal/nbedani_uw_edu/_layouts/15/onedrive.aspx?id=%2Fpersonal%2Fnbedani%5Fuw%5Fedu%2FDocuments%2Fuwenv%5Ftreq/treq/jones,%20lydia?csf=1&web=1&e=xdac6a';

    public function test_it_instantiates()
    {
        $it = new OneDriveName();

        $this->assertInstanceOf(OneDriveName::class, $it);
    }

    public function test_it_returns_decoded_id()
    {
        $it = new OneDriveName();

        $result = $it->name(self::URL);

        $this->assertSame('/personal/nbedani_uw_edu/Documents/uwenv_treq/User Folders', $result);
    }

    public function test_it_returns_last_section_of_og_coe_fiscal_url()
    {
        $it = new OneDriveName();

        $result = $it->name(self::OG_UAA_FISCAL_URL);

        $this->assertSame('/jones, lydia', $result);
    }

    public function test_it_returns_default_name_if_query_id_not_found()
    {
        $it = new OneDriveName();

        $result = $it->name('https://uwnetid-my.sharepoint.com/personal/nbedani_uw_edu/_layouts/15/onedrive.aspx?other=%2Fpersonal%2Fnbedani%5Fuw%5Fedu');

        $this->assertSame($it->defaultName(), $result);
    }

    public function test_it_returns_default_name_if_id_is_empty()
    {
        $it = new OneDriveName();

        $result = $it->name('https://uwnetid-my.sharepoint.com/personal/nbedani_uw_edu/_layouts/15/onedrive.aspx?id=');

        $this->assertSame($it->defaultName(), $result);
    }
}
