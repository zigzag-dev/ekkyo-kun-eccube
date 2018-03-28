<?php

namespace Plugin\EkkyoKun\Repository;

use Doctrine\ORM\EntityRepository;
use Exception;
use Plugin\EkkyoKun\Entity\Config;

class ConfigRepository extends EntityRepository
{
    /**
     * @var \Eccube\Application
     */
    protected $app;

    public function setApplication(\Eccube\Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return string|null
     */
    public function findToken()
    {
        $Config = $this->findOneBy(array('key' => 'token'));
        return $Config->getValue();
    }

    /**
     * @param Config $Config
     * @param string $token
     * @return Config
     */
    public function updateToken($Config, $token)
    {
        try {
            $em = $this->getEntityManager();
            $Config->setValue($token);
            $em->persist($Config);
            $em->flush();
        } catch (Exception $e) {
            /** @var \Monolog\Logger $logger */
            $logger = $this->app['monolog.EkkyoKun'];
            $logger->error($e);
        }

        return $Config;
    }
}
