<?php

namespace Plugin\EkkyoKun\Controller;

use Eccube\Application;
use Plugin\EkkyoKun\Entity\Country;
use Symfony\Component\HttpFoundation\Request;

class ConfigController
{
    /**
     * EkkyoKun用設定画面
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        /** @var \Symfony\Component\Form\FormFactory $formFactory */
        $CountryRepository = $app['plugin.ekkyokun.repository.country'];
        $countries = $CountryRepository->findAll();

        /** @var \Symfony\Component\Form\FormFactory $formFactory */
        $formFactory = $app['form.factory'];
        /** @var \Symfony\Component\Form\FormBuilder $builder */
        $builder = $formFactory->createBuilder('ekkyokun_config_form', $countries);
        /** @var \Symfony\Component\Form\Form $form */
        $form = $builder->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $CountryRepository->update($data['name']);
                // src/Eccube/Resource/locale/message.ja.yml
                $app->addSuccess('admin.save.complete', 'admin');
            }
        }

        return $app->render('EkkyoKun/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
        ));
    }
}
