<?php

namespace Plugin\EkkyoKun\Tests\Service;

use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Tests\EccubeTestCase;

class EkkyoKunServiceTest extends EccubeTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMakeCheckOutSource()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dt>price</dt>
<dd data-price="100">100</dd>
<dt>stock</dt>
<dd data-stock="1">1</dd>
</dl>
EOS;
        $p = new Product();
        $p->setName('商品名1');
        $c = new ProductClass();
        $c->setPrice02IncTax(100);
        $c->setStockUnlimited(1);
        $p->addProductClass($c);
        $actual = $this->app['eccube.plugin.service.ekkyokun']->makeCheckOutSource($p);
        $this->assertEquals($expect, $actual);
    }
}
