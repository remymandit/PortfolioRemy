<?php
namespace PortfolioRemy\ArticlesBundle\CompteurVues;

use PortfolioRemy\ArticlesBundle\Entity\Article;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * classe permettant d'atualiser le compteur de vue d'un article
 *
 */
class CompteurVuesListener
{
    protected $nbVues;
    
    /**
     * contructeur par défaut qui récupère le compteur de vue avant
     * affichage de l'article
     */
    public function __construct(Article $article) {
        
        $this->nbVues = $article.nbVues;
    }
    
    /**
     * Méthode pour incrémenter le nombre de vues et l'enregistrer dans
     * la base
     */
    protected function incrementeCompteurVues()
    {
        
    }
    
    
    /**
     * L'évènement est déclenché lorsque le contrôleur n'a pas retourné d'objet
     * Response
     * 
     * Méthode pour construire une réponse à partir du retour du
     * contrôleur de la page en cours
     * 
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        //On récupère le retour du contrôleur (ce qu'il y a dans le return)
        $val = $event->getControllerResult();
        
        //On créé une réponse
        $response = new Response();
        
        //on active la surveillance si l'objet Article est retourné
        
        
        //si Article, incrémenter le nbVues, le persiter dans la base
        // et construire la réponse pour l'affichage de l'article
        
        
        //On donne la réponse à l'évènement, qui la donnera au noyau qui,
        //finalement, l'affichera
        $event->setResponse($response);
    }
}
?>
