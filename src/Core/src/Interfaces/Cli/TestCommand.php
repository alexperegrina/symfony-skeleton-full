<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli;

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

    }
}