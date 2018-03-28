<?php

namespace Plugin\EkkyoKun\Tests\Controller;

use Eccube\Tests\Plugin\Web\AbstractWebTestCase;
use Plugin\EkkyoKun\Entity\Config;
use Plugin\EkkyoKun\Repository\ConfigRepository;

class DetailControllerTest extends AbstractWebTestCase
{
    public function testRoutingAdminIndex()
    {
        $app = $this->app;

        /** @var ConfigRepository $configRepository */
        $configRepository = $app['plugin.ekkyokun.repository.config'];
        /** @var Config $Config */
        $Config = $configRepository->findOneBy(array('key' => 'token',));
        $configRepository->updateToken($Config, 'xxxx');
        $app['plugin.ekkyokun.repository.config'] = $configRepository;

        $client = $this->client;
        $client->request('GET', $this->app->url('product_detail', array( 'id' => 1 )));
        $res = $client->getResponse();
        $this->assertEquals(1, preg_match('/id="zigzag\-data"/', $res->getContent()));
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
