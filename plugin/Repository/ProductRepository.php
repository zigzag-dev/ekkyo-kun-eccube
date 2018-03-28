<?php

namespace Plugin\EkkyoKun\Repository;

use Doctrine\ORM\EntityRepository;
use Exception;
use Plugin\EkkyoKun\Entity\Product as EkkyoKunProduct;

class ProductRepository extends EntityRepository
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
     * @param $id
     * @param $deny
     * @return bool|EkkyoKunProduct
     */
    public function create($id, $deny)
    {
        try {
            /** @var EkkyoKunProduct $EkkyoKunProduct */
            $EkkyoKunProduct = new EkkyoKunProduct();

            $EkkyoKunProduct
                ->setId($id)
                ->setDeny($deny);

            $em = $this->getEntityManager();
            $em->persist($EkkyoKunProduct);
            $em->flush($EkkyoKunProduct);

            return $EkkyoKunProduct;
        } catch(Exception $e) {
            /** @var \Monolog\Logger $logger */
            $logger = $this->app['monolog.EkkyoKun'];
            $logger->error($e);
        }

        return false;
    }

    /**
     * @param EkkyoKunProduct $EkkyoKunProduct
     * @param $deny
     * @return bool|EkkyoKunProduct
     */
    public function update($EkkyoKunProduct, $deny)
    {
        try {
            $EkkyoKunProduct->setDeny($deny);

            $em = $this->getEntityManager();
            $em->persist($EkkyoKunProduct);
            $em->flush($EkkyoKunProduct);

            return $EkkyoKunProduct;
        } catch (Exception $e) {
            /** @var \Monolog\Logger $logger */
            $logger = $this->app['monolog.EkkyoKun'];
            $logger->error($e);
        }

        return false;
    }
}
