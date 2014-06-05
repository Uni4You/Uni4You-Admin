<?php

namespace FacultyInfo\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('FacultyInfoDashboardBundle:Dashboard:index.html.twig');
    }
}
