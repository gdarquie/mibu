<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class PartieControllerTest extends ApiTestCase
{
    public function testPostPartie()
    {
        $fiction = $this->createFiction();

        $data = array(
            'titre' => 'Titre de partie via les tests unitaires',
            'description' => 'Un contenu de partie',
            'fictionId' => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/parties', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $partieUrl = $response->getHeader('Location');
        $response = $this->client->get($partieUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($partie->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPutPartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $data = array(
            "titre" => "Titre de partie modifié",
            "description" => "Un contenu de partie modifié",
            "fiction" => $fiction->getId()
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId(), [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeletePartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());
        $this->assertEquals(202, $response->getStatusCode());
    }
}