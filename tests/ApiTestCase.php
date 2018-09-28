<?php

namespace App\Tests;

use App\Entity\Concept\Fiction;
use App\Entity\Concept\Inscrit;
use App\Entity\Element\Lieu;
use App\Entity\Element\Partie;
use App\Entity\Element\Texte;
use App\Entity\Element\Evenement;
use App\Entity\Element\Personnage;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DomCrawler\Crawler;

class ApiTestCase extends KernelTestCase
{
    CONST TEST_PREFIX = 'index_test.php';

    private static $staticClient;

    /**
     * @var array
     */
    private static $history = array();

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ConsoleOutput
     */
    private $output;

    public static function setUpBeforeClass()
    {
        $_SERVER['APP_ENV'] = 'test';

        $baseUrl = getenv('DATABASE_HOST');

        self::$staticClient = new Client([
            'base_uri' => $baseUrl,
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $handler = HandlerStack::create();
        $handler->push(Middleware::history(self::$history));

        self::bootKernel();

    }

    public function setup()
    {

        $this->client = self::$staticClient;
        // reset the history
        self::$history = array();
        $this->purgeDatabase();
    }

    /**
     * Clean up Kernel usage in this test.
     */
    protected function tearDown()
    {
        // purposefully not calling parent class, which shuts down the kernel
    }

    protected function onNotSuccessfulTest(\Throwable $e)
    {
        if (self::$history && $lastResponse = self::$history->getLastResponse()) {
            if ($lastResponse = $this->getLastResponse()) {

                $this->printDebug('');
                $this->printDebug('<error>Failure!</error> when making the following request:');
                $this->printLastRequestUrl();
                $this->printDebug('');

                $this->debugResponse($lastResponse);
            }
        }
        throw $e;
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

    protected function printLastRequestUrl()
    {
        $lastRequest = $this->getLastRequest();

        if ($lastRequest) {
            $this->printDebug(sprintf('<comment>%s</comment>: <info>%s</info>', $lastRequest->getMethod(), $lastRequest->getUrl()));
        } else {
            $this->printDebug('No request was made.');
        }
    }

    protected function debugResponse(ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $name => $values) {
            $this->printDebug(sprintf('%s: %s', $name, implode(', ', $values)));
        }
        $body = (string) $response->getBody();

        $contentType = $response->getHeader('Content-Type');
        $contentType = $contentType[0];
        if ($contentType == 'application/json' || strpos($contentType, '+json') !== false) {
            $data = json_decode($body);
            if ($data === null) {
                // invalid JSON!
                $this->printDebug($body);
            } else {
                // valid JSON, print it pretty
                $this->printDebug(json_encode($data, JSON_PRETTY_PRINT));
            }
        } else {
            // the response is HTML - see if we should print all of it or some of it
            $isValidHtml = strpos($body, '</body>') !== false;

            if ($isValidHtml) {
                $this->printDebug('');
                $crawler = new Crawler($body);

                // very specific to Symfony's error page
                $isError = $crawler->filter('#traces-0')->count() > 0
                    || strpos($body, 'looks like something went wrong') !== false;
                if ($isError) {
                    $this->printDebug('There was an Error!!!!');
                    $this->printDebug('');
                } else {
                    $this->printDebug('HTML Summary (h1 and h2):');
                }

                // finds the h1 and h2 tags and prints them only
                foreach ($crawler->filter('h1, h2')->extract(array('_text')) as $header) {
                    // avoid these meaningless headers
                    if (strpos($header, 'Stack Trace') !== false) {
                        continue;
                    }
                    if (strpos($header, 'Logs') !== false) {
                        continue;
                    }

                    // remove line breaks so the message looks nice
                    $header = str_replace("\n", ' ', trim($header));
                    // trim any excess whitespace "foo   bar" => "foo bar"
                    $header = preg_replace('/(\s)+/', ' ', $header);

                    if ($isError) {
                        $this->printErrorBlock($header);
                    } else {
                        $this->printDebug($header);
                    }
                }

                /*
                 * When using the test environment, the profiler is not active
                 * for performance. To help debug, turn it on temporarily in
                 * the config_test.yml file (framework.profiler.collect)
                 */
                $profilerUrl = $response->getHeader('X-Debug-Token-Link');
                if ($profilerUrl) {
                    $fullProfilerUrl = $response->getHeader('Host')[0].$profilerUrl[0];
                    $this->printDebug('');
                    $this->printDebug(sprintf(
                        'Profiler URL: <comment>%s</comment>',
                        $fullProfilerUrl
                    ));
                }

                // an extra line for spacing
                $this->printDebug('');
            } else {
                $this->printDebug($body);
            }
        }
    }

    protected function printDebug($string)
    {
        if ($this->output === null) {
            $this->output = new ConsoleOutput();
        }
        $this->output->writeln($string);
    }


    /**
     * @return RequestInterface
     */
    private function getLastRequest()
    {
        if (!self::$history || empty(self::$history)) {
            return null;
        }

        $history = self::$history;

        $last = array_pop($history);

        return $last['request'];
    }

    /**
     * @return ResponseInterface
     */
    private function getLastResponse()
    {
        if (!self::$history || empty(self::$history)) {
            return null;
        }

        $history = self::$history;

        $last = array_pop($history);

        return $last['response'];
    }

    protected function createFiction($titre = 'titre') {

        $fiction = new Fiction();
        $fiction->setTitre($titre);
        $fiction->setDescription('Description');

        $this->getService('doctrine')->getManager()->persist($fiction);
        $this->getService('doctrine')->getManager()->flush();

        return $fiction;
    }

    protected function createInscrit($titre = 'Titre', $pseudo = 'Okita', $email = 'mon@email.fr')
    {
        $inscrit = new Inscrit();

        $inscrit->setPseudo($pseudo);
        $inscrit->setTitre($titre);
        $inscrit->setDescription('Description');
        $inscrit->setPrenom('Prénom');
        $inscrit->setNom('Nom');
        $inscrit->setGenre('Femme');
        $inscrit->setEmail($email);
        $inscrit->setDateNaissance(new \DateTime('1982-01-01'));

        $this->getService('doctrine')->getManager()->persist($inscrit);
        $this->getService('doctrine')->getManager()->flush();

        return $inscrit;
    }

    protected function createEvenementFiction($fiction) {

        $evenement = new Evenement();
        $evenement->setTitre('Titre');
        $evenement->setDescription('Description');
        $evenement->setAnneeDebut('0');
        $evenement->setAnneeFin('100');
        $evenement->setFiction($fiction);

        $this->getService('doctrine')->getManager()->persist($evenement);
        $this->getService('doctrine')->getManager()->flush();

        return $evenement;
    }

    protected function createPersonnageFiction($fiction) {

        $personnage = new Personnage('Barius', 'Le Sage');
        $personnage->setAnneeNaissance(0);
        $personnage->setAnneeMort(120);
        $personnage->setFiction($fiction);

        $this->getService('doctrine')->getManager()->persist($personnage);
        $this->getService('doctrine')->getManager()->flush();

        return $personnage;
    }

    protected function createTexteFiction($fiction) {

        $texte = new Texte('Titre de texte', 'Un contenu de texte', 'promesse');
        $texte->setFiction($fiction);

        $this->getService('doctrine')->getManager()->persist($texte);
        $this->getService('doctrine')->getManager()->flush();

        return $texte;
    }

    protected function createPartieFiction($fiction) {

        $partie = new Partie('Titre de texte','Un exemple de contenu de partie');
        $partie->setFiction($fiction);

        $this->getService('doctrine')->getManager()->persist($partie);
        $this->getService('doctrine')->getManager()->flush();

        return $partie;
    }

    protected function createLieuFiction($fiction) {

        $lieu = new Lieu();
        $lieu->setFiction($fiction);
        $lieu->setTitre('Titre');
        $lieu->setDescription('Description');
        $lieu->setLat(10.786);
        $lieu->setLong(80.766);

        $this->getService('doctrine')->getManager()->persist($lieu);
        $this->getService('doctrine')->getManager()->flush();

        return $lieu;
    }


}