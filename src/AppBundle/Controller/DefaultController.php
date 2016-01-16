<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $number = rand(10, 99); // две цифры, чтобы ab не жаловался на разную длину реквестов
        return $this->render('AppBundle:default:index.html.twig', [
            'random_number' => $number,
        ]);
    }
}
