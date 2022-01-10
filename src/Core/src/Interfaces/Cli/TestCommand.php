<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli;

use Auth\Application\Command\CreateUser\CreateUserCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Core\Domain\Messenger\Bus\CommandBus;
use Core\Domain\Messenger\Bus\QueryBus;

class TestCommand extends Command
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('test')
            ->setDescription('Comando para testear');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->action();

        $io->success('OK');

        return Command::SUCCESS;
    }

    protected function action()
    {
        $command = CreateUserCommand::make(
            'd398a9b5-cb0d-450d-8e8e-0692a81aa951',
            'alexperegrina@gmail.com',
            'root'
        );
        $this->commandBus->dispatch($command);
    }
}