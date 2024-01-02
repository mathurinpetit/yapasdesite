<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

  /**
    * @Route("/admin")
    */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
      * @Route("/admin/upload")
      */
      public function upload(Request $request): Response
      {
        if ($request->isMethod('POST')) {

           $file = $request->files->get('file');
           $name = $file->getClientOriginalName();
           $dir = __DIR__.'/../../data';
           $file->move($dir, $name) ;
          }
          return $this->render('admin/index.html.twig');
      }
}
