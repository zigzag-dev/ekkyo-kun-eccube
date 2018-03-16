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

        // twigコードにカテゴリコンテンツを挿入
        $html = '';
        $html .= '<ul hidden id="zigzag-data">';
        $html .= '</ul>';
        $search = '<form action="?" method="post" id="form1" name="form1">';
        $replace = $search.$html;
        $source = str_replace($search, $replace, $event->getSource());
        $event->setSource($source);
    }
}
