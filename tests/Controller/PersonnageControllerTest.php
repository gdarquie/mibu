<?php

namespace App\tests\Controller;

use App\Tests\ApiTestCase;

class PersonnageControllerTest extends ApiTestCase
{
    public function testPostPersonnage()
    {
        $data = array(
            "titre" => "Barius",
            "description" => "Le Sage",
            "discriminateur" => "personnage",
            "annee_naissance" => 0,
            "annee_mort" => 120
        );

        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/personnages', [
            'body' => json_encode($data)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));

        $fictionUrl = $response->getHeader('Location');
        $response = $this->client->get($fictionUrl[0]);

        $finishedData = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titres', $finishedData, "Il n'y a pas de champ titre");

        echo $response->getBody();
        echo "\n\n";
    }

    public function testGetPersonnage()
    {

    }

    public function testPatchPersonnage()
    {

    }

    public function testDeletePersonnage()
    {

    }
}