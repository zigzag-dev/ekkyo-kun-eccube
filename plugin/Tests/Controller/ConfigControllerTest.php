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

    public function testRoutingAdminIndexPost()
    {
        $adminRoot = $this->app['url_generator']->generate('admin_homepage');
        $this->client->request('POST', "{$adminRoot}plugin/ekkyokun/config", array('ekkyokun_config_form' =>
            array(
                '_token' => 'dummy',
                'name_token' => 'xxxx',
                'name_countries' => array( 'US' )
            )
        ));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
