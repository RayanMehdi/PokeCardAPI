<?php

namespace App\Users\Entity;

class User
{
    protected $id;

    protected $tokenFacebook;

    public function __construct($id, $tokenFacebook)
    {
        $this->id = $id;
        $this->tokenFacebook = $tokenFacebook;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTokenFacebook($tokenFacebook)
    {
        $this->tokenFacebook = $tokenFacebook;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTokenFacebook()
    {
        return $this->tokenFacebook;
    }


    public function toArray()
    {
        $array = array();
        $array['id'] = $this->id;
        $array['token'] = $this->tokenFacebook;
        return $array;
    }

    public    function toJson(){
        return json_encode( array(
            'id' => $this->id,
            'tokenFacebook' => $this->tokenFacebook));
    }
}