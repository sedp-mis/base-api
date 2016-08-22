<?php

use Illuminate\Http\Response;

class BaseApiControllerTest extends TestCase
{
    protected $fake;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh', ['--seed']);

        $this->fake = \Faker\Factory::create();
    }

    public function seedDummyPosts()
    {

        foreach (range(1, 3) as $index) {
            Post::create([
                'title' => $this->fake->text
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

    public function testStore()
    {
        $res = $this->call('POST', '/api/v1/posts', ['title' => $this->fake->text]);
        $dataPost = json_decode($res->getContent(), true);

        $this->assertEquals(1, $dataPost['id']);
        $this->assertArrayHasKey('created_at', $dataPost);
        $this->assertArrayHasKey('updated_at', $dataPost);
        $this->assertEquals(Response::HTTP_CREATED, $res->getStatusCode());
    }

    public function testUpdate()
    {
        // Seed post to be updated.
        $post = Post::create([
            'title' => $this->fake->text
        ]);

        $res = $this->call('PATCH', '/api/v1/posts/'.$post->id, ['title' => 'A New Title']);
        $this->assertEquals(Response::HTTP_ACCEPTED, $res->getStatusCode());

        $updatedPost = Post::findOrFail($post->id);

        $this->assertEquals('A New Title', $updatedPost->title);
    }

    public function testDestroy()
    {
        // Seed post to be deleted.
        $post = Post::create([
            'title' => $this->fake->text
        ]);

        $res = $this->call('DELETE', '/api/v1/posts/'.$post->id);

        $this->assertEquals(Response::HTTP_ACCEPTED, $res->getStatusCode());
        $this->assertEquals('Successfully Deleted!', $res->getContent());
    }
}
