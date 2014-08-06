<?php
namespace FacultyInfo\FirstPartyDataBundle\Form\Type\Businesshours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusinesshoursType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder -> add('open', 'checkbox', array('required' => false));
		$builder -> add('openingtime', 'time', array('required' => false));
		$builder -> add('closingtime', 'time', array('required' => false));
	}

	public function getName() {
		return 'businesshours';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		$resolver -> setDefaults(array('data_class' => 'FacultyInfo\FirstPartyDataBundle\Entity\Businesshours', 'validation_groups' => function(FormInterface $form) {
			$data = $form -> getData();
			if ($data -> isOpen()) {
				return array('Default', 'time_required');
			} else {
				return array('Default');
			}
		}, ));
	}

}
