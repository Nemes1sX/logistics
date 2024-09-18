<?php

namespace App\DTO;

class UserDTO
{
    public string $id;
    public string $name;

    public function __construct($user)
    {
        $this->id = $user->getId();
        $this->name = $user->getName();
    }
}