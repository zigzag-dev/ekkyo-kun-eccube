<?php

namespace Plugin\EkkyoKun\Tests\Service;

use Eccube\Entity\ClassCategory;
use Eccube\Entity\ClassName;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Tests\EccubeTestCase;
use Plugin\EkkyoKun\Service\EkkyoKunService;

class EkkyoKunServiceTest extends EccubeTestCase
{
    /**
     * @var EkkyoKunService $ekkyoKunService
     */
    private $ekkyoKunService;

    public function setUp()
    {
        parent::setUp();
        $this->ekkyoKunService = $this->app['eccube.plugin.service.ekkyokun'];
    }

    /**
     * @description sku無し
     */
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
        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertEquals($expect, $actual);
    }

    /**
     * @description sku無し
     */
    public function testMakeCheckOutSource2()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dt>price</dt>
<dd data-price="100">100</dd>
<dt>stock</dt>
<dd data-stock="2">2</dd>
</dl>
EOS;
        $p = $this->makeItem('商品名1', 100, 2);
        $actual = $this->ekkyoKunService->makeCheckOutSource($p);

        $this->assertTrue($expect === $actual);
    }

    /**
     * @description sku 1個
     */
    public function testMakeCheckOutSource4()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dd data-sku>
<dl><dt>key</dt><dd>val</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="200">200</dd></dl>
</dd>
</dl>
EOS;

        /** @var \Eccube\Entity\Product $p */
        $p = $this->makeItemWithSku('商品名1', array(
            array('key', 'val', 100, 200),
        ));

        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertTrue($expect === $actual);
    }

    /**
     * @description sku 1個 在庫無し
     */
    public function testMakeCheckOutSource5()
    {
        /** @var \Eccube\Entity\Product $p */
        $p = $this->makeItemWithSku('商品名1', array(
            array('key', 'val', 100, 0),
        ));

        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertTrue('' === $actual);
    }

    /**
     * @description sku 1種類2個
     */
    public function testMakeCheckOutSource6()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dd data-sku>
<dl><dt>material</dt><dd>gold</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
<dl><dt>material</dt><dd>silver</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
</dd>
</dl>
EOS;

        $p = $this->makeItemWithSku('商品名1', array(
            array('material', 'gold', 100, 1),
            array('material', 'silver', 100, 1),
        ));

        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertTrue($expect === $actual);
    }

    /**
     * @description sku 1種類2個 片方在庫無し
     */
    public function testMakeCheckOutSource7()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dd data-sku>
<dl><dt>material</dt><dd>gold</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
</dd>
</dl>
EOS;

        /** @var \Eccube\Entity\Product $p */
        $p = $this->makeItemWithSku('商品名1', array(
            array('material', 'gold', 100, 1),
            array('material', 'silver', 100, 0),
        ));

        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertTrue($expect === $actual);
    }

    /**
     * @description sku 2種類4個
     */
    public function testMakeCheckOutSource8()
    {
        $expect = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>商品名1</dd>
<dd data-sku>
<dl><dt>color</dt><dd data-color>red</dd><dt>size</dt><dd data-size>s</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
<dl><dt>color</dt><dd data-color>red</dd><dt>size</dt><dd data-size>m</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
<dl><dt>color</dt><dd data-color>blue</dd><dt>size</dt><dd data-size>s</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
<dl><dt>color</dt><dd data-color>blue</dd><dt>size</dt><dd data-size>m</dd><dt>price</dt><dd data-price="100">100</dd><dt>stock</dt><dd data-stock="1">1</dd></dl>
</dd>
</dl>
EOS;

        /** @var \Eccube\Entity\Product $p */
        $p = $this->makeItemWithSku('商品名1', array(
            array('color', 'red', 100, 1, 'size', 's'),
            array('color', 'red', 100, 1, 'size', 'm'),
            array('color', 'blue', 100, 1, 'size', 's'),
            array('color', 'blue', 100, 1, 'size', 'm'),
        ));

        $actual = $this->ekkyoKunService->makeCheckOutSource($p);
        $this->assertTrue($expect === $actual);
    }

    public function makeItem($name, $price = 100, $stock = 1)
    {
        $p = new Product();
        $p->setName($name);
        if ($price > 0) {
            $c = new ProductClass();
            $c->setPrice02IncTax($price);
            if (empty($stock)) {
                $c->setStock('0');
            } else {
                $c->setStockUnlimited(0);
                $c->setStock('' . $stock);
            }
            $p->addProductClass($c);
        }

        return $p;
    }

    public function makeItemWithSku($name, $options = array())
    {
        $p = $this->makeItem($name);

        foreach ($options as $option) {
            $key2 = isset($option[4]) ? $option[4] : null;
            $val2 = isset($option[5]) ? $option[5] : null;
            $p->addProductClass($this->makeSku($option[0], $option[1], $option[2], $option[3], $key2, $val2));
        }

        return $p;
    }

    public function makeSku($key, $val, $price = 100, $stock = 1, $key2 = null, $val2 = null)
    {
        $cn = new ClassName();
        $cn->setName($key);

        $c = new ProductClass();
        $c->setPrice02IncTax($price);
        if (empty($stock)) {
            $c->setStockUnlimited(0);
        } else {
            $c->setStock('' . $stock);
        }
        $cc = new ClassCategory();
        $cc->setClassName($cn);
        $cc->setName($val);
        if (empty($stock)) {
            $cc->setDelFlg(1);
        }
        $c->setClassCategory1($cc);

        if (!empty($key2)) {
            $cn2 = new ClassName();
            $cn2->setName($key2);
            $cc2 = new ClassCategory();
            $cc2->setClassName($cn2);
            $cc2->setName($val2);
            $c->setClassCategory2($cc2);
        }
        return $c;
    }
}
