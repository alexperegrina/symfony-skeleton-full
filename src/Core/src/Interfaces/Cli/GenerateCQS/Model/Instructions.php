<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Model;

use Exception;
use Core\Interfaces\Cli\GenerateCQS\ValueObject\CQSType;
use Core\Interfaces\Cli\GenerateCQS\ValueObject\Project;
use Core\Interfaces\Cli\Traits\CliStyle;
use Core\Interfaces\Cli\Traits\File;
use Symfony\Component\Console\Style\SymfonyStyle;

class Instructions
{
    use File;
    use CliStyle;

    const STYLE_STAR = '<fg=red;options=bold>*</>';
    const STYLE_LINE = '<fg=red;options=bold>    -</>';

    public static function show(SymfonyStyle $io, Configuration $config)
    {
        self::note($io, [
            'Al finalizar hay que ejecutar. '.self::applyStyle('composer dumpautoload', 'blue'),
        ]);

        self::title($io, 'Generate CQS');

        self::step1($io, $config);
        self::step2($io, $config);
        self::step3($io, $config);
        self::step4($io, $config);
    }

    protected static function step1(SymfonyStyle $io, Configuration $config): void
    {
        self::step($io, 1);

        $cqs = $io->choice(
            'Seleccionar CQSType a generar',
            CQSType::ALLOWED_VALUES,
            CQSType::COMMAND
        );

        $config->setCqs(new CQSType($cqs));
    }

    protected static function step2(SymfonyStyle $io, Configuration $config): void
    {
        self::step($io, 2);

        $project = $io->choice(
            'Seleccionar proyecto donde se generara',
            Project::ALLOWED_VALUES,
            Project::CORE
        );

        $config->setProject(new Project($project));
    }

    protected static function step3(SymfonyStyle $io, Configuration $config): void
    {
        self::step($io, 3);

        if (!$config->project()->useInternalModule()) {
            $io->text(self::STYLE_STAR.self::applyStyle(' El proyecto seleccionado no requiere de modulo', 'white'));
        } else {
            $folder = scandir($config->srcDir());

            $modules = [];
            foreach ($folder as $item) {
                if (
                    $item !== '.'  &&
                    $item !== '..' &&
                    is_dir($config->srcDir().'/'.$item)
                ) {
                    $modules[] = $item;
                }
            }

            $module = $io->choice(
                'Selecionar modulo donde se generara',
                $modules,
                $modules[0]
            );

            $config->setModule($module);
        }
    }

    protected static function step4(SymfonyStyle $io, Configuration $config): void
    {
        self::step($io, 4);

        $io->text(self::STYLE_STAR.self::applyStyle(" No hay que poner al final del nombre 'Command/Query'", 'white'));

        $name = $io->ask(
            'Inserta un nombre del CQS',
            null,
            function ($nameIn) {
                if (is_null($nameIn)) {
                    throw new Exception('name not null');
                }

                return ucfirst($nameIn);
            }
        );

        $config->setName($name);
    }
}