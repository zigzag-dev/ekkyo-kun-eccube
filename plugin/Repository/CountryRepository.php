<?php

namespace Plugin\EkkyoKun\Repository;

use Doctrine\ORM\EntityRepository;
use Exception;
use Plugin\EkkyoKun\Entity\Country;

class CountryRepository extends EntityRepository
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
     * @param array $data
     */
    public function update($data)
    {
        try {
            $em = $this->getEntityManager();

            $countries = $this->findAll();
            /** @var Country $Country */
            foreach ($countries as $Country) {
                $deny = in_array($Country->getCode(), $data);
                $Country->setDeny($deny);
                $em->persist($Country);
            }
            $em->flush();
        } catch (Exception $e) {
            /** @var \Monolog\Logger $logger */
            $logger = $this->app['monolog.EkkyoKun'];
            $logger->error($e);
        }
    }

    /**
     * @return array
     */
    public function getDenyCountries()
    {
        $result = array();
        $countries = $this->findAll();
        /** @var Country $Country */
        foreach ($countries as $Country) {
            if ($Country->getDeny()) {
                $result[] = $Country;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getDenyCountriesWithTag()
    {
        $countries = $this->getDenyCountries();
        $result = array();
        if (count($countries) > 0) {
            $result[] = '<ul hidden id="zigzag-deny-countries">';
            /** @var Country $Country */
            foreach ($countries as $Country) {
                $result[] = '<li>' . $Country->getCode() . '</li>';
            }
            $result[] = '</ul>';

            return implode('', $result);
        }
        return '';
    }
}
