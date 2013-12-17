<?php

namespace PortfolioRemy\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PortfolioRemyUserBundle extends Bundle
{
    /**
     * héritage du bundle FOSUser
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
