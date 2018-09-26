<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;

class JetonControllerTest extends ApiTestCase
{
    public function testPostCreateJeton()
    {
        $this->createInscrit();

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/jetons');

        $this->assertEquals(200, $response->getStatusCode());
    }
}