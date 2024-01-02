<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

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
        ini_set('post_max_size','3000M');
        if ($request->isMethod('POST')) {

           $file = $request->files->get('file');
           $name = $file->getClientOriginalName();
           $dir = __DIR__.'/../../data';
           (new Filesystem)->remove($dir."/*");
           $file->move($dir, $name) ;
          }
          return $this->render('admin/index.html.twig');
      }
}
