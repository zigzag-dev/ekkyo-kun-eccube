<?php

namespace Plugin\EkkyoKun\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Exception;
use Plugin\EkkyoKun\Entity\Country;

class CountryRepository extends EntityRepository
{
    /**
     * @param $data
     */
    public function update($data)
    {
        try {
            $em = $this->getEntityManager();

            $countries = $this->findAll();
            foreach ($countries as $country) {
                $deny = in_array($country->getCode(), $data);
                $country->setDeny($deny);
                $em->persist($country);
            }
            $em->flush();
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * @return array
     */
    public function getDenyCountries()
    {
        $result = array();
        $countries = $this->findAll();
        foreach ($countries as $country) {
            if ($country->getDeny()) {
                $result[] = $country;
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
            foreach ($countries as $country) {
                $result[] = '<li>' . $country->getCode() . '</li>';
            }
            $result[] = '</ul>';

            return implode('', $result);
        }
        return '';
    }
}
