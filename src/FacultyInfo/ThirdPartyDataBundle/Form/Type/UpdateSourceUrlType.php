<?php
namespace FacultyInfo\ThirdPartyDataBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateSourceUrlType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('sourceUrl', 'text', array('label' => 'thirdParty.labels.sourceUrl'));
		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'updateSourceUrl';
	}

}
