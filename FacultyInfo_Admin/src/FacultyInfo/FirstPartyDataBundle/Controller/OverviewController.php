<?php

namespace FacultyInfo\FirstPartyDataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller
{
    public function indexAction()
    {
        return $this->render('FacultyInfoFirstPartyDataBundle:Overview:index.html.twig');
    }
}
