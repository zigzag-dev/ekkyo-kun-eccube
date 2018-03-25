<?php

namespace Plugin\EkkyoKun\Form\Type;

use Doctrine\ORM\EntityRepository;
use Plugin\EkkyoKun\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EkkyoKunConfigType extends AbstractType
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $countries = array();
        $selectedCountries = array();

        /**
         * @var Country $Country
         */
        foreach ($options['data'] as $Country) {
            $countries[$Country->getCode()] = $Country->getName();
            if ($Country->getDeny()) {
                $selectedCountries[] = $Country->getCode();
            }
        }

        $builder
            ->add('name', 'choice', array(
                'choices' => $countries,
                'data' => $selectedCountries,
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ekkyokun_config_form';
    }
}
