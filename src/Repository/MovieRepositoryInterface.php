<?php

namespace App\Repository;

use App\Entity\Movie;

interface MovieRepositoryInterface
{
    function GetById(int $id): ?Movie;
}