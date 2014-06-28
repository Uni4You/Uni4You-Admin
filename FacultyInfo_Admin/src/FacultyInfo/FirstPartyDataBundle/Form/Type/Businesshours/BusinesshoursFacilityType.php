<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Businesshours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FacultyInfo\FirstPartyDataBundle\Entity\BusinesshoursFacility;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusinesshoursFacilityType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('name', 'text');

		$builder -> add('semesterMonday', new BusinesshoursType());
		$builder -> add('semesterTuesday', new BusinesshoursType());
		$builder -> add('semesterWednesday', new BusinesshoursType());
		$builder -> add('semesterThursday', new BusinesshoursType());
		$builder -> add('semesterFriday', new BusinesshoursType());
		$builder -> add('semesterSaturday', new BusinesshoursType());
		$builder -> add('semesterSunday', new BusinesshoursType());

		$builder -> add('breakMonday', new BusinesshoursType());
		$builder -> add('breakTuesday', new BusinesshoursType());
		$builder -> add('breakWednesday', new BusinesshoursType());
		$builder -> add('breakThursday', new BusinesshoursType());
		$builder -> add('breakFriday', new BusinesshoursType());
		$builder -> add('breakSaturday', new BusinesshoursType());
		$builder -> add('breakSunday', new BusinesshoursType());

		$builder -> add('save', 'submit', array('label' => 'form.save'));
	}

	public function getName() {
		return 'businesshours';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver -> setDefaults(array('cascade_validation' => true, ));
	}

}
