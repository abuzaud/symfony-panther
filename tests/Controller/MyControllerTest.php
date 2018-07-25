<?php
/**
 * Created by Antoine Buzaud.
 * Date: 25/07/2018
 *
 * Ajouter la variable d'environnement PANTHER_NO_HEADLESS=1
 * [bash] export PANTHER_NO_HEADLESS=1
 * [cmd] set PANTHER_NO_HEADLESS=1
 */

namespace App\Tests\Controller;


use Symfony\Component\Panther\PantherTestCase;

//class MyControllerTest extends WebTestCase
class MyControllerTest extends PantherTestCase
{
    public function testMyAction()
    {
        // On récupère le client et la requête
        $client = static::createPantherClient();
        $client->request('GET', '/');

        # Récupération du crawler
        $crawler = $client->getCrawler();

        # Génération d'un screenshot
        $client->takeScreenshot('screen.jpg');

        # On attends 2 secondes pour le chargement de la page
        sleep(2);

        # On vérifie que le contenu du site ait bien la chaine "Welcome to Symfony"
        $this->assertContains(
            'Symfony',
            $client->getResponse()->getContent()
        );

        # On vérifie qu'on a bien un h1
        $this->assertEquals(1, $crawler->filter('h1')->count());
    }

    public function testDoAction()
    {
        // On récupère le client et la requête
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        sleep(2);
        $link = $crawler->selectLink('How to create your first page in Symfony')->link();
        $crawler = $client->click($link);

        sleep(2);
        $this->assertEquals(
            'Create your First Page in Symfony',
            $crawler->filter('h1')->text()
        );
    }


    public function testFormAction()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/dummy');

        $form = $crawler->selectButton('Envoyer')->form();

        $form['form[email]'] = 'emailnovalide@gmail.com';
        $form['form[name]'] = 'Prout';

        $crawler = $client->submit($form);

        $this->assertContains(
            'Message envoyé',
            $crawler->filter('.success')->text()
        );
    }

    /**/
    public function testFormErrorAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/dummy');

        $form = $crawler->selectButton('Envoyer')->form();

        $form['form[email]'] = 'emailnovalide';
        $form['form[name]'] = 'Prout';

        $client->enableProfiler();
        $crawler = $client->submit($form);
        $duration = $client->getProfile()->getCollector('time')->getDuration();

        sleep(2);
        $this->assertLessThanOrEqual(500, $duration);
        $this->assertContains(
            'This value is not a valid email address.',
            $crawler->filter('ul li')->text());
    }
    /**/
}