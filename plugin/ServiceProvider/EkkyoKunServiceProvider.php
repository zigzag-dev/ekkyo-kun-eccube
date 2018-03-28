<?php

namespace Plugin\EkkyoKun\ServiceProvider;

use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Plugin\EkkyoKun\Form\Type\EkkyoKunConfigType;
use Plugin\EkkyoKun\Repository\ConfigRepository;
use Plugin\EkkyoKun\Repository\CountryRepository;
use Plugin\EkkyoKun\Repository\ProductRepository;
use Plugin\EkkyoKun\Service\EkkyoKunService;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class EkkyoKunServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // プラグイン用設定画面を追加
        $app->match(
            '/'.$app['config']['admin_route'].'/plugin/ekkyokun/config',
            'Plugin\EkkyoKun\Controller\ConfigController::index'
        )->bind('plugin_EkkyoKun_config');

        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new EkkyoKunConfigType($app);
            return $types;
        }));

        // Repository
        $app['plugin.ekkyokun.repository.country'] = $app->share(function () use ($app) {
            /** @var CountryRepository $countryRepository */
            $countryRepository = $app['orm.em']->getRepository('Plugin\EkkyoKun\Entity\Country');
            $countryRepository->setApplication($app);
            return $countryRepository;
        });
        $app['plugin.ekkyokun.repository.product'] = $app->share(function () use ($app) {
            /** @var ProductRepository $productRepository */
            $productRepository = $app['orm.em']->getRepository('Plugin\EkkyoKun\Entity\Product');
            $productRepository->setApplication($app);
            return $productRepository;
        });
        $app['plugin.ekkyokun.repository.config'] = $app->share(function () use ($app) {
            /** @var ConfigRepository $configRepository */
            $configRepository = $app['orm.em']->getRepository('Plugin\EkkyoKun\Entity\Config');
            $configRepository->setApplication($app);
            return $configRepository;
        });

        // Service
        $app['eccube.plugin.service.ekkyokun'] = $app->share(function () use ($app) {
            return new EkkyoKunService($app);
        });

        // ログファイル設定
        $app['monolog.EkkyoKun'] = $app->share(function () use ($app){
                $logger = new $app['monolog.logger.class']('plugin.EkkyoKun');
                $file = $app['config']['root_dir'].'/app/log/EkkyoKun.log';
                $RotateHandler = new RotatingFileHandler($file, $app['config']['log']['max_files'], Logger::INFO);
                $RotateHandler->setFilenameFormat(
                    'EkkyoKun_{date}',
                    'Y-m-d'
                );
                $logger->pushHandler(
                    new FingersCrossedHandler(
                        $RotateHandler,
                        new ErrorLevelActivationStrategy(Logger::INFO)
                    )
                );

                return $logger;
            }
        );
    }

    public function boot(BaseApplication $app)
    {
    }
}