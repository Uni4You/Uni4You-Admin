<?php
namespace FacultyInfo\UserBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PasswordType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('password', 'repeated', array('first_name' => 'pwd', 'second_name' => 'pwd_repeat', 'invalid_message' => 'userManagement.update.passwordsDontMatch' ,'first_options' => array('label' => 'userManagement.labels.firstPassword'), 'second_options' => array('label' => 'userManagement.labels.secondPassword')));
		$builder -> add('save', 'submit', array('label' => 'userManagement.update.savePassword'));
	}

	public function getName() {
		return 'updatePassword';
	}

}
