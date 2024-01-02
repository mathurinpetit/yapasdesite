<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Game
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @var uuid
     *
     * @ORM\Column(name="id", type="string", length=36, unique=true)
     * @ORM\Id
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=4096)
     */
    private $nameOfMovie;

   /**
    * @ORM\Column(type="string", length=4096)
    */
    private $directorOfMovie;

   /**
    * @ORM\Column(type="string", length=100)
    */
    private $yearOfMovie;


    /**
     * Constructor
     */
    public function __construct()
    {
      $this->id = Uuid::v4()->__toString();
    }

    /**
     * Get id
     *
     * @return uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get nameOfMovie
     *
     * @return string
     */
    public function getNameOfMovie()
    {
        return $this->nameOfMovie;
    }

    /**
     * Set nameOfMovie
     *
     * @param string $nameOfMovie
     *
     * @return Movie
     */
    public function setNameOfMovie($name)
    {
        $this->nameOfMovie = $name;

        return $this;
    }

    /**
     * Get directorOfMovie
     *
     * @return string
     */
    public function getDirectorOfMovie()
    {
        return $this->directorOfMovie;
    }

    /**
     * Set directorOfMovie
     *
     * @param string $directorOfMovie
     *
     * @return Movie
     */
    public function setDirectorOfMovie($directorOfMovie)
    {
        $this->directorOfMovie = $directorOfMovie;

        return $this;
    }

    /**
     * Get yearOfMovie
     *
     * @return string
     */
    public function getYearOfMovie()
    {
        return $this->yearOfMovie;
    }

    /**
     * Set yearOfMovie
     *
     * @param string $yearOfMovie
     *
     * @return Movie
     */
    public function setYearOfMovie($yearOfMovie)
    {
        $this->yearOfMovie = $yearOfMovie;

        return $this;
    }

}
