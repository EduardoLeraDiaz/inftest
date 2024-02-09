<?php

namespace App\Importer;

use App\Entity\Character;
use mysql_xdevapi\Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * I would recommend the use rmasters/swapi:~1.0
 * but that last version of symfony don't allow it thought a problem
 * with the version of psr/log
 */
class SwapiImporter implements ImporterInterface
{
    private const HTTP_ADDRESS = "https://swapi.dev/api/people/?format=json&page="; // Better in a config thant in a constant
    private const MAX_PAGE = 100;
    private const RESPONSE_NEXT_PAGE="next";
    private const RESPONSE_OBJECTS="results";
    function __construct(
        private HttpClientInterface $httpClient
    )
    {

    }

    /**
     * @param int $maxCharacterAmount
     * @return array<Character>
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    function ImportCharacters(?int $minCharactersAmount=null, int $maxCharacterAmount=0): array
    {
        $characters=[];
        $page=0;

        do {
            $page++;
            $response = $this->ImportCharacterPage($page);
            $data = $response->toArray();
            $characters = array_merge($characters, $data[self::RESPONSE_OBJECTS]);
            if (count($characters) < $minCharactersAmount && !empty($data[self::RESPONSE_NEXT_PAGE])) {
                continue;
            }
            if (count($characters) > $maxCharacterAmount) {
                $characters = array_slice($characters, 0, $maxCharacterAmount);
                break;
            }
            if (empty($data[self::RESPONSE_NEXT_PAGE])) {
                break;
            }

        }while($page < self::MAX_PAGE && $minCharactersAmount < count($characters));
        // transform the data
        $c = [];
        foreach ($characters as $rawCharacter) {
               $c[] = New Character(
                   null,
                   $rawCharacter["name"],
                   0,
                   "",
                   "",

               );
        }

        return $c;
    }

    private function ImportCharacterPage(int $page): ResponseInterface
    {
        return $this->httpClient->request(
            request::METHOD_GET,
            self::HTTP_ADDRESS.$page // of course not the propper way, use methods to calculate the url
        );
    }

    function ImportMovies(): array
    {
        return [];
    }
}