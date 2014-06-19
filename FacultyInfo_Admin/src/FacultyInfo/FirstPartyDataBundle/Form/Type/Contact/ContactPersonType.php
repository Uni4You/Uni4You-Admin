<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactPersonType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('name', 'text', array('label' => 'firstParty.contact.person.labels.name'));
		$builder -> add('description', 'textarea', array('label' => 'firstParty.contact.person.labels.description', 'required' => false));
		$builder -> add('office', 'text', array('label' => 'firstParty.contact.person.labels.office', 'required' => false));
		$builder -> add('phone', 'text', array('label' => 'firstParty.contact.person.labels.phone', 'required' => false));
		$builder -> add('email', 'email', array('label' => 'firstParty.contact.person.labels.email', 'required' => false));
		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'contactPerson';
	}

}
