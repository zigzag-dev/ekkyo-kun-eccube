<?php

namespace Plugin\EkkyoKun;

use Eccube\Event\EventArgs;

class EkkyoKunEvent
{
    /** @var \Eccube\Application $app */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function onFrontProductDetailInit(EventArgs $event)
    {
        $product = $event->getArgument('Product');
        dump($product->getClassName1());
        dump($product->getClassName2());
        dump($product->getClassCategories1());
        dump($product->getClassCategories2(1));
        dump($product->getClassCategories());

    }
}
