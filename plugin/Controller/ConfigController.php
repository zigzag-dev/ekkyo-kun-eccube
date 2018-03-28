<?php

namespace Plugin\EkkyoKun\Controller;

use Plugin\EkkyoKun\Entity\Config;
use Plugin\EkkyoKun\Entity\Country;
use Plugin\EkkyoKun\Form\Type\EkkyoKunConfigType;
use Plugin\EkkyoKun\Repository\ConfigRepository;
use Plugin\EkkyoKun\Repository\CountryRepository;

class ConfigController
{
    /**
     * EkkyoKun用設定画面
     *
     * @param \Eccube\Application $app
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(\Eccube\Application $app, \Symfony\Component\HttpFoundation\Request $request)
    {
        /** @var CountryRepository $countryRepository */
        $countryRepository = $app['plugin.ekkyokun.repository.country'];
        /** @var ConfigRepository $configRepository */
        $configRepository = $app['plugin.ekkyokun.repository.config'];
        /** @var Config $Config */
        $Config = $configRepository->findOneBy(array('key' => 'token',));

        /** @var \Symfony\Bridge\Monolog\Logger $logger */
        $logger = $app['monolog.EkkyoKun'];

        /** @var \Symfony\Component\Form\FormFactory $formFactory */
        $formFactory = $app['form.factory'];
        /** @var \Symfony\Component\Form\FormBuilder $builder */
        $builder = $formFactory->createBuilder(EkkyoKunConfigType::NAME);

        $selectedCountries = array();
        /** @var Country $Country */
        foreach ($countryRepository->findAll() as $Country) {
            if ($Country->getDeny()) {
                $selectedCountries[] = $Country->getCode();
            }
        }
        $builder->get(EkkyoKunConfigType::TOKEN)->setData($Config->getValue());
        $builder->get(EkkyoKunConfigType::COUNTRIES)->setData($selectedCountries);

        /** @var \Symfony\Component\Form\Form $form */
        $form = $builder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $token = $form[EkkyoKunConfigType::TOKEN]->getData();
                $countries = $form[EkkyoKunConfigType::COUNTRIES]->getData();
                $configRepository->updateToken($Config, $token);
                $countryRepository->update($countries);
                // src/Eccube/Resource/locale/message.ja.yml
                $app->addSuccess('admin.save.complete', 'admin');
                $logger->info('countries', $countries);
            }
        }

        return $app->render('EkkyoKun/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
            'signup_url' => $app['config']['EkkyoKun']['const']['url']['signup'],
            'inquiry_url' => $app['config']['EkkyoKun']['const']['url']['inquiry'],
            'token' => $Config->getValue(),
        ));
    }
}
