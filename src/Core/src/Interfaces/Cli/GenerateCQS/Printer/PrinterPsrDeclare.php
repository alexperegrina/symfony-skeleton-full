<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Printer;

use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;
use Nette\Utils\Strings;

class PrinterPsrDeclare extends Printer
{
    /** @var string */
    protected $indentation = '    ';

    /** @var int */
    protected $linesBetweenMethods = 1;

    public function printFile(PhpFile $file): string
    {
        $namespaces = [];
        foreach ($file->getNamespaces() as $namespace) {
            $namespaces[] = $this->printNamespace($namespace);
        }

        $head = "<?php\n";
        if (!is_null($file->getComment())) {
            $head .= Helpers::formatDocComment($file->getComment() . "\n");
            $head .= "\n";
        }

        if (!is_null($file->hasStrictTypes())) {

        }
        $head .= ($file->hasStrictTypes() ? "declare(strict_types=1);\n\n" : '');
        $head .= implode("\n\n", $namespaces);

        return Strings::normalize($head);
    }
}