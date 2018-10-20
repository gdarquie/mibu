<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class PersonnageControllerTest extends ApiTestCase
{
    public function testPostPersonnage()
    {
        $fiction = $this->createFiction();

        $data = array(
            "titre" => "Barius",
            "description" => "Le Sage",
            "prenom" => "Barius",
            "nom" => "Le Sage",
            "anneeNaissance" => 0,
            "anneeMort" => 120,
            "genre" => "h",
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/personnages', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);


        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $personnageUrl = $response->getHeader('Location');
        $response = $this->client->get($personnageUrl[0], [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('nom', $payload, "Il n'y a pas de champ nom");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($personnage->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPersonnages()
    {
        $fiction = $this->createFiction();
        $element1 = $this->createPersonnageFiction($fiction);
        $element2 = $this->createPersonnageFiction($fiction);
        $element3 = $this->createPersonnageFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/fiction/'.$fiction->getId(), [
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

    public function testPutPersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);

        $data = array(
            "titre" => "Okita",
            "description" => "Du Shinsen Gumi",
            "annee_naissance" => 0,
            "annee_mort" => 120,
            "fictionId" => $fiction->getId()
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['description'], $payload['description']);
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testDeletePersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);
        $personnage2 = $this->createPersonnageFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($personnage->getId(), $payload['id']);
        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGeneratePersonnages()
    {
        $fiction = $this->createFiction();

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/generation/fiction='.$fiction->getId().'/limit', [
            'headers' => $this->getAuthorizedHeaders(ApiTestCase::ADMIN),
        ]);
        $this->assertEquals(200, $response->getStatusCode());

        $payload = json_decode($response->getBody(true), true);

    }

}