<?php

namespace tests\AppBundle\Controller;

use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase

{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }


    public function testHomepageIsUp()
    {
        $this->client->request('GET', '/{_locale}/');

        static::assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );
    }



}
