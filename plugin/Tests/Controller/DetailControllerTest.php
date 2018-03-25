<?php

namespace Plugin\EkkyoKun\Tests\Controller;

use Eccube\Tests\Plugin\Web\AbstractWebTestCase;

class DetailControllerTest extends AbstractWebTestCase
{
    public function testRoutingAdminIndex()
    {
        $client = $this->client;
        $client->request('GET', $this->app->url('product_detail', array( 'id' => 1 )));
        $res = $client->getResponse();
        $this->assertEquals(1, preg_match('/id="zigzag\-data"/', $res->getContent()));
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
