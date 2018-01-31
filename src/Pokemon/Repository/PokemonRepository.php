<?php

namespace App\Pokemon\Repository;

use App\Pokemon\Entity\Pokemon;
use Doctrine\DBAL\Connection;


/**
 * Pokemon repository.
 */
class PokemonRepository
{

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getUsersPokemon($tokenFacebook)
    {
        $baseUrl = "http://pokeapi.co/api/v2/pokemon/";
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('UsersPokemon', 'u')
            ->where('tokenFB = ?')
            ->setParameter(0, $tokenFacebook);
        $statement = $queryBuilder->execute();
        $usersPokemon = $statement->fetchAll();
        $urls = array();
        foreach ($usersPokemon as $userPokemon) {
            array_push($urls, $baseUrl .strval($userPokemon['pokemonId']));
        }

        return $urls;
    }
}
