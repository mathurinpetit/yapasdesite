<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

  /**
    * @Route("/")
    */
    public function index(): Response
    {
        $number = random_int(0, 100);

        return $this->render('default/index.html.twig', [
            'number' => $number,
        ]);
    }

    /**
      * @Route("/statue/{name}")
      */
      public function statue($name): Response
      {
        $statuesFile = file('statues.csv');
        $statue = null;
        foreach ($statuesFile as $line_num => $row) {
          $c = str_getcsv($row,';');
          if(substr($row,0,1) !== '#' && $c[0] == $name){
            $statue = $c;
          }
        }

          return $this->render('default/statue.html.twig', array('statue' => $statue));
      }
}
