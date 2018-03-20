<?php

namespace Plugin\EkkyoKun;

use Eccube\Entity\ClassCategory;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;

class EkkyoKunEvent
{
    /** @var \Eccube\Application $app */
    private $app;

    /**
     * @var string
     */
    private $cos;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param EventArgs $event
     */
    public function onFrontProductDetailInit(EventArgs $event)
    {
        $product = $event->getArgument('Product');
        $this->cos = $this->makeCheckOutSource($product);
    }

    /**
     * @param TemplateEvent $event
     */
    public function onRenderProductDetail(TemplateEvent $event)
    {
        // http://downloads.ec-cube.net/manual/v3/plugin.pdf 35p
        // Twigのキャッシュを効かせるため、
        // 動的な値を表示したい際は変数化しパラメータで渡す
        $parameters = $event->getParameters();
        $parameters['cos'] = $this->cos;
        $event->setParameters($parameters);

        $replace = <<<EOS
{{cos|raw}}
{% endblock %}
EOS;

        $source = preg_replace('/\{% endblock %\}/', $replace, $event->getSource(), 1);
        $event->setSource($source);
    }

    /**
     * Productからチェックアウトソースを作成し返す
     *
     * @param Product $Product
     *
     * @return string
     */
    private function makeCheckOutSource(Product $Product)
    {
        $result = '';
        $name = $Product->getName();

        /**
         * @var \Doctrine\Common\Collections\ArrayCollection $productClasses
         */
        $productClasses = $this->getProductClassesExcludeNonClass($Product);
        if ($productClasses->count() > 0) {
            $skus = array();
            foreach ($productClasses as $productClass) {
                $sku = $this->getSku($productClass);
                if (!empty($sku)) {
                    $skus[] = $sku;
                }
            }
            if (count($skus) > 0) {
                $strSkus = implode(PHP_EOL, $skus);
                $result = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>{$name}</dd>
<dd data-sku>
{$strSkus}
</dd>
</dl>
EOS;
            }
        } else {
            $price = (int) $Product->getPrice02IncTaxMin();
            $formattedPrice = number_format($price);

            $hasStock = $Product->getStockFind();
            if ($hasStock) {
                $stock = $Product->getStockUnlimitedMin();
                if ($stock === 0) {
                    $stock = $Product->getStockMin();
                }
                $result = <<<EOS
<dl hidden id="zigzag-data">
<dt>name</dt>
<dd data-name>{$name}</dd>
<dt>price</dt>
<dd data-price="{$price}">{$formattedPrice}</dd>
<dt>stock</dt>
<dd data-stock="{$stock}">{$stock}</dd>
</dl>
EOS;
            }
        }

        return $result;
    }

    /**
     * 規格なし商品を除いて商品規格を取得.
     *
     * src/Eccube/Controller/Admin/Product/ProductClassController.php 718
     *
     * @param Product $Product
     * @return \Doctrine\Common\Collections\Collection|\Eccube\Entity\ProductClass[]
     */
    private function getProductClassesExcludeNonClass(Product $Product)
    {
        $ProductClasses = $Product->getProductClasses();
        return $ProductClasses->filter(function($ProductClass) {
            $ClassCategory1 = $ProductClass->getClassCategory1();
            $ClassCategory2 = $ProductClass->getClassCategory2();
            return ($ClassCategory1 || $ClassCategory2);
        });
    }

    /**
     * @param ProductClass $ProductClass
     *
     * @return string|null
     */
    private function getSku(ProductClass $ProductClass)
    {
        $hasStock = $ProductClass->getStockFind();
        if ($hasStock) {
            $price = $ProductClass->getPrice02IncTax();
            $formattedPrice = number_format($price);

            $stock = $ProductClass->getStockUnlimited();
            if ($stock === 0) {
                $stock = $ProductClass->getStock();
            }

            $sku = '';
            $sku .= '<dl>';
            /**
             * @var ClassCategory $ClassCategory1
             */
            $ClassCategory1 = $ProductClass->getClassCategory1();
            if (!empty($ClassCategory1)) {
                $key = $ClassCategory1->getClassName();
                $val = $ClassCategory1->getName();

                $attribute = $this->getDataAttribute($key);
                $attribute = !empty($attribute) ? ' ' . $attribute : '';
                $sku .= '<dt>' . $key . '</dt><dd'.$attribute.'>' . $val . '</dd>';
            }
            /**
             * @var ClassCategory $ClassCategory2
             */
            $ClassCategory2 = $ProductClass->getClassCategory1();
            if (!empty($ClassCategory2)) {
                $key = $ClassCategory2->getClassName();
                $val = $ClassCategory2->getName();

                $attribute = $this->getDataAttribute($key);
                $attribute = !empty($attribute) ? ' ' . $attribute : '';
                $sku .= '<dt>' . $key . '</dt><dd'.$attribute.'>' . $val . '</dd>';
            }
            $sku .= '<dt>price</dt><dd data-price="' . $price . '">' . $formattedPrice . '</dd>';
            $sku .= '<dt>stock</dt><dd data-stock="' . $stock . '">' . $stock . '</dd>';
            $sku .= '</dl>';
            return $sku;
        }

        return null;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getDataAttribute($key)
    {
        if (in_array(strtolower($key), $this->getSizeKeys())) {
            return 'data-size';
        }
        if (in_array(strtolower($key), $this->getColorKeys())) {
            return 'data-color';
        }

        return '';
    }

    /**
     * @return array
     */
    private function getSizeKeys()
    {
        return $this->app['config']['EkkyoKun']['const']['sizes'];
    }

    /**
     * @return array
     */
    private function getColorKeys()
    {
        return $this->app['config']['EkkyoKun']['const']['colors'];
    }
}
