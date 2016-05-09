<?php

namespace SocialBase\RestBundle\Tests\Controller;

use joshtronic\LoremIpsum;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 *
 * Messages Test Case
 *
 *
 * @category  Library
 * @copyright Artur Magalhães <nezkal@gmail.com>
 * @package   SocialBase\RestBundle\Tests\Controller
 * @license   GPL-3.0+
 */
class MessagesControllerTest extends WebTestCase
{

    /**
     * @param $message
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function addItem($message)
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/messages.json',
            array(
                "message" => $message
            )
        );

        return $client;
    }


    public function testPostMessagesJsonFormat()
    {
        $lipsum = new LoremIpsum();
        $message = $lipsum->words(2);

        $client = $this->addItem($message);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $data = json_decode($client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('message', $data);
        $this->assertObjectHasAttribute('datetime', $data);

        $this->assertEquals($message, $data->message);
    }


    public function testPutMessagesJsonFormat()
    {
        $lipsum = new LoremIpsum();
        $message = $lipsum->words(2);

        $client = $this->addItem($message);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $data = json_decode($client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $data);
        $client = static::createClient();

        $otherMessage = $lipsum->words(3);

        $crawler = $client->request('PUT', '/api/messages/' . $data->id . '.json',
            array(
                "message" => $otherMessage
            )
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $data = json_decode($client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('message', $data);
        $this->assertObjectHasAttribute('datetime', $data);

        $this->assertEquals($otherMessage, $data->message);
    }


    public function testDeleteMessagesJsonFormat()
    {
        $lipsum = new LoremIpsum();
        $message = $lipsum->words(2);

        $client = $this->addItem($message);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $data = json_decode($client->getResponse()->getContent());

        $this->assertObjectHasAttribute('id', $data);
        $client = static::createClient();

        $crawler = $client->request('DELETE', '/api/messages/' . $data->id . '.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $lastId = $data->id;

        $data = json_decode($client->getResponse()->getContent());

        $this->assertEquals($lastId, $data);

        $crawler = $client->request('GET', '/api/messages/' . $lastId . '.json');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }

    public function testGetMessagesJsonFormat()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/messages.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $contentType = $client->getResponse()->headers->get('content-type');
        $this->assertEquals('application/json', $contentType);

        $data = json_decode($client->getResponse()->getContent());
        $this->assertLessThan(21, sizeof($data));
    }

    public function testGetMessagesJsonWithLimit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/messages.json?limit=10');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetMessagesJsonWithLimitInvalid()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/messages.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
