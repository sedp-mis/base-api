<?php

class BaseApiControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh', ['--seed']);
    }

    public function seedDummyPosts()
    {
        $fake = \Faker\Factory::create();

        foreach (range(1, 3) as $index) {
            Post::create([
                'title' => $fake->text
            ]);
        }
    }

    public function testIndex()
    {
        $this->seedDummyPosts();

        $crawler = $this->client->request('GET', '/api/v1/posts');

        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertEquals(count(json_decode($this->client->getResponse()->getContent())), 3);
    }

    public function testIndexWithAttributes()
    {
        $this->seedDummyPosts();

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
        $this->seedDummyPosts();

        $crawler = $this->client->request('GET', '/api/v1/posts?relations[comments][attributes][]=id&relations[comments][attributes][]=text');
        $this->assertTrue($this->client->getResponse()->isOk());
        $json = json_decode($this->client->getResponse()->getContent(), true);
    }
}