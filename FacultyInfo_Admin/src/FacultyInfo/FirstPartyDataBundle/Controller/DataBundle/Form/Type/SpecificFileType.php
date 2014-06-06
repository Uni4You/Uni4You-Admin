<?php
namespace AIESEC\Portal\DataBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SpecificFileType extends AbstractType
{
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'allowedType' => array(
						'JPG' => 'JPG',
						'PDF' => 'PDF',
				)
		));
	}	

	public function getName ()
	{
		return 'specificFile';
	}

	public function getParent ()
	{
		return 'file';
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->setAttribute('allowedType', $options['allowedType']);
	}

	public function buildView (FormView $view, FormInterface $form, array $options)
	{
		$view->vars['allowedType'] = $options['allowedType'];
	}
}