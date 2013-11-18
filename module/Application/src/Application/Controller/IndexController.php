<?php
namespace Application\Controller;

class IndexController extends \Zend\Mvc\Controller\AbstractActionController
{
    public function indexAction()
    {
        return new \Zend\View\Model\ViewModel();
    }
}
