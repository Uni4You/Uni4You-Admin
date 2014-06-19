<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Mapmarker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('title', 'text', array('label' => 'firstParty.mapmarker.category.create.labels.title'));
		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'createCategoryType';
	}

}
