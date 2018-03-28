<?php

namespace Plugin\EkkyoKun\Tests\Form\Type;

use Plugin\EkkyoKun\Entity\Country;

class EkkyoKunConfigTypeTest extends \Eccube\Tests\Form\Type\AbstractTypeTestCase
{
    /** @var \Eccube\Application */
    protected $app;

    /** @var \Symfony\Component\Form\FormInterface */
    protected $form;

    /** @var array */
    protected $data;

    public function setUp()
    {
        parent::setUp();

        $this->data = array();
        $country = new Country();
        $country->setName('アメリカ');
        $country->setNameEn('United States');
        $country->setCode('US');
        $country->setDeny(false);
        array_push($this->data, $country);

        // CSRF tokenを無効にしてFormを作成
        $this->form = $this->app['form.factory']
            ->createBuilder('ekkyokun_config_form', $this->data, array(
                'csrf_protection' => false,
            ))
            ->getForm();
    }

    public function testValidData()
    {
        $formData = array(
            'name_token' => 'xxxx',
            'name_countries' => array( 'US' )
        );
        $this->form->submit($formData);
        $this->assertTrue($this->form->isValid());
    }

    public function testInvalidData()
    {
        $formData = array(
            'name_countries' => array( 'xx' )
        );
        $this->form->submit($formData);
        $this->assertFalse($this->form->isValid());
    }
}
