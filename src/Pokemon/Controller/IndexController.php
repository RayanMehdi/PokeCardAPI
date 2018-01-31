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

    /**
     * @param $pokemon
     * @return array
     *
     * Function for transform array of data pokemon to simple array pokemon
     *
     */
    public function pokemonToArray($pokemon)
    {
        $stats = array();

        foreach($pokemon['stats'] as $stat)
        {
            $stats[] = $stat['base_stat'];
        }
        return array(
            'icon' => $pokemon['sprites']["front_default"],
            'name' => $pokemon['name'],
            'pv' =>   $stats[0],
            'att' =>  $stats[1],
            'def' => $stats[2],
            'spA' => $stats[3],
            'spD' => $stats[4],
            'spe' => $stats[5]);
    }

    public function getPokemonsAction(Request $request, Application $app)
    {
      $parameters = $request->attributes->all();
      $pokemons = array();
      $urls_pokemon = array();

      $client = new Client();
      $url = 'https://pokeapi.co/api/v2/pokemon/?limit=20&offset='.$parameters['offset'];
      $res = $client->request('GET', $url);
      //echo $res->getStatusCode();// return 200 if correct
      $contents = $res->getBody()->getContents(); // return the json
      $obj = json_decode($contents); // transform into object
      if($obj->next == null){
          $urlNext = 'http://pokecardapi.local/index.php/pokemon/getPokemons/'.$parameters['offset'];
      }else {
          $urlNext = 'http://pokecardapi.local/index.php/pokemon/getPokemons/' . strval((intval($parameters['offset']) + 20));
      }
        if($obj->previous == null){
            $urlPrevious = 'http://pokecardapi.local/index.php/pokemon/getPokemons/'.$parameters['offset'];
        }else {
            $urlPrevious = 'http://pokecardapi.local/index.php/pokemon/getPokemons/' . strval((intval($parameters['offset']) - 20));
        }

      foreach ($obj->results as $pokemon) {
          array_push($urls_pokemon, $pokemon->url);
      }


      foreach ($urls_pokemon as $url) {
        $res = $client->request('GET', $url);
        $contents = $res->getBody()->getContents(); // return the json
        $pokemon = json_decode($contents);

        $temp = new Pokemon(
          $pokemon->id,
          $pokemon->sprites->front_default,
          $pokemon->name,
          $pokemon->stats[5]->base_stat,
          $pokemon->stats[4]->base_stat,
          $pokemon->stats[3]->base_stat,
          $pokemon->stats[2]->base_stat,
          $pokemon->stats[1]->base_stat,
          $pokemon->stats[0]->base_stat

        );
        array_push($pokemons, json_decode( $temp->toJson(),true));
      }


      $content =json_encode(array($pokemons, 'next' => $urlNext, 'previous' => $urlPrevious));
      return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));

    }

    public function getPokemonAction(Request $request, Application $application, $id)
    {
        $client = new Client();

        $pokemonId = $id;

        $res = $client->request('GET', 'http://pokeapi.co/api/v2/pokemon/'.$pokemonId);

        $pokemon =  json_decode($res->getBody(), true);

        $content = $this->pokemonToArray($pokemon);

        $json = json_encode($content);

        return new Response($json, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

    public function getUsersPokemon(Request $request, Application $app)
    {

        $client = new Client();
        $parameters = $request->attributes->all();
        $pokemons = array();
        $urls_pokemon = $app['repository.pokemon']->getUsersPokemon($parameters['tokenFB']);
        //var_dump($urls_pokemon);die;
        foreach ($urls_pokemon as $url) {
            //var_dump($url);die;
            $res = $client->request('GET', $url);
          //  var_dump($res);die;
            $contents = $res->getBody()->getContents(); // return the json
           // var_dump($contents);die;
            $pokemon = json_decode($contents);
           // var_dump($pokemon);die;
           // var_dump($this->pokemonToArray(json_decode($pokemon)));die;

            $temp = new Pokemon(
                $pokemon->id,
                $pokemon->sprites->front_default,
                $pokemon->name,
                $pokemon->stats[5]->base_stat,
                $pokemon->stats[4]->base_stat,
                $pokemon->stats[3]->base_stat,
                $pokemon->stats[2]->base_stat,
                $pokemon->stats[1]->base_stat,
                $pokemon->stats[0]->base_stat

            );
           // var_dump($temp);die;

            array_push($pokemons, json_decode( $temp->toJson(),true));
        }


        $content =json_encode($pokemons);
        return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));
    }

   /* public function getPokemonsAction(Request $request, Application $app)
    {
        $pokemons = array();
        $urls_pokemon = array();



        $client = new Client();
        $url = 'https://pokeapi.co/api/v2/pokemon/?limit=20&offset=0';
        $res = $client->request('GET', $url);
        //echo $res->getStatusCode();// return 200 if correct
        $contents = $res->getBody()->getContents(); // return the json
        $obj = json_decode($contents); // transform into object
        $urlNext = $obj->next;  //example return value of attribute ‘count’
        $urlPrevious = $obj->previous;

        foreach ($obj->results as $pokemon) {
            array_push($urls_pokemon, $pokemon->url);
        }


        foreach ($urls_pokemon as $url) {
            $res = $client->request('GET', $url);
            $contents = $res->getBody()->getContents(); // return the json
            $pokemon = json_decode($contents);

            $temp = new Pokemon(
                $pokemon->id,
                $pokemon->sprites->front_default,
                $pokemon->name,
                $pokemon->stats[5]->base_stat,
                $pokemon->stats[4]->base_stat,
                $pokemon->stats[3]->base_stat,
                $pokemon->stats[2]->base_stat,
                $pokemon->stats[1]->base_stat,
                $pokemon->stats[0]->base_stat

            );
            array_push($pokemons, json_decode($temp->toJson(),true));
        }


        $content =json_encode(array($pokemons, 'next' => $urlNext, 'previous' => $urlPrevious));
        return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));

    }*/

    public function getNextPageAction(Request $request, Application $app)
    {

      $client = new Client();
      echo $this->nextURl;
      $res = $client->request('GET', $this->nextURl);

      echo $res->getStatusCode();// return 200 if correct
      $contents = $res->getBody()->getContents(); // return the json
      $obj = json_decode($contents); // transform into object
      if ($obj->next == 'null') {
        $this->nextURl = 'https://pokeapi.co/api/v2/pokemon';
      }else {
        $this->nextURl = $obj->next;
      }

      echo $obj->count;  //example return value of attribute ‘count’
      $content =json_encode($obj, true);
      return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));

    }

    public function getPreviousPageAction(Request $request, Application $app)
    {

      $client = new Client();
      $res = $client->request('GET', $this->previousURL);

      echo $res->getStatusCode();// return 200 if correct
      $contents = $res->getBody()->getContents(); // return the json
      $obj = json_decode($contents); // transform into object
      if ($obj->previous == NULL) {
        $this->previousURL = 'https://pokeapi.co/api/v2/pokemon';
      }else {
        $this->previousURL = $obj->previous;
      }
      echo $obj->count;  //example return value of attribute ‘count’
      $content =json_encode($obj, true);
      return new Response($content, Response::HTTP_OK, array('content-type' => 'application/json'));

    }
}
