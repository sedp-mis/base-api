<?php

class BaseApiControllerTest extends TestCase
{
  public function testShow()
  {
    $crawler = $this->client->request('GET', '/posts');

    $this->assertTrue($this->client->getResponse()->isOk());
  }
}