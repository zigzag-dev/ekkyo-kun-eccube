<?php

namespace Plugin\EkkyoKun;

use Eccube\Entity\Product;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\EkkyoKun\Service\EkkyoKunService;

class EkkyoKunEvent
{
    /** @var \Eccube\Application $app */
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param TemplateEvent $event
     */
    public function onRenderProductDetail(TemplateEvent $event)
    {
        $CountryRepository = $this->app['plugin.ekkyokun.repository.country'];

        $parameters = $event->getParameters();

        /** @var Product $Product */
        $Product = $parameters['Product'];

        /** @var EkkyoKunService $ekkyokunService */
        $ekkyokunService = $this->app['eccube.plugin.service.ekkyokun'];

        // http://downloads.ec-cube.net/manual/v3/plugin.pdf 35p
        // Twigのキャッシュを効かせるため、
        // 動的な値を表示したい際は変数化しパラメータで渡す
        $parameters['cos'] = $ekkyokunService->makeCheckOutSource($Product);
        $parameters['denyCountryTag'] = $CountryRepository->getDenyCountriesWithTag();
        $event->setParameters($parameters);

        $replace = <<<EOS
{{cos|raw}}
{{denyCountryTag|raw}}
{% endblock %}
EOS;

        $source = preg_replace('/\{% endblock %\}/', $replace, $event->getSource(), 1);
        $event->setSource($source);
    }

    /**
     * @param EventArgs $event
     */
    public function onAdminProductDetailInit(EventArgs $event)
    {
//        $builder = $event->getArgument('builder');
//        $builder
//            ->add('plg_test', 'choice', array(
//                'choices' => array(0 => '海外販売しない', 1 => '海外販売する'),
//                'data' => array(1),
//                'multiple' => false,
//                'expanded' => true,
//            ));
    }
}
