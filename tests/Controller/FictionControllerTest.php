<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class FictionControllerTest extends ApiTestCase
{
    public function testPostFiction()
    {
        $data = array(
            'titre' => 'Nouvel exemple de titre de fiction',
            'description' => 'Une description de fiction comme exemple',
            'promesse' => 'Un contenu de promesse'
        );

        $response = $this->client->post('/fictions', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $fictionUrl = $response->getHeader('Location');

        $response = $this->client->get($fictionUrl[0]);

        $finishedData = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $finishedData, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";

    }

    public function testGetFiction()
    {
        $fictionId = 1;

        //createFiction and get its id

        $response = $this->client->get('/fictions/'.$fictionId);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
