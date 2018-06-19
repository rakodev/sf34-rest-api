<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OfferControllerTest extends WebTestCase
{
    public function testPostOffer()
    {
        $params = [
            'title' => 'PHPUnit title',
            'description' => 'PHPUnit description',
            'email' => uniqid('phpunit',true).'@phpunit.com',
            'image_url' => 'http://www.bouldersonbroadway.net/wp-content/uploads/2017/02/450-58931ea445084-1024x683.jpg'
        ];
        $client = static::createClient();
        $client->request('POST', '/offer', $params);
//        echo $client->getResponse()->getContent();die;
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetOffers()
    {
        $client = static::createClient();
        $client->request('GET', '/offers');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testGetOffer()
    {
        $client = static::createClient();
        $client->request('GET', '/offers/1');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testPutOffer()
    {
        $params = [
            'title' => 'PHPUnit title PUT',
            'description' => 'PHPUnit description PUT',
            'email' => uniqid('phpunit',true).'@phpunit.com',
            'image_url' => 'http://www.bouldersonbroadway.net/wp-content/uploads/2017/02/450-58931ea445084-1024x683.jpg'
        ];
        $client = static::createClient();
        $client->request('PUT', '/offer/1', [], [], array('CONTENT_TYPE' => 'application/json'), json_encode($params));
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testPatchOffer()
    {
        $params = [
            'title' => 'PHPUnit title PATCH'
        ];
        $client = static::createClient();
        $client->request('PATCH', '/offer/1', [], [], array('CONTENT_TYPE' => 'application/json'), json_encode($params));
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testDeleteOffer()
    {
        $client = static::createClient();
        $client->request('DELETE', '/offer/1');
        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}