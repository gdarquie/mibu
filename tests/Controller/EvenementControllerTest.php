<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class EvenementControllerTest extends ApiTestCase
{
    public function testPostEvenement()
    {
        $fiction = $this->createFiction();

        $data = array(
            "titre" => "Titre d'évènement via post évènement",
            "description" => "Description d'évènement",
            "annee_debut" => "0",
            "annee_fin" => "100",
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/evenements', [
            'body' => json_encode($data)
        ]);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $evenementUrl = $response->getHeader('Location');
        $response = $this->client->get($evenementUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetEvenement()
    {
        $fiction = $this->createFiction();
        $evenement = $this->createEvenementFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($evenement->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testPutEvenement()
    {
        $fiction = $this->createFiction();
        $evenement = $this->createEvenementFiction($fiction);

        $data = array(
            "titre" => "Titre d'évènement modifié",
            "description" => "Description d'évènement",
            "annee_debut" => "0",
            "annee_fin" => "100",
            "fiction" => $fiction->getId()
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId(), [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['titre'], $payload['titre']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteEvenement()
    {
        $fiction = $this->createFiction();
        $evenement = $this->createEvenementFiction($fiction);
        $evenement2 = $this->createEvenementFiction($fiction); //use in test

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId());
        $this->assertEquals(200, $response->getStatusCode());
    }

}