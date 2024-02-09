<?php

namespace App\Importer;

interface ImporterInterface
{
    function ImportCharacters(int $maxCharacterAmount): array;
    function ImportMovies(): array;
}