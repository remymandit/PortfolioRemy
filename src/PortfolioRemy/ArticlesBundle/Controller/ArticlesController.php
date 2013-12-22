<?php
// chemin où se trouve le contrôleur
namespace PortfolioRemy\ArticlesBundle\Controller;

// les imports
// le contrôleur hérite du contrôleur de base
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// le contrôleur va utiliser les objets Article et ArticleType
use PortfolioRemy\ArticlesBundle\Entity\Article;
use PortfolioRemy\ArticlesBundle\Form\ArticleType;
use PortfolioRemy\ArticlesBundle\Form\ArticleEditType;
// pour sécuriser les actions à certains rôles
use JMS\SecurityExtraBundle\Annotation\Secure;
// le contrôleur utilise les objets Contact et ContactType
use PortfolioRemy\ArticlesBundle\Entity\Contact;
use PortfolioRemy\ArticlesBundle\Form\ContactType;

class ArticlesController extends Controller
{
    /**
     * 
     * @param integer $page
     * @return tableau d'objet Article
     * @throws exception
     */
    public function indexAction($page)
    {
        //récupération de tous les articles dans la base via le repository
        $articles = $this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                //récupère les articles triés par date décroissant
                //avec les images, catégories et tags associés
                ->getArticles(6, $page); 
                
        return $this->render('PortfolioRemyArticlesBundle:Articles:index.html.twig', array(
            'articles' => $articles,
            'page' => $page,
            'nombrePage' => ceil(count($articles)/6),
            'nombreArticles' => 6
        ));
    }
    
    /**
     * permet d'afficher le formulaire de contact
     * ou de l'envoyer si valide et afficher
     * la page d'accueil
     * 
     * @return type
     */
    public function contactAction ()
    {
        $contact = new Contact();
        
         //on récupère le constructeur de formulaire ContactType
        $form = $this->createForm(new ContactType, $contact);
        
        //on récupère la requête
        $request = $this->get('request');
        
        //si on est en POST donc formulaire envoyé
        if($request->getMethod() == 'POST')
        {
            //on fait le lien Requête/Formulaire
            $form->bind($request);
            //on vérifie que les valeurs entrées sont corrects
            if($form->isValid())
            {
                //récupération des données et contruction du message
                $message = \Swift_Message::newInstance()
                ->setSubject($contact->getSujet())
                ->setFrom($contact->getMail())
                ->setTo('remy.mandit@free.fr')
                ->setBody($contact->getMessage());
                //envoi du message
                $this->get('mailer')->send($message);
        
                //on enregistre l'objet $contact dans la base
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                //on créé un message flash
                $this->get('session')->getFlashBag()->add('info','Message bien envoyé.');
                
                //redirige vers l'accueil
                return $this->redirect($this->generateUrl('index'));
            }
        }
        //A ce stade
        //Soit on est en GET donc le visisteur vient d'arriver sur la page
        //Soit on est en POST mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        //on passe la méthode creatView() du formulaire à la vue afin qu'elle
        //puisse l'afficher
        return $this->render('PortfolioRemyArticlesBundle:Articles:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Méthode pour afficher un article
     * @param integer $id
     * @return type
     * @throws exception
     */
    public function voirAction(Article $article)
    {
        //On récupère les compétences liées à l'article        
//        $liste_articleCompetence = $this->getDoctrine()
//                ->getManager()
//                ->getRepository('PortfolioRemyArticlesBundle:ArticleCompetence')
//                ->findByArticle($article->getId());
        
        //On récupère le champ nbVues et on l'incrémente
        $vues = $article->getNbVues();
        ++$vues;
        
        //on change le champ dans l'instance article
        $article->setNbVues($vues);
        
        //on enregistre les modifs dans la base
        $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
        
        //on retourne la page voir avec l'article et les compétences liées
        return $this->render('PortfolioRemyArticlesBundle:Articles:voir.html.twig', array(
            'article'=>$article));
            //'liste_articleCompetence'=>$liste_articleCompetence));
    }
    
    
    /**
     * Permet d'afficher le formulaire d'ajout d'un article
     * ou d'afficher l'article nouvellement créé
     * 
     * @return type
     * @Secure(roles="ROLE_AUTEUR")
     */
    public function ajouterAction()
    { 
        $article = new Article();
        
        
        
        //on récupère le constructeur de formulaire ArticleType
        $form = $this->createForm(new ArticleType, $article);
                
        
        //on récupère la requête
        $request = $this->get('request');
        
        //si on est en POST donc formulaire envoyé
        if($request->getMethod() == 'POST')
        {
            //on fait le lien Requête/Formulaire
            $form->bind($request);
            //on vérifie que les valeurs entrées sont corrects
            if($form->isValid())
            {
                //On initialise le champ nbVues à 0
                $article->setNbVues(0);
                // on vérifie qu'une image est associée
                if($article->getImage()!= null)
                {
                    //On envoie le chemin relatif vers l'image
                    $article->getImage()->setUploadRootDir($request->server->get('DOCUMENT_ROOT').'/../web/'.$article->getImage()->getUploadDir());
                }
                
                //on enregistre l'objet $article dans la base
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                //on créé un message flash
                $this->get('session')->getFlashBag()->add('info','Article bien enregistré');
            
                //redirige vers la page de visualisation de l'article
                return $this->redirect($this->generateUrl('portfolioremyarticles_voir',array('slug'=>$article->getSlug())));
            }
        }
        //A ce stade
        //Soit on est en GET donc le visisteur vient d'arriver sur la page
        //Soit on est en POST mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        
        //on passe la méthode creatView() du formulaire à la vue afin qu'elle
        //puisse l'afficher
        return $this->render('PortfolioRemyArticlesBundle:Articles:ajouter.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    /**
     * Afficher le formulaire de modification de l'article $id
     * 
     * @param integer $id
     * @return type
     * @throws exception
     * @Secure(roles="ROLE_AUTEUR")
     */
    public function modifierAction(Article $article)
    {
        $form = $this->createForm(new ArticleEditType(), $article);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                // on vérifie qu'une image est associée
                if($article->getImage()!= null)
                {
                    //On envoie le chemin relatif vers l'image
                    $article->getImage()->setUploadRootDir($request->server->get('DOCUMENT_ROOT').'/../web/'.$article->getImage()->getUploadDir());
                }
                
                //on enregistre l'article
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                
                //message flash
                $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');
                
                return $this->redirect($this->generateUrl('portfolioremyarticles_voir', array('slug' => $article->getSlug())));
            }
        }
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:modifier.html.twig', array(
            'form' => $form->createView(),
            'article' => $article
        ));
    }
    
    /**
     * permet d'afficher une page de confirmation de suppression de l'article
     * ou la page d'accueil après la suppression
     * 
     * @param integer $id
     * @return type
     * @throws exception
     * @Secure(roles="ROLE_ADMIN")
     */
    public function supprimerAction(Article $article)
    {
        //on crée un formulaire vide, qui ne contiendra que le champ CRSF
        $form = $this->createFormBuilder()->getForm();
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                //on supprime l'article
                $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();
                
                $this->get('session')->getFlashBag('info', 'Article nien s^pprimé');
                
                return $this->redirect($this->generateUrl('portfolioremyarticles_accueil'));
            }
        }
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:supprimer.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }
    
    /**
     * afficher une liste des derniers articles dans le menu
     * 
     * @param integer $nombre
     * @return type
     */
    public function menuAction($nombre)
    {
        $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                ->findBy(
                        array(), //pas de critère
                        array('date' => 'desc'), //tri par date décroissant
                        $nombre, // on sélectionne $nombre articles
                        0 // à partir du premier
                        );
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:menu.html.twig',
                array(
                    'liste_articles' => $liste
                ));
    }
    
    /**
     * afficher une liste de $nombre articles les plus lu
     * 
     * @param type $nombre
     * @return type
     */
    public function menuTopAction($nombre)
    {
        $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                ->findBy(
                        array(), //pas de critère
                        array('nbVues' => 'desc'), //tri par nombre vues décroissant
                        $nombre, // on sélectionne $nombre articles
                        0 // à partir du premier
                        );
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:menu.html.twig',
                array(
                    'liste_articles' => $liste
                ));
    }
    
    /**
     * afficher les articles d'une catégorie dans un menu déroulant
     * 
     * @param type $categorie
     * @return type
     */
    public function menuDeroulantAction($categorie)
    {
        $liste = $this->getDoctrine()
                ->getManager()
                ->getRepository('PortfolioRemyArticlesBundle:Article')
                ->getAvecCategories(array($categorie));
        
        return $this->render('PortfolioRemyArticlesBundle:Articles:menuDeroulant.html.twig',
                array(
                    'liste_articles' => $liste
                ));
    }
}
?>
