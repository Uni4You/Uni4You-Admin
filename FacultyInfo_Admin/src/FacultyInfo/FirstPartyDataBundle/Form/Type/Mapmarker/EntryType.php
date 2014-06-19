<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Mapmarker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EntryType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('name', 'text', array('label' => 'firstParty.mapmarker.entry.labels.name'));
		$builder -> add('description', 'textarea', array('label' => 'firstParty.mapmarker.entry.labels.description', 'attr' => array('row' => 8)));
		$builder -> add('latitude', 'number', array('label' => 'firstParty.mapmarker.entry.labels.latitude'));
		$builder -> add('longitude', 'number', array('label' => 'firstParty.mapmarker.entry.labels.longitude'));
		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'entryType';
	}

}
