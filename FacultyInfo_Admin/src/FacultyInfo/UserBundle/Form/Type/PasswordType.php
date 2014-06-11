<?php
namespace FacultyInfo\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PasswordType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('first', 'password', array('label' => 'userManagement.labels.firstPassword'));
		$builder -> add('second', 'password', array('label' => 'userManagement.labels.secondPassword'));
		$builder -> add('save', 'submit', array('label' => 'userManagement.update.savePassword'));
	}

	public function getName() {
		return 'updatePassword';
	}

}
