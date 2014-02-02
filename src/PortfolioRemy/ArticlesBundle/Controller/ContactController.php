<?php
// chemin où se trouve le contrôleur
namespace PortfolioRemy\ArticlesBundle\Controller;

// les imports
// le contrôleur hérite du contrôleur de base
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// le contrôleur utilise les objets Contact et ContactType
use PortfolioRemy\ArticlesBundle\Entity\Contact;
use PortfolioRemy\ArticlesBundle\Form\ContactType;

class ContactController extends Controller
{
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
     * Permet d'afficher le formulaire de feedback
     * ou de l'envoyer si valide et afficher
     * la page d'accueil
     * @return type
     */
    public function feedbackAction ()
    {
        $contact = new Contact();
        $contact->setSujet('Feedback');
        $contact->setMessage('Repportez un bug, une amélioration, votre avis...');
        
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
}
?>
