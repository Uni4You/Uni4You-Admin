<?php

namespace FacultyInfo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller
{
    public function indexAction()
    {
        return $this->render('FacultyInfoUserBundle:Overview:index.html.twig');
    }
}
