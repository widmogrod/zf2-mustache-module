<?php
namespace Mustache\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class TestController extends AbstractActionController
{
    public function indexAction()
    {
        $model = array(
            'test' => 'wartosc',
            'collection' => array(
                array('name' => 'Uruk Ki', 'description' => 'LOTR character'),
                array('name' => 'Frodo Bobek', 'description' => 'LOTR character'),
            )
        );

        return $model;
   }

    public function jsAction()
    {

    }
}