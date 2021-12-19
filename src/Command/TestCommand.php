<?php

namespace App\Command;

use App\Repository\ClientRepository;
use App\Repository\ProjectMasterRepository;
use App\Service\ClientManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'TestCommand',
    description: 'Add a short description for your command',
)]
class TestCommand extends Command
{

    /** @var ClientRepository */
    private $clientRepository;

    /** @var ProjectMasterRepository */
    private $projectMasterRepository;

    /** @var ClientManager */
    private $clientManager;

    public function __construct(ClientRepository $clientRepository, ProjectMasterRepository $projectMasterRepository, ClientManager $clientManager, string $name = null)
    {
        $this->projectMasterRepository =$projectMasterRepository;
        $this->clientRepository = $clientRepository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $client = $this->clientRepository->find(2);
        $projectMaster = $this->projectMasterRepository->find(1);

       $projectMaster->getClients()->count();


        dd($this->clientManager->isEligible([
            'IdNumber' => $client->getIdDocNumber(),
            'amount'  => 23445
        ]));


        return Command::SUCCESS;
    }
}
