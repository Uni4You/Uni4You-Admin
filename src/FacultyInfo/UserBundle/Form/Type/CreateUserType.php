<?php
namespace FacultyInfo\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateUserType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('name', 'text', array('label' => 'userManagement.labels.name'));
		$builder -> add('email', 'email', array('label' => 'userManagement.labels.email'));
		$builder -> add('save', 'submit', array('label' => 'userManagement.create.save'));
	}

	public function getName() {
		return 'updateUser';
	}

}
