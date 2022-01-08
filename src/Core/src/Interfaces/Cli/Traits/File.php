<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\Traits;

trait File
{
    protected static function writeFileForceContents(
        string $absolutePath,
        string $data,
        int $flags = 0
    ) {
        if (!is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath).'/', 0755, true);
        }
        return file_put_contents($absolutePath, $data, $flags);
    }

    protected static function buildPathComplete(
        string $absolutePathWorkDir,
        string $className,
        string $extension
    ): string {
        $path = $absolutePathWorkDir.$className;
        if ($extension != '') {
            $path .= '.'.$extension;
        }
        return $path;
    }
}