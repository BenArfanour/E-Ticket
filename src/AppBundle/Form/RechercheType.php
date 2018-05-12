<?php
/**
 * Created by PhpStorm.
 * User: x0geek
 * Date: 4/28/18
 * Time: 3:36 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends  AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recherche','text',array('attr'=> array('class'=>'input-medium search-query')));

    }
    public function getName()
    {
        return 'AppBundle_recherche';
    }

}