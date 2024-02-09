<?php

namespace App\Command;


use App\Importer\ImporterInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'starwars:import',
    description: 'Import from api',
    hidden: false,
)]
class ImportCharactersCommand extends Command
{
    public function __construct(
        private ImporterInterface $importer,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $characters = $this->importer->ImportCharacters(30);

        return 0;

    }
}