<?php

namespace App\Entity;

use App\ValueObject\Gender;

class Character
{
    function __construct(
        readonly ?int $id=null,
        readonly string $name,
        readonly int $mass,
        readonly Gender $gender,
        readonly string $picture // at that point picture should be just a link to a cdn
    ){
    }
}