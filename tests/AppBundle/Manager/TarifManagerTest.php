<?php

namespace tests\AppBundle\Manager;

use AppBundle\Entity\Tarif;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCaseTestCase;
use AppBundle\Entity\Ticket;
use AppBundle\Manager\TarifManager ;

class TarifManagerTest extends KernelTestCase
{

    public function testTarifIsFree() {
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $service = $container->get('tarif.manager');
        $result = $service->tarifFromAge(new \DateTime("2015-08-31"))->getTarifName();
        $this->assertEquals("Free", $result);
    }


    public function testTarifIsNormal() {
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $service = $container->get('tarif.manager');
        $result = $service->tarifFromAge(new \DateTime("1981-08-31"))->getTarifName();
        $this->assertEquals("Regular", $result);
    }
    public function testTarifIsSenior() {
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $service = $container->get('tarif.manager');
        $result = $service->tarifFromAge(new \DateTime("1925-08-31"))->getTarifName();
        $this->assertEquals("Senior", $result);
    }
    public function testTarifIsChild() {
        $kernel = static::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();
        $service = $container->get('tarif.manager');
        $result = $service->tarifFromAge(new \DateTime("2010-08-31"))->getTarifName();
        $this->assertEquals("Child", $result);
    }


}