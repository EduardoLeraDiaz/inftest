<?php

namespace App\Repository;

use App\Entity\Character;

interface CharacterRepositoryInterface
{
    /**
     * @return array<Character>
     */
    function getCharacters(): array;

    /**
     * It is an array because the idea is there is Han Solo and Han Duke you can search thought Han and retrieve both
     * @return array<Character>
     */
    function getCharactersByName(string $name): array;
}