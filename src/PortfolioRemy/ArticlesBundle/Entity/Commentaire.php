<?php

namespace PortfolioRemy\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PortfolioRemy\ArticlesBundle\Entity\CommentaireRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Commentaire
{
    /**
     *
     * @ORM\ManyToOne(targetEntity="PortfolioRemy\ArticlesBundle\Entity\Article", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;


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
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var text
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

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
     * Set auteur
     *
     * @param string $auteur
     * @return Commentaire
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set contenu
     *
     * @param text $contenu
     * @return Commentaire
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
     * Set date
     *
     * @param \DateTime $date
     * @return Commentaire
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
     * Set article
     *
     * @param \PortfolioRemy\ArticlesBundle\Entity\Article $article
     * @return Commentaire
     */
    public function setArticle(\PortfolioRemy\ArticlesBundle\Entity\Article $article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return \PortfolioRemy\ArticlesBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
    
    /**
     * incrémente de 1 $nbCommentaires
     * @ORM\PrePersist
     */
    public function increase()
    {
        $nbCommentaires = $this->getArticle()->getNbCommentaires();
        $this->getArticle()->setNbCommentaires($nbCommentaires + 1);
    }
    
    /**
     * décrémente de 1 $nbCommentaires
     * @ORM\PreRemove
     */
    public function decrease()
    {
        $nbCommentaires = $this->getArticle()->getNbCommentaires();
        $this->getArticle()->setNbCommentaires($nbCommentaires - 1);
    }
}