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

        if ($request->isMethod('POST')) {
           $nameOfMovie = trim($request->request->get('nameOfMovie'));
           $directorOfMovie = trim($request->request->get('directorOfMovie'));
           $yearOfMovie = trim($request->request->get('yearOfMovie'));
           if($nameOfMovie && $directorOfMovie && $yearOfMovie){
             $file = $request->files->get('file');
             $name = $file->getClientOriginalName();
             $nameOfMovieFile = $stripped = str_replace(' ', '',  $nameOfMovie);
             $dir = __DIR__.'/../../data';
             (new Filesystem)->remove($dir."/*");
             $file->move($dir, $nameOfMovieFile);
             return $this->json(['upload' => 'done']);
             }
          }
          return $this->render('admin/index.html.twig');
      }

        /**
        * @Route("/admin/create-files/{nameOfMovie}/{directorOfMovie}/{yearOfMovie}")
        */
        public function createFiles(Request $request,$nameOfMovie = "", $directorOfMovie = "",$yearOfMovie = ""): Response
        {

            return $this->render('admin/traitement.html.twig',["nameOfMovie" => $nameOfMovie]);
        }
}
