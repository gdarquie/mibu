<?php

namespace App\tests\Controller;


use App\Entity\Concept\Partie;
use App\Tests\ApiTestCase;

class PartieControllerTest extends ApiTestCase
{

    public function testPostPartie()
    {

        $partie = new Partie();
        $partie->setTitre('Première partie');
        $partie->setDescription('Une partie qui contient un chapitre');

        $chapitre1 = new Partie();
        $chapitre1->setTitre('Chapitre 1');
        $chapitre1->setDescription('Premier chapitre');

        $chapitre2 = new Partie();
        $chapitre2->setTitre('Chapitre 2');
        $chapitre2->setDescription('Second chapitre');


        /////////

//        $data = array(
//            'titre' => 'Partie 1',
//            'description' => 'Partie qui contient des chapitres'
//        );
//
//        $response = $this->client->post(ApiTestCase::TEST_PREFIX.'/fictions', [
//            'body' => json_encode($data)
//        ]);
//
//
//        $this->assertEquals(201, $response->getStatusCode());
//        $this->assertTrue($response->hasHeader('Location'));
//
//        $fictionUrl = $response->getHeader('Location');
//        $response = $this->client->get($fictionUrl[0]);
//
//        $payload = json_decode($response->getBody(true), true);
//        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
//
//        echo $response->getBody();
//        echo "\n\n";

    }
}