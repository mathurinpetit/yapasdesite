<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Movie;
use App\Repository\MovieRepository;

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
             $nameOfMovieFile = str_replace(' ', '',  $nameOfMovie).'.mp4';
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
        public function createFiles(Request $request,EntityManagerInterface $entityManager, $nameOfMovie = "", $directorOfMovie = "",$yearOfMovie = ""): Response
        {

            $movie =  $entityManager->getRepository(Movie::class)->findOneByNameOfMovie($nameOfMovie);
            if ($request->isMethod('POST') && !$movie) {

              $movie = new Movie();
              $movie->setNameOfMovie($nameOfMovie);
              $movie->setDirectorOfMovie($directorOfMovie);
              $movie->setYearOfMovie($yearOfMovie);

              $em = $this->getDoctrine()->getManager();
              $em->persist($movie);
              $em->flush();

              $pathTo1movie30secondsScript = "./bin/onemovie30seconds.py";
              $nameOfMovieWithoutSpaces = str_replace(" ", "", $nameOfMovie);
              $nameOfMovieFilePath = './data/'.$nameOfMovieWithoutSpaces.'.mp4';
              $python="/usr/bin/python3";
              $commandForCron = "cd ..; ".$python." ".$pathTo1movie30secondsScript.' "'.$nameOfMovieFilePath.'" "'.$nameOfMovie.'" "'.$directorOfMovie.'" "'.$yearOfMovie.'" 2>&1 > ./logs/log.txt';
              file_put_contents('../data/CRON', $commandForCron);
              
            }
            return $this->render('admin/traitement.html.twig',["nameOfMovie" => $nameOfMovie,"directorOfMovie" => $directorOfMovie,"yearOfMovie" => $yearOfMovie]);
        }
}
