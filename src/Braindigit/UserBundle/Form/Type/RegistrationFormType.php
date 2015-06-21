<?php
namespace Braindigit\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('fullname');
        $builder->add('xterms', 'checkbox', array(
            'mapped' => false,
            'constraints' => array(new IsTrue(array(
                'message' => 'braindigit_user.xterms.require'
            )))
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'braindigit_user_registration';
    }
}