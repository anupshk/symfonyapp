<?php
namespace Braindigit\PageBundle\Admin;

//use Braindigit\PageBundle\Form\Type\PageType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PageAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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
            ->add('status', 'text')
            ->add('tags', 'text')
            ->add('ownerId', 'entity', array('class' => 'Braindigit\UserBundle\Entity\User'))
            ->add('publishedOn', 'date')
        ;
        /*$form = new PageType();
        $form->buildForm($formMapper->getFormBuilder(), array());*/
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
        ;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'BraindigitPageBundle:CRUD:edit.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }
}