<?php

namespace Braindigit\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BraindigitUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
