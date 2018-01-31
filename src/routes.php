<?php

$app->get('/pokemon/list', 'App\Pokemon\Controller\IndexController::listAction')->bind('pokemon.list');
$app->get('/pokemon/getPokemons/{offset}/', 'App\Pokemon\Controller\IndexController::getPokemonsAction')->bind('pokemon.getPokemons');
$app->get('/pokemon/get/{id}', 'App\Pokemon\Controller\IndexController::getPokemonAction')->bind('pokemon.getPokemon');
$app->get('/pokemon/getPrevious', 'App\Pokemon\Controller\IndexController::getPreviousPageAction')->bind('pokemon.getPrevious');
$app->get('/pokemon/getNext', 'App\Pokemon\Controller\IndexController::getNextPageAction')->bind('pokemon.getNext');
$app->get('/pokemon/edit/{id}', 'App\Pokemon\Controller\IndexController::editAction')->bind('pokemon.edit');
$app->get('/pokemon/new', 'App\Pokemon\Controller\IndexController::newAction')->bind('pokemon.new');
$app->post('/pokemon/delete/{id}', 'App\Pokemon\Controller\IndexController::deleteAction')->bind('pokemon.delete');
$app->post('/pokemon/save', 'App\Pokemon\Controller\IndexController::saveAction')->bind('pokemon.save');


$app->get('/pokemon/getUserPokemons/{tokenFB}', 'App\Pokemon\Controller\IndexController::getUsersPokemon')->bind('pokemon.getUsersPokemon');