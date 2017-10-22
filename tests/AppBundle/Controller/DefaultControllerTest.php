<?php

namespace tests\AppBundle\Controller;

use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Client;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultControllerTest extends WebTestCase

{


    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fr/');
        $this->assertEquals(1, $crawler->filter('p:contains("Billeterie en ligne")')->count());
    }

    public function testLinkHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fr/');
        $linkReservation = $crawler->filter('a:contains("Réservation")');
        $crawler = $client->click($linkReservation->link());
        $this->assertEquals(1, $crawler->filter('p:contains("Remplissez le formulaire pour chaque visiteur")')->count());
    }

    public function testForm()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/fr/order');
        $this->form = $this->crawler->selectButton('Valider')->form();
        $this->value = $this->form->getPhpValues();
        $this->value['booking']['visitDate'] = '2018-02-15';
        $this->value['booking']['email'] = 'test@gmail.com';
        $this->value['booking']['tickets']['0']['name'] = 'testName';
        $this->value['booking']['tickets']['0']['firstName'] = 'testFirstName';
        $this->value['booking']['tickets']['0']['birthDate'] = '1981-06-09';
        $this->value['booking']['tickets']['0']['country'] = 'FR';
        $this->value['booking']['tickets']['1']['name'] = 'retestName';
        $this->value['booking']['tickets']['1']['firstName'] = 'retestFirstName';
        $this->value['booking']['tickets']['1']['birthDate'] = '2015-06-09';
        $this->value['booking']['tickets']['1']['country'] = 'FR';

    }

    public function testHoliday()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/fr/order');
        $this->form = $this->crawler->selectButton('Valider')->form();
        $this->value = $this->form->getPhpValues();
        $this->value['booking']['visitDate'] = '25/12/2017';
        $this->value['booking']['email'] = 'test@test.com';
        $this->value['booking']['tickets']['0']['name'] = 'testName';
        $this->value['booking']['tickets']['0']['firstName'] = 'testFirstName';
        $this->value['booking']['tickets']['0']['country'] = 'FR';
        $this->value['booking']['tickets']['0']['birthDate'] = '1981-09-06';
        $this->value['booking']['tickets']['0']['ticketType'] = 'demi-journee';
        $this->crawler = $this->client->request(
            $this->form->getMethod(),
            $this->form->getUri(),
            $this->value,
            $this->form->getPhpFiles()
        );
        $this->assertContains('Désolé,  le musée est fermé ce jour',
            $this->client->getResponse()->getContent());

    }

    public function testTuesday()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/fr/order');
        $this->form = $this->crawler->selectButton('Valider')->form();
        $this->value = $this->form->getPhpValues();
        $this->value['booking']['visitDate'] = '26/12/2017';
        $this->value['booking']['email'] = 'test@test.com';
        $this->value['booking']['tickets']['0']['name'] = 'testName';
        $this->value['booking']['tickets']['0']['firstName'] = 'testFirstName';
        $this->value['booking']['tickets']['0']['country'] = 'FR';
        $this->value['booking']['tickets']['0']['birthDate'] = '1981-09-06';
        $this->value['booking']['tickets']['0']['ticketType'] = 'demi-journee';
        $this->crawler = $this->client->request(
            $this->form->getMethod(),
            $this->form->getUri(),
            $this->value,
            $this->form->getPhpFiles()
        );
        $this->assertContains('Désolé, le musée est fermé le mardi',
            $this->client->getResponse()->getContent());
    }
public function testTodayIsMoreThan14H()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/fr/order');
        $this->form = $this->crawler->selectButton('Valider')->form();
        $this->value = $this->form->getPhpValues();
        $this->value['booking']['visitDate'] = '26/12/2017';
        $this->value['booking']['email'] = 'test@test.com';
        $this->value['booking']['tickets']['0']['name'] = 'testName';
        $this->value['booking']['tickets']['0']['firstName'] = 'testFirstName';
        $this->value['booking']['tickets']['0']['country'] = 'FR';
        $this->value['booking']['tickets']['0']['birthDate'] = '1981-09-06';
        $this->value['booking']['tickets']['0']['ticketType'] = 'demi-journee';
        $this->crawler = $this->client->request(
            $this->form->getMethod(),
            $this->form->getUri(),
            $this->value,
            $this->form->getPhpFiles()
        );
        $this->assertContains('Désolé, le musée est fermé le mardi',
            $this->client->getResponse()->getContent());
    }

}


