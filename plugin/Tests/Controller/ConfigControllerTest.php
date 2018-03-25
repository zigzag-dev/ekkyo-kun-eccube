<?php

namespace Plugin\EkkyoKun\Tests\Controller;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;

class ConfigControllerTest extends AbstractAdminWebTestCase
{
    public function testRoutingAdminIndex()
    {
        // 下記クラスを参考に実装
        // tests/Eccube/Tests/Web/Admin/IndexControllerTest.php
        $adminRoot = $this->app['url_generator']->generate('admin_homepage');
        $this->client->request('GET', "{$adminRoot}plugin/ekkyokun/config");
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
