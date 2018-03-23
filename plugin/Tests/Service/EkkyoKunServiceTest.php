<?php

/*
 * This file is part of the ExampleTest
 *
 * Copyright (C) 2016 LockOn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ExampleTestPlugin\Tests\Service;

use Eccube\Tests\EccubeTestCase;

class EkkyoKunServiceTest extends EccubeTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testgetDataAttribute()
    {
        $key = 'size';
        $actual = $this->app['eccube.plugin.service.ekkyokun']->getDataAttribute($key);
        $this->assertTrue('data-size' === $actual);
    }
}
