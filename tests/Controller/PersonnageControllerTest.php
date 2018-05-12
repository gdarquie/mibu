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
            "annee_naissance" => 0,
            "annee_mort" => 120
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/personnages/fiction='.$fiction->getId(), [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $personnageUrl = $response->getHeader('Location');
        $response = $this->client->get($personnageUrl[0]);

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nom', $payload, "Il n'y a pas de champ nom");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals($personnage->getId(), $payload['id']);
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
            "annee_mort" => 120
        );

        $response = $this->client->put(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId(), [
            'body' => json_encode($data)
        ]);
        $this->assertEquals(202, $response->getStatusCode());

        $response = $this->client->get(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
        $this->assertEquals( $data['description'], $payload['description']);
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testDeletePersonnage()
    {
        $fiction = $this->createFiction();
        $personnage = $this->createPersonnageFiction($fiction);

        $response = $this->client->delete(ApiTestCase::TEST_PREFIX.'/personnages/'.$personnage->getId());
        $this->assertEquals(202, $response->getStatusCode());
    }
}