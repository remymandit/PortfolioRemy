<?php
namespace PortfolioRemy\ArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType {
    
    /**
     * Constructeur du formulaire
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
     public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text', array(
                    'attr' => array(
                        'class' => 'span12'
                    )
                ))
                ->add('prenom', 'text', array(
                    'attr' => array(
                        'class' => 'span12'
                    )
                ))
                ->add('mail', 'email', array(
                    'attr' => array(
                        'placeholder' => 'example@mail.com',
                        'class' => 'span5'
                    )
                ))
                ->add('sujet', 'text', array(
                    'attr' => array(
                        'class' => 'span5'
                    )
                ))
                //champ de type ckeditor pour le contenu
                ->add('message', 'textarea', array(
                    'attr' => array(
                        'rows' => 10,
                        //'cols' => 75,
                        'class' => 'contactMessage span12'
                    )
                ));
    }
    
    /**
     * 
     * @return string
     */
    public function getName() {
        return 'portfolioremy_articlesbundle_contact';
    }    
}
?>
