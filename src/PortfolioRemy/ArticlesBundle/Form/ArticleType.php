<?php

namespace PortfolioRemy\ArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ArticleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', 'date')
                ->add('titre', 'text', array(
                    'attr' => array(
                        'class' => 'span10'
                    )
                ))
                //champ de type ckeditor pour le contenu
                ->add('contenu', 'ckeditor')
                //ajout de la class 'counter-field' sur le champ résumé
                //ce qui permet d'activer le js comptant le nb de caractères
                //saisis
                ->add('resume', 'textarea', array(
                    'attr' => array(
                        'class' => 'counter-field span12'
                    )
                ))
                //imbrication du formulaire image dans l'article
                ->add('image', new ImageType(), array(
                    'required' => false
                ))
                //insertion d'une liste de catégories à sélection multiple
                ->add('categories', 'entity', array(
                    'class' => 'PortfolioRemyArticlesBundle:Categorie',
                    'property' => 'nom',
                    'multiple' => true,
                    'expanded' => false,
                    'attr' => array(
                        'class' => 'span12'
                    )))
                //insertion d'une liste de tags à sélection multiple
                ->add('tags', 'entity', array(
                    'class' => 'PortfolioRemyArticlesBundle:Tag',
                    'property' => 'nom',
                    'multiple' => true,
                    'expanded' => false,
                    'attr' => array(
                        'class' => 'span12'
                    )
                ));

        //on récupère le factory (usine)
        $factory = $builder->getFormFactory();

        //on ajoute une écoute sur l'évènement PRE_SET_DATA
        $builder->addEventListener(
                FormEvents::PRE_SET_DATA, function(FormEvent $event) use($factory) {
                    $article = $event->getData();
                    if (null === $article) {
                        return;
                    }
                    //si l'article n'est pas encore publié on ajoute le champ publication
                    if (false === $article->getPublication()) {
                        $event->getForm()->add(
                                $factory->createNamed('publication', 'checkbox', null, array('required' => false))
                        );
                    } else {//sinon on supprime le champ publication
                        $event->getForm()->remove('publication');
                    }
                }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PortfolioRemy\ArticlesBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'portfolioremy_articlesbundle_article';
    }

}
