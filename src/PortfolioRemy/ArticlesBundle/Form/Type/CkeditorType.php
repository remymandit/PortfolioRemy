<?php
namespace PortfolioRemy\ArticlesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * type de champ héritant de toutes les fonctionnalités d'un textarea (grâce à
 * la méthode getParent()) tout en disposant de la classe CSS ckeditor
 * (définit dans la méthode setDefaultOptions())
 */
class CkeditorType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'attr' => array('class' => 'ckeditor')
        ));
    }
    
    public function getParent() {
        return 'textarea';
    }
    
    public function getName() {
        return 'ckeditor';
    }
}

?>
