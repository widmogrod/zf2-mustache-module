<?php
namespace Mustache\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
        return array(
            'test' => 'wartosc',
            'collection' => array(
                array('name' => 'Uruk Ki', 'description' => 'LOTR character'),
                array('name' => 'Frodo Bobek', 'description' => 'LOTR character'),
            )
        );
    }
}