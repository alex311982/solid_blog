<?php

namespace Solid\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SolidBlogBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
