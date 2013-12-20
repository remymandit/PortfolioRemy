<?php

namespace PortfolioRemy\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PortfolioRemy\ArticlesBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    /**
     *
     * @var File
     * 
     * @Assert\File(
     * maxSize="2M",
     * mimeTypes={"image/jpeg","image/gif","image/png","image/tiff"},
     * maxSizeMessage="The maximum allowed file size is 2MB.",
     * mimeTypesMessage="Only the filetypes image are allowed."
     * )
     */
    private $file;
    
    private $tempFilename;


    /**
     * Get file
     * 
     * @return type
     */
    public function getFile()
    {
        return $this->file;
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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * Set file
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        
        //on vérifie si on avait déjà un fichier pour cette entité
        if(null !== $this->url)
        {
            //on sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->tempFilename = $this->url;
            
            //on réinitialise les valeurs des attributs url et alt
            $this->url = null;
            $this->alt = null;
        }
    }
    
    
    /**
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        //si jamais il n'y a pas de fichier (champ facultatif)
        if(null === $this->file)
        {
            return;
        }
        
        //le nom du fichier est son id, on stocke son extension
        $this->url = $this->file->guessExtension();
        
        //on génère l'attribut alt de la balise <img> à la valeur du nom du fichier
        $this->alt = $this->file->getClientOriginalName();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * @return type
     */
    public function upload()
    {
        //s'il n'y a aps de fichier (champ facultatif)
        if(null === $this->file)
        {
            return;
        }
        
        //on déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move(
                $this->getUploadRootDir(),//le répertoire de destination
                $this->id.'.'.$this->url);//le nom du fichier à créer, ici "id.extension"
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        //on sauvegarde temporairement le nom de fichier, car il dépend lde l'id
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        //en postRemove on n'a pas accès à l'id, on utilise notre nom sauvegardé
        if(file_exists($this->tempFilename))
        {
            //on supprime le fichier
            unlink($this->tempFilename);
        }
    }


    /**
     * renvoie le chemin relatif vers l'image pour un navigateur
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/img';
    }
    
    /**
     * renvoie le chemin relatif vers l'image pour notre code PHP
     * @return type
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    /**
     * renvoie le chemin de l'image pour la vue
     * @return string
     */
    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}