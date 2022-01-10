<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS;

use Core\Interfaces\Cli\GenerateCQS\Generator\CqsTypeGenerator;
use Core\Interfaces\Cli\GenerateCQS\Generator\Generator;
use Core\Interfaces\Cli\GenerateCQS\Generator\HandlerGenerator;
use Core\Interfaces\Cli\GenerateCQS\Generator\ServiceGenerator;
use Core\Interfaces\Cli\GenerateCQS\Model\Configuration;
use Core\Interfaces\Cli\GenerateCQS\Model\Instructions;
use Core\Interfaces\Cli\Traits\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class GenerateCQSCommand extends Command
{
    private const INIT_NAMESPACE = null;

    use File;

    public function __construct(private KernelInterface $kernel)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('core:generate:cqs')
            ->setDescription('Generate CQS');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $configuration = new Configuration(
            $this->kernel->getProjectDir(),
            self::INIT_NAMESPACE
        );

        Instructions::show($io, $configuration);

        $this->generate($configuration);

        $io->success('Generated');

        return Command::SUCCESS;
    }

    public function generate(Configuration $configuration): void
    {
        $generators = [
            CqsTypeGenerator::class,
            HandlerGenerator::class,
            ServiceGenerator::class,
        ];

        foreach ($generators as $generator) {
            $this->writeGenerator($generator, $configuration);
        }
    }

    protected function writeGenerator(
        string $class,
        Configuration $config
    ): void {
        /** @var $class Generator */
        $classString = $class::generate($config);
        $pathAbsolute = $class::absolutePath($config);

        $this->writeFileForceContents($pathAbsolute, $classString);
    }
}