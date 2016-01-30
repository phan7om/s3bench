<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BenchData;
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
            'memory_usage' => memory_get_usage(),
        ]);
    }

    /**
     * @Route("/fill/{id_from}/{id_to}", name="fill")
     */
    public function fillAction(Request $request, $id_from, $id_to)
    {
        for ($i = $id_from; $i <= $id_to; $i++) {
            $record = new BenchData();
            $record->setName(md5(microtime() + rand(0, 4096)));
        }
        return $this->render('AppBundle:default:fill.html.twig', [
            'total' => $id_to - $id_from,
        ]);
    }
}
