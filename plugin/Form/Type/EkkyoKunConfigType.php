<?php

namespace Plugin\EkkyoKun\Form\Type;

use Plugin\EkkyoKun\Entity\Country;
use Plugin\EkkyoKun\Repository\CountryRepository;

class EkkyoKunConfigType extends \Symfony\Component\Form\AbstractType
{
    /**
     * @var \Eccube\Application
     */
    protected $app;

    const NAME = 'ekkyokun_config_form';
    const TOKEN = 'name_token';
    const COUNTRIES = 'name_countries';

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                self::TOKEN,
                'text',
                array(
                    'required' => false,
                    'label' => false,
                    'mapped' => false,
                    'attr' => array(
                        'placeholder' => '弊社からお知らせしたトークンを入力ください。',
                    ),
                )
            )
            ->add(
                self::COUNTRIES,
                'choice',
                array(
                    'choices' => $this->getCountries(),
                    'multiple' => true,
                    'expanded' => true,
                )
            );
    }

    /**
     * @return array
     */
    public function getCountries()
    {
        /** @var CountryRepository $countryRepository */
        $countryRepository = $this->app['plugin.ekkyokun.repository.country'];

        $countries = array();
        /**
         * @var Country $Country
         */
        foreach ($countryRepository->findAll() as $Country) {
            $countries[$Country->getCode()] = $Country->getName();
        }

        return $countries;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NAME;
    }
}
