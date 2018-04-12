<?php

namespace App\tests\Controller;

use App\Entity\Concept\Fiction;
use App\Tests\ApiTestCase;

class FictionControllerTest extends ApiTestCase
{
    public function testPostFiction()  //pas possible sans textes?
    {
        $data = array(
            'titre' => 'Ajout de titre de texte',
            'description' => 'Une description de fiction comme exemple'
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

    public function testPostFictionWithTextes() // fonction ok!!
    {
        $data = array(
            'titre' => 'Nouvel exemple de titre de fiction',
            'description' => 'Une description de fiction comme exemple'
        );

        $data['textes'][0]['titre'] = 'Test 1';
        $data['textes'][0]['description'] = 'Description 1';
        $data['textes'][0]['type'] = 'Contenu de la promesse';


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

    public function testPutFiction()
    {
        
    }

    public function testGetFiction()
    {

//        $data = array(
//            'titre' => 'Nouvel exemple de titre de fiction',
//            'description' => 'Une description de fiction comme exemple',
//            'promesse' => 'Un contenu de promesse'
//        );

        $fiction = new Fiction();
        $fiction->setTitre('Titre');
        $fiction->setDescription('Description');

        $this->getService('doctrine')->getManager()->persist($fiction);
//        $this->getEntityManager()->persist($fiction);
        $this->getService('doctrine')->getManager()->flush();

        $response = $this->client->get('/fictions/'.$fiction->getId());

        $payload = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('titre', $payload, "Il n'y a pas de champ titre");
dump($payload);die; //setter l'id

//        $this->assertEquals($fiction->getId(), $payload['id']);



//        $this->assertEquals(200, $response->getStatusCode());
    }
}
