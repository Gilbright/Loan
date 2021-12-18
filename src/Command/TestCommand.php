<?php

namespace App\Command;

use App\Repository\ClientRepository;
use App\Repository\ProjectMasterRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'testCommand';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /** @var ClientRepository */
    private $clientRepository;

    /** @var ProjectMasterRepository */
    private $projectMasterRepository;

    public function __construct(ClientRepository $clientRepository, ProjectMasterRepository  $projectMasterRepository, string $name = null)
    {
        $this->clientRepository = $clientRepository;
        $this->projectMasterRepository = $projectMasterRepository;
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $client = $this->clientRepository->find(1);

        $projectMaster = $this->projectMasterRepository->find(1);

        //dd($client, $projectMaster);
        //TODO:
         dd($client->getProjectMasters()->unwrap()->toArray());
        $projectMaster->getClients()->toArray(); //this is working
        dd($client->getProjectMasters()->toArray()); //this is not working

        return Command::SUCCESS;
    }

    //@TODO Dayı bu Command a bakabilirsin. Sorun sadece Client te :(
}
