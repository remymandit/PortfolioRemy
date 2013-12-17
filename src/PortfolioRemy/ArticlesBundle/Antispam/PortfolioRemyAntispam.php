<?php

namespace PortfolioRemy\ArticlesBundle\Antispam;
/**
 * service antispam
 */
class PortfolioRemyAntispam
{
    /**
     * vérifie si le texte est un spam ou non
     * un text est considéré comme spam à partir de
     * 3 liens ou adresses e-mail dans son contenu
     * 
     * @param string $text
     * @return boolean
     */
    public function isSpam($text)
    {
        return ($this->countLinks($text) + $this->countMails($text)) >= 3;
    }
    
    /**
     * compte les URL de $text
     * 
     * @param tring $text
     * @return int
     */
    private function countLinks($text)
    {
        preg_match_all(
                '#(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?#i',
                $text,
                $matches
                );
        return count($matches[0]);
    }
    
    /**
     * Compte les e-mails de $text
     * 
     * @param string $text
     * @return int
     */
    private function countMails($text)
    {
        preg_match_all(
                '#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#i',
                $text,
                $matches
                );
        return count($matches[0]);
    }
}

?>
