<?php

$app->get('/pokemon/list', 'App\Pokemon\Controller\IndexController::listAction')->bind('pokemon.list');
$app->get('/pokemon/edit/{id}', 'App\Pokemon\Controller\IndexController::editAction')->bind('pokemon.edit');
$app->get('/pokemon/new', 'App\Pokemon\Controller\IndexController::newAction')->bind('pokemon.new');
$app->post('/pokemon/delete/{id}', 'App\Pokemon\Controller\IndexController::deleteAction')->bind('pokemon.delete');
$app->post('/pokemon/save', 'App\Pokemon\Controller\IndexController::saveAction')->bind('pokemon.save');
