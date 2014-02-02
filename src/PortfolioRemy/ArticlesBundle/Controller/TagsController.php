<?php
// chemin où se trouve le contrôleur
namespace PortfolioRemy\ArticlesBundle\Controller;

// les imports
// le contrôleur hérite du contrôleur de base
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TagsController extends Controller
{
    /**
     * afficher la liste de articles d'une catégorie
     * 
     * @param type $categorie
     * @return type
     */
    public function categorieAction($categorie)
    {
        $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                ->getAvecCategories(array($categorie));
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:indexCategorie.html.twig', array(
            'articles' => $liste
        ));
    }
    
    /**
     * afficher la liste des articles d'un tag donné
     * @param type $tag
     * @return type
     */
    public function tagAction($tag)
    {
        $liste=$this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                ->getAvecTags(array($tag));
        return $this->render('PortfolioRemyArticlesBundle:Articles:indexCategorie.html.twig', array(
            'articles' => $liste
        ));
    }
}
?>
