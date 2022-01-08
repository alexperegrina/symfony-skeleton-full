<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\Traits;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Style\SymfonyStyle;

trait CliStyle
{
    protected static function applyStyle(
        string $data,
        string $color,
        bool $bold = true,
        bool $underscore = false
    ): string {
        $options = [];
        if ($bold) $options[] = 'bold';
        if ($underscore) $options[] = 'underscore';

        $optStr = ';options='.implode(',', $options);

        return "<fg=$color$optStr>$data</>";
    }

    protected static function note(SymfonyStyle $io, array $notes): void
    {
        $io->text(self::applyStyle('[NOTE]', 'yellow'));
        $io->text(self::applyStyle('------', 'magenta'));

        foreach ($notes as $note) {
            $io->text(
                self::applyStyle('  - ', 'magenta').
                self::applyStyle($note, 'yellow')
            );
        }
    }

    protected static function questionYesAndNot(
        SymfonyStyle $io,
        bool $default,
        string $msg
    ): bool {
        $response = $io->choice(
            $msg,
            array('Si', 'No'),
            ($default) ? 'Si' : 'No'
        );

        return ($response == 'Si');
    }

    protected static function step(SymfonyStyle $io, int $number)
    {
        $outputStyle = new OutputFormatterStyle('yellow', 'blue', ['bold']);
        $io->getFormatter()->setStyle('step', $outputStyle);

        $msg = "Paso $number";
        $repeatNull = str_repeat(" ", strlen($msg));
        $repeat = str_repeat("-", strlen($msg));

        $io->writeln("<step>  $repeatNull  </>");
        $io->writeln("<step>  $msg  </>");
        $io->writeln("<step>  $repeat  </>");
        $io->newLine();
    }

    protected static function title(SymfonyStyle $io, string $title)
    {
        $outputStyle = new OutputFormatterStyle('red', 'blue', ['bold']);
        $io->getFormatter()->setStyle('title', $outputStyle);

        $outputStyle = new OutputFormatterStyle('yellow', 'blue', ['bold']);
        $io->getFormatter()->setStyle('title-line', $outputStyle);

        $repeat = str_repeat("=", strlen($title));
        $io->newLine();
        $io->writeln("<title-line>\t $repeat  \t</>");
        $io->writeln("<title>\t $title  \t</>");
        $io->writeln("<title-line>\t $repeat  \t</>");
        $io->newLine();
    }
}