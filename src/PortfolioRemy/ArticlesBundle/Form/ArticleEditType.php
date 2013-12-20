<?php

namespace PortfolioRemy\ArticlesBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;


class ArticleEditType extends ArticleType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //on fait appel à la méthode buildForm du parent
        parent::buildForm($builder, $options);
        //on supprime le champ date qu'on ne veut pas modifier
        $builder->remove('date');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'portfolioremy_articlesbundle_articleedit';
    }
}
