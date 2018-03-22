<?php

namespace Plugin\EkkyoKun\ServiceProvider;

use Eccube\Application;
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossedHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Plugin\EkkyoKun\Form\Type\EkkyoKunConfigType;
use Plugin\EkkyoKun\Service\EkkyoKunService;
use Plugin\ExampleTest\Form\Type\ExampleTestConfigType;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;

class EkkyoKunServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        // プラグイン用設定画面を追加
        // https://www.shiro8.net/blog/eccube_report/637.html
        $app->match(
            '/'.$app['config']['admin_route'].'/plugin/ekkyokun/config',
            'Plugin\EkkyoKun\Controller\ConfigController::index'
        )->bind('plugin_EkkyoKun_config');

        // Form 新規フォームの作成 -> 既存フォームの拡張ではない
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new EkkyoKunConfigType($app);
            return $types;
        }));

        // Repository
        $app['plugin.ekkyokun.repository.country'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\EkkyoKun\Entity\Country');
        });

        // Service
        $app['eccube.plugin.service.ekkyokun'] = $app->share(function () use ($app) {
            return new EkkyoKunService($app);
        });

        // ログファイル設定
        $app['monolog.EkkyoKun'] = $app->share(
            function ($app) {

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