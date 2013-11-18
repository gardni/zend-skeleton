<?php
namespace Application\Controller;

class UserController extends AbstractRestfulController
{
    protected $collectionOptions = array('GET', 'POST');
    protected $resourceOptions = array('GET', 'PUT', 'DELETE');

    protected function getOptions()
    {
        if ($this->params->fromRoute('id', false)) {
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

    public function setEventManager(EventManagerInterface $events)
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

        return new \Zend\View\Model\JsonModel($result);
    }

    public function update($id, $data)
    {
        $user_api_service = $this->getServiceLocator()->get('userAPIService');
        $result = $user_api_service->update($id, $data);
        $response = $this->getResponse();
        $reponse->setStatusCode(201);

        return new \Zend\View\Model\JsonModel($result);
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
