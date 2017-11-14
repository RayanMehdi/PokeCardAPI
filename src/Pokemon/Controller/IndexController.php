<?php

namespace App\Pokemon\Controller;

use App\Pokemon\Entity\Pokemon;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;


class IndexController
{
    public function listAction(Request $request, Application $app)
    {

      $pok = new Pokemon("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png", "bulbizarre", 50, 50, 50, 50, 50, 50);
      $pok2= new Pokemon("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/6.png", "dracofeu", 100, 150, 500, 555, 785, 44);
      $pok3= new Pokemon("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/33.png", "nidorino", 66, 48, 20, 45, 77, 88);
      $pok4= new Pokemon("https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/125.png", "elektek", 77, 56, 778, 456, 26, 560);
      $content =json_encode(array(json_decode($pok->toJson(), true),json_decode($pok2->toJson(), true),json_decode($pok3->toJson(),true),json_decode($pok4->toJson(),true)));
      return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));

    }

}
