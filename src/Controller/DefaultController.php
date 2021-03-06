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
      * @Route("/qrcode")
      */
      public function qrcode(): Response
      {

          return $this->render('default/qrcode.html.twig');
      }
}
