<?php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Application\Models\TestimonialTable' =>  function($sm) {
                     $tableGateway = $sm->get('TestimonialTableGateway');
                     $table = new \Application\Models\TestimonialTable($tableGateway);
                     return $table;
                 },
                 'TestimonialTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new  \Zend\Db\ResultSet\ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new \Application\Models\Testimonial());
                     return new \Zend\Db\TableGateway\TableGateway('testimonial', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}
