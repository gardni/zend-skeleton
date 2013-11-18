<?php
namespace Application\Models;

class Testimonial
{
	protected $id;
	protected $name;
	protected $testimonial;

	public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->artist = (!empty($data['name'])) ? $data['name'] : null;
         $this->title  = (!empty($data['testimonial'])) ? $data['testimonial'] : null;
     }

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setTestimonial($testimonial)
	{
		$this->testimonial = $testimonial;
	}

	public function getId()
	{
	 	return $this->id;
	}

	public function getName()
	{
	 	return $this->name;
	}

	public function getTestimonial()
	{
	 	return $this->testimonial;
	}

}