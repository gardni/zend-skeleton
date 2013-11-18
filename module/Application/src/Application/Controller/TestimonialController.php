<?php
namespace Application\Controller;

class TestimonialController extends \Zend\Mvc\Controller\AbstractActionController
{
    protected $collectionOptions = array('GET', 'POST');
    protected $resourceOptions = array('GET', 'PUT', 'DELETE');
    protected $id;
    protected $postData;
    protected $testimonialTable;

    public function getTestimonialTable()
    {
        if (!$this->$testimonialTable) {
            $sm = $this->getServiceLocator();
            $this->testimonialTable = $sm->get('Application\Models\TestimonialTable');
        }

        return $this->testimonialTable;
    }
    public function indexAction()
    {
        die('ok');
        return new \Zend\View\Model\ViewModel(array(
             'testimonials' => $this->getTestimonialTable()->fetchAll(),
         ));
    }

    public function getAction()
    {
        die('so');
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

    public function create($data)
    {

        $user_api_service = $this->getServiceLocator()->get('userAPIService');
        $result = $user_api_service->create($data);
        $response = $this->getResponse();
        $reponse->setStatusCode(201);
        die('ok');

        return new \Zend\View\Model\JsonModel($result);
    }

    public function update($id, $data)
    {
        die('sasdas');
        $user_api_service = $this->getServiceLocator()->get('userAPIService');
        $result = $user_api_service->update($id, $data);
        $response = $this->getResponse();
        $reponse->setStatusCode(201);

        return new \Zend\View\Model\JsonModel($result);
    }

    public function getList()
    {
        die('here');
    }

    public function deleteList()
    {
        $reponse = $this->getResponse();
        $reponse->setStatusCode(400);
        $result = array(
            'Error' => array(
                'HTTP Status' => '400',
                'Code' => '123',
                'Message' => 'A User ID is required to delete a user',
                'More Info' => 'http://www.mysite.com/api/docs/user/delete',
            ),
        );

        return new \Zend\View\Model\JsonModel($result);
    }
}


