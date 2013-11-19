<?php
namespace Application\Models;

class TestimonialTable
{
    protected $tableGateway;

    public function __construct(\Zend\Db\TableGateway\TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();

         return $resultSet;
     }

     public function get($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }

         return $row;
     }

     public function save(Testimonial $testimonial)
     {
         $data = array(
             'name' => $_POST['name'],
             'testimonial' => $_POST['testimonial'],
         );

         $id = (int) $testimonial->getId();
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->get($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Testimonial id does not exist');
             }
         }
     }
}
