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
     * @Route("/random/{start}/{end}/{native}", name="random")
     */
    public function randomAction(Request $request, $start, $end, $native)
    {
        $number = rand($start, $end); // две цифры, чтобы ab не жаловался на разную длину реквестов

        if ($native) {
            $c = pg_connect("host=192.168.1.103 port=6432 dbname=bench user=tmp", PGSQL_CONNECT_FORCE_NEW);
            $res = pg_query($c, "SELECT * from bench_data WHERE number = $number");
            while ($row = pg_fetch_row($res)) {
                $record = $row;
            }
        } else {
            $record = $this->getDoctrine()->getRepository('AppBundle:BenchData')->findOneByNumber($number);
        }

        return $this->render('AppBundle:default:random.html.twig', [
            'random_number' => $number,
            'memory_usage' => memory_get_usage(),
            'native' => $native,
            'record' => $record,
        ]);
    }

    /**
     * @Route("/fill/{id_from}/{id_to}", name="fill")
     */
    public function fillAction(Request $request, $id_from, $id_to)
    {
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getManager();

        $queryBuilder = $em->createQueryBuilder();
        $queryBuilder->delete('AppBundle:BenchData');
        $queryBuilder->getQuery()->execute();

        for ($i = $id_from; $i <= $id_to; $i++) {
            $record = new BenchData();
            $record->setName(md5(microtime() + rand(0, 4096)));
            $record->setNumber($i);
            $em->persist($record);
        }
        $em->flush();
        return $this->render('AppBundle:default:fill.html.twig', [
            'total' => $id_to - $id_from,
        ]);
    }
}
