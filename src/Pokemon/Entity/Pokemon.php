<?php

namespace App\Pokemon\Entity;

class Pokemon
{
  protected $icon;
  protected $name;
  protected $pv;
  protected $att;
  protected $def;
  protected $spA;
  protected $spD;
  protected $spe;


  public  function __construct($icon, $name, $pv, $att, $def, $spA, $spD, $spe){
    $this->icon = $icon;
    $this->name = $name;
    $this->att = $att;
    $this->def = $def;
    $this->spA = $spA;
    $this->pv = $pv;
    $this->spD = $spD;
    $this->spe = $spe;
  }

  public    function toJson(){
    return json_encode( array(
        'icon' => $this->icon,
        'name' => $this->name,
        'pv' => $this->pv,
        'att' => $this->att,
        'def' => $this->def,
        'spA' => $this->spA,
        'spD' => $this->spD,
        'spe' => $this->spe));
  }

}
