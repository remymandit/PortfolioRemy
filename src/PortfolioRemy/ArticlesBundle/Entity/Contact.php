<?php

namespace PortfolioRemy\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PortfolioRemy\ArticlesBundle\Entity\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Assert\Callback(methods={"contenuValide"})
 */
class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\Email(
     * checkMX = true,
     * checkHost = true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank()
     */
    private $message;
    
    /**
     * constructeur par défaut
     * date du jour par défaut
     */
    public function __construct()
    {
        $this->date = new \Datetime();
        
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Contact
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Contact
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Contact
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    
        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Contact
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;
    
        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * méthode pour vérifier le contenu du sujet et du message
     * avec des mots interdits
     * @param \Symfony\Component\Validator\ExecutionContextInterface $context
     */
    public function contenuValide(ExecutionContextInterface $context)
    {
        //liste des mots interdits
        $mots_interdits = array('sexe', 'éjaculation');
        //comparaison du contenu avec les mots interdits
        if(preg_match('#'.implode('|', $mots_interdits).'#', $this->getMessage()))
        {
            //la règle est violée
            //1er argument : l'argument concerné, ici "message"
            //2ème argument : le message d'erreur
            $context->addViolationAt('message', 'Message invalide car il contient un mot interdit.', array(),null);
        }
        //comparaison du titre avec les mots interdits
        if(preg_match('#'.implode('|', $mots_interdits).'#', $this->getSujet()))
        {
            //la règle est violée
            //1er argument : l'argument concerné, ici "sujet"
            //2ème argument : le message d'erreur
            $context->addViolationAt('sujet', 'Sujet invalide car il contient un mot interdit.', array(),null);
        }
    }
}
