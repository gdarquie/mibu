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
            "anneeDebut" => "0",
            "anneeFin" => "100",
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/evenements', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $evenementUrl = $response->getHeader('Location');
        $response = $this->client->get($evenementUrl[0], [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetEvenement()
    {
        $fiction = $this->createFiction();
        $evenement = $this->createEvenementFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($evenement->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetEvenements()
    {
        $fiction = $this->createFiction();
        $element1 = $this->createEvenementFiction($fiction);
        $element2 = $this->createEvenementFiction($fiction);
        $element3 = $this->createEvenementFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/evenements/fiction/'.$fiction->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
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

    public function testPutEvenement()
    {
        $fiction = $this->createFiction();
        $evenement = $this->createEvenementFiction($fiction);

        $data = array(
            "titre" => "Titre d'évènement modifié",
            "description" => "Description d'évènement",
            "annee_debut" => "0",
            "annee_fin" => "100",
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

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

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/evenements/'.$evenement->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

}
