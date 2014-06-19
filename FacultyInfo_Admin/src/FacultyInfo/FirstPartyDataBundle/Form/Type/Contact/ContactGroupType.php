<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactGroupType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('title', 'text', array('label' => 'firstParty.contact.group.labels.title'));
		$builder -> add('description', 'textarea', array('label' => 'firstParty.contact.group.labels.description', 'required' => false));
		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'contactGroup';
	}

}
