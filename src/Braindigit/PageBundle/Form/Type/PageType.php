<?php
namespace Braindigit\PageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('content', 'ckeditor',array(
                'config' => array(
                    'filebrowser_image_browse_url' => array(
                        'route'            => 'elfinder',
                        'route_parameters' => array('instance' => 'ckeditor'),
                    ),
                ),
            ))
            ->add('image', 'elfinder', array(
                'instance'=>'form',
                'enable'=>true
            ))
            ->add('publishedOn', 'date')
            ->add('save', 'submit', array('label' => 'Create Page'));
    }

    public function getName()
    {
        return 'page';
    }
}