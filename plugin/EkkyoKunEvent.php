<?php

namespace Plugin\EkkyoKun;

use Eccube\Application;
use Eccube\Entity\Product;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\EkkyoKun\Entity\Product as EkkyoKunProduct;
use Plugin\EkkyoKun\Repository\ConfigRepository;
use Plugin\EkkyoKun\Repository\CountryRepository;
use Plugin\EkkyoKun\Repository\ProductRepository;
use Plugin\EkkyoKun\Service\EkkyoKunService;

class EkkyoKunEvent
{
    /** @var \Eccube\Application $app */
    private $app;

    const FORM_NAME = 'plg_EkkyoKun_product_sell';

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Product/detail.twig
     *
     * 商品詳細ページで、チェックアウトソースを出力する
     *
     * @param TemplateEvent $event
     */
    public function onRenderProductDetail(TemplateEvent $event)
    {
        /** @var ConfigRepository $configRepository */
        $configRepository = $this->app['plugin.ekkyokun.repository.config'];
        $token = $configRepository->findToken();
        if (is_null($token)) {
            return;
        }

        $parameters = $event->getParameters();

        /** @var Product $Product */
        $Product = $parameters['Product'];
        $id = $Product->getId();
        /** @var ProductRepository $productRepository */
        $productRepository = $this->app['plugin.ekkyokun.repository.product'];

        /** @var EkkyoKunProduct $EkkyoKunProduct */
        $EkkyoKunProduct = $productRepository->find($id);
        if ($EkkyoKunProduct && $EkkyoKunProduct->getDeny()) {
            return;
        }

        /** @var CountryRepository $countryRepository */
        $countryRepository = $this->app['plugin.ekkyokun.repository.country'];

        /** @var EkkyoKunService $ekkyokunService */
        $ekkyokunService = $this->app['eccube.plugin.service.ekkyokun'];

        // http://downloads.ec-cube.net/manual/v3/plugin.pdf 35p
        // Twigのキャッシュを効かせるため、
        // 動的な値を表示したい際は変数化しパラメータで渡す
        $parameters['apiTag'] = $ekkyokunService->makeApiTag($token);
        $parameters['cos'] = $ekkyokunService->makeCheckOutSource($Product);
        $parameters['denyCountryTag'] = $countryRepository->getDenyCountriesWithTag();
        $event->setParameters($parameters);

        $replace = <<<EOS
{{apiTag|raw}}
{{cos|raw}}
{{denyCountryTag|raw}}
{% endblock %}
EOS;

        $source = preg_replace('/\{% endblock %\}/', $replace, $event->getSource(), 1);
        $event->setSource($source);
    }

    /**
     * admin.product.edit.initialize
     *
     * @param EventArgs $event
     */
    public function onAdminProductDetailInit(EventArgs $event)
    {
        /** @var Product $Product */
        $Product = $event->getArgument('Product');
        $id = $Product->getId();

        /** @var EkkyoKunProduct $EkkyoKunProduct */
        $EkkyoKunProduct = null;
        if ($id) {
            /** @var ProductRepository $productRepository */
            $productRepository = $this->app['plugin.ekkyokun.repository.product'];
            $EkkyoKunProduct = $productRepository->find($id);
        }
        if (is_null($EkkyoKunProduct)) {
            $EkkyoKunProduct = new EkkyoKunProduct();
        }

        /** @var \Symfony\Component\Form\FormBuilder $builder */
        $builder = $event->getArgument('builder');
        $builder
            ->add(
                self::FORM_NAME,
                'choice',
                array(
                    'choices' => array(1 => '海外販売しない', 0 => '海外販売する'),
                    'label' => '海外販売',
                    'mapped' => false,
                    'multiple' => false,
                    'expanded' => true,
                )
            )
        ;
        $builder->get(self::FORM_NAME)->setData($EkkyoKunProduct->getDeny());
    }

    /**
     * admin.product.edit.complete
     *
     * @param EventArgs $event
     */
    public function onAdminProductDetailComplete(EventArgs $event)
    {
        /** @var Product $Product */
        $Product = $event->getArgument('Product');

        $id = $Product->getId();

        /** @var \Symfony\Component\Form\Form $form */
        $form = $event->getArgument('form')[self::FORM_NAME];
        $deny = $form->getData();

        /** @var ProductRepository $productRepository */
        $productRepository = $this->app['plugin.ekkyokun.repository.product'];

        /** @var EkkyoKunProduct $EkkyoKunProduct */
        $EkkyoKunProduct = $productRepository->find($id);
        echo 'oooo'.$id.'';
        if ($EkkyoKunProduct) {
            $productRepository->update($EkkyoKunProduct, $deny);
        } else {
            $productRepository->create($id, $deny);
        }
    }
}
