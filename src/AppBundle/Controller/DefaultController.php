<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:default:index.html.twig');
    }

    /**
     * @Route("/random/{start}/{end}", name="random")
     */
    public function randomAction(Request $request, $start, $end)
    {
        $number = rand($start, $end); // две цифры, чтобы ab не жаловался на разную длину реквестов
        return $this->render('AppBundle:default:random.html.twig', [
            'random_number' => $number,
        ]);
    }
}
