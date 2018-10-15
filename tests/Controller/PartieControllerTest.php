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

        $response = $this->postAuthenticate(ApiTestCase::TEST_PREFIX.'/parties', $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $partieUrl = $response->getHeader('Location');
        $response = $this->getAuthenticate($partieUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $response = $this->getAuthenticate(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($partie->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetParties()
    {
        $fiction = $this->createFiction();
        $element1 = $this->createPartieFiction($fiction);
        $element2 = $this->createPartieFiction($fiction);
        $element3 = $this->createPartieFiction($fiction);

        $response = $this->getAuthenticate(ApiTestCase::TEST_PREFIX.'/parties/'.$fiction->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertCount(3, $payload['items']);

        $this->assertArrayHasKey('titre', $payload['items'][0], "Il n'y a pas de champ titre");
        $this->assertEquals($element1->getId(), $payload['items'][0]['id']);
        $this->assertEquals($element2->getId(), $payload['items'][1]['id']);
        $this->assertEquals($element3->getId(), $payload['items'][2]['id']);
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
            "fictionId" => $fiction->getId()
        );

        $response = $this->putAuthenticate(ApiTestCase::TEST_PREFIX.'/parties'.$partie->getId(), $data);

        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->getAuthenticate(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeletePartie()
    {
        $fiction = $this->createFiction();
        $partie = $this->createPartieFiction($fiction);

        $response = $this->deleteAuthenticate(ApiTestCase::TEST_PREFIX.'/parties/'.$partie->getId());

        $this->assertEquals(200, $response->getStatusCode());
    }
}