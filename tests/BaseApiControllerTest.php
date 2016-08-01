<?php

class BaseApiControllerTest extends TestCase
{
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/api/v1/posts');

        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertEquals(count(json_decode($this->client->getResponse()->getContent())), 3);
    }

    public function testIndexWithAttributes()
    {
        $crawler = $this->client->request('GET', '/api/v1/posts?attributes[]=id&attributes[]=title');

        $this->assertTrue($this->client->getResponse()->isOk());
        $json = json_decode($this->client->getResponse()->getContent(), true);

        //getting the array $json[0] to find for the attribs
        $attributes = $json[key($json)];
        $this->assertArrayHasKey('id', $attributes);
        $this->assertArrayHasKey('title', $attributes);
    }

    public function testIndexWithASingleRelations()
    {
        $crawler = $this->client->request('GET', '/api/v1/posts?relations[comment][attributes][]=id&relations[comment][attributes][]=text');
        $this->assertTrue($this->client->getResponse()->isOk());
        $json = json_decode($this->client->getResponse()->getContent(), true);
    }
}