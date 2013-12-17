<?php

namespace PortfolioRemy\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PortfolioRemy\ArticlesBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Assert\Callback(methods={"contenuValide"})
 * @UniqueEntity(fields="titre", message="Un article existe déjà avec ce titre.")
 */
class Article
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
     *
     * @ORM\ManyToMany(targetEntity="PortfolioRemy\ArticlesBundle\Entity\Categorie", cascade={"persist"})
     */
    private $categories;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="PortfolioRemy\ArticlesBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\OneToOne(targetEntity="PortfolioRemy\ArticlesBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $image;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="PortfolioRemy\ArticlesBundle\Entity\Commentaire", mappedBy="article")
     */
    private $commentaires;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;
    
    /**
     *
     * @var \DateTime
     * @ORM\Column(name="dateedition", type="datetime", nullable=true)
     */
    private $dateEdition;    
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="nbcommentaires", type="integer", nullable=true)
     */
    private $nbCommentaires;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="nbvues", type="integer", nullable=true)
     */
    private $nbVues;
    
    /**
     * @var string $titre
     *
     * @ORM\Column(name="titre", type="string", length=255, unique=true)
     * @Assert\Length(
     * min="10",
     * minMessage="Le titre doit faire au moins {{ limit }} caractères")
     */
    private $titre;

    /**
     * @var text
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank()
     */
    private $contenu;
    
    /**
     *
     * @var string
     * 
     * @ORM\Column(name="resume", type="string", length=255)
     * @Assert\Length(
     * min="100",
     * max="125",
     * minMessage="Le résumé doit contenir au minimum {{ limit }} caractères",
     * maxMessage="Le résumé doit contenir au maximum {{ limit }} caractères")
     */
    private $resume;
    
    /**
     *@var boolean
     * 
     * @ORM\Column(name="publication", type="boolean") 
     */
    private $publication;
    
    /**
     * @var type
     * 
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;
    
    /**
     * Constructeur par défaut
     * date du jour par défaut
     * publication à true par défaut
     */
    public function __construct()
    {
        $this->date = new \Datetime();
        $this->publication = true;
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags= new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
    }

     /**
     * définit $dateEdition à la date actuelle
     * 
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setDateEdition(new \Datetime());
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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
     */
    public function setDate(\Datetime $date)
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
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }
    

    /**
     * Set contenu
     *
     * @param text $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return text
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    
        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set image
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\PortfolioRemy\ArticlesBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \PortfolioRemy\ArticlesBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
    
    
    /**
     * Add categorie
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Categorie $categorie
     * @return Article
     */
    public function addCategorie(\PortfolioRemy\ArticlesBundle\Entity\Categorie $categorie)
    {
        $this->categories[] = $categorie;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Categorie $categorie
     */
    public function removeCategorie(\PortfolioRemy\ArticlesBundle\Entity\Categorie $categorie)
    {
        $this->categories->removeElement($categorie);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * Add tag
     * @param \PortfolioRemy\ArticlesBundle\Entity\Tag $tag
     * @return \PortfolioRemy\ArticlesBundle\Entity\Article
     */
    public function addTag(\PortfolioRemy\ArticlesBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }
    
    /**
     * Remove tags
     * @param \PortfolioRemy\ArticlesBundle\Entity\Tag $tag
     */
    public function removeTag(\PortfolioRemy\ArticlesBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }
    
    /**
     * Get tags
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set dateEdition
     *
     * @param \DateTime $dateEdition
     * @return Article
     */
    public function setDateEdition(\Datetime $dateEdition)
    {
        $this->dateEdition = $dateEdition;
    
        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return \DateTime 
     */
    public function getDateEdition()
    {
        return $this->dateEdition;
    }
    
   

    /**
     * Set nbCommentaires
     *
     * @param integer $nbCommentaires
     * @return Article
     */
    public function setNbCommentaires($nbCommentaires)
    {
        $this->nbCommentaires = $nbCommentaires;
    
        return $this;
    }

    /**
     * Get nbCommentaires
     *
     * @return integer 
     */
    public function getNbCommentaires()
    {
        return $this->nbCommentaires;
    }
    
    

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add commentaires
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Commentaire $commentaire
     * @return Article
     */
    public function addCommentaire(\PortfolioRemy\ArticlesBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;
    
        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\PortfolioRemy\ArticlesBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
    
    /**
     * méthode vérifiant le contenu et le titre
     * avec des mots interdits
     * @param \Symfony\Component\Validator\ExecutionContextInterface $context
     */
    public function contenuValide(ExecutionContextInterface $context)
    {
        //liste des mots interdits
        $mots_interdits = array('sexe', 'éjaculation');
        //comparaison du contenu avec les mots interdits
        if(preg_match('#'.implode('|', $mots_interdits).'#', $this->getContenu()))
        {
            //la règle est violée
            //1er argument : l'argument concerné, ici "contenu"
            //2ème argument : le message d'erreur
            $context->addViolationAt('contenu', 'Contenu invalide car il contient un mot interdit.', array(),null);
        }
        //comparaison du titre avec les mots interdits
        if(preg_match('#'.implode('|', $mots_interdits).'#', $this->getTitre()))
        {
            //la règle est violée
            //1er argument : l'argument concerné, ici "titre"
            //2ème argument : le message d'erreur
            $context->addViolationAt('titre', 'Titre invalide car il contient un mot interdit.', array(),null);
        }
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Article
     */
    public function setResume($resume)
    {
        $this->resume = $resume;
    
        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set nbVues
     *
     * @param integer $nbVues
     * @return Article
     */
    public function setNbVues($nbVues)
    {
        $this->nbVues = $nbVues;
    
        return $this;
    }

    /**
     * Get nbVues
     *
     * @return integer 
     */
    public function getNbVues()
    {
        return $this->nbVues;
    }
}