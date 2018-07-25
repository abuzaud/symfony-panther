<?php
/**
 * Created by Antoine Buzaud.
 * Date: 25/07/2018
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyControllerTest extends WebTestCase
{
    public function testMyAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertContains(
          'Welcome to Symfony',
          $client->getResponse()->getContent();
        );
    }
}