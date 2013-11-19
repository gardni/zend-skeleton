<?php
namespace Application\Controller;

class TestimonialController extends \Zend\Mvc\Controller\AbstractActionController
{
    protected $collectionOptions = array('GET', 'POST');
    protected $resourceOptions = array('GET', 'PUT', 'DELETE');
    protected $id;
    protected $postData;
    protected $testimonialTable;

    public function indexAction()
    {
        return new \Zend\View\Model\ViewModel(array(
             'testimonials' => $this->getTestimonialTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $testimonial = new \Application\Models\Testimonial();
            if (!$testimonial_id = $this->getTestimonialTable()->save($testimonial)) {
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            } else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'id' => $testimonial_id)));
            }
        }
        return $this->redirect()->toRoute('testimonial');
    }

    public function viewAction()
    {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('testimonial', array(
                 'action' => 'add'
             ));
         } else {
            return new \Zend\View\Model\ViewModel(array(
                'testimonial' => $this->getTestimonialTable()->get($id),
            ));
         }
    }

    protected function getOptions()
    {

        if ($this->params()->fromRoute('id', false)) {
            return $this->resourceOptions;
        }

        return $this->collectionOptions;
    }

    public function options()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow', implode(',', $this->getOptions()));

        return $response;
    }

    public function setEventManager(\Zend\EventManager\EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $this->events = $events;
        $events->attach('dispatch', array($this, 'checkOptions'), 10);
    }

    public function checkOptions($event)
    {
        if (in_array($event->getRequest()->getMethod(), $this->getOptions())) {
            return;
        }

        $reponse = $this->getResponse();
        $reponse->setStatusCode(405);

        return $reponse;
    }

    public function getTestimonialTable()
    {
        if (!$this->testimonialTable) {
            $sm = $this->getServiceLocator();
            $this->testimonialTable = $sm->get('Application\Models\TestimonialTable');
        }

        return $this->testimonialTable;
    }
}


