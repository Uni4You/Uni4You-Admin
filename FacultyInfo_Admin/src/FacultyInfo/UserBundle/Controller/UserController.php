<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('FacultyInfoUserBundle:User:index.html.twig');
    }
}
