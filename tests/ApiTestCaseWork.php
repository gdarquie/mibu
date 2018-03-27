<?php
/**
 * Created by PhpStorm.
 * User: gaetan
 * Date: 20/03/2018
 * Time: 22:45
 */

namespace App\Tests;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Middleware;

class ApiTestCase extends KernelTestCase
{
    private static $staticClient;

    /**
     * @var Client
     */
    protected $client;

    public static function setUpBeforeClass()
    {
        self::$staticClient = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        self::bootKernel();

    }

    public function setup()
    {
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }

    public function tearDown()
    {

    }

    public function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine')->getManager());
        $purger->purge();
    }

    protected function getService($id)
    {
        return self::$kernel->getContainer()->get($id);
    }

}