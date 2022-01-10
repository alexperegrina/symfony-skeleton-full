<?php
declare(strict_types=1);

namespace Core\Interfaces\Cli\GenerateCQS\Model;

use Core\Interfaces\Cli\GenerateCQS\ValueObject\CQSType;
use Core\Interfaces\Cli\GenerateCQS\ValueObject\Project;

class Configuration
{
    public const EXTENSION_PHP = 'php';

    private CQSType $cqs;
    private Project $project;
    private string $name;
    private ?string $module;

    public function __construct(
        private string $projectDir,
        private ?string $initNamespace = null
    ) {}

    public function cqs(): CQSType
    {
        return $this->cqs;
    }

    public function setCqs(CQSType $cqs): void
    {
        $this->cqs = $cqs;
    }

    public function project(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    public function srcDir(): string
    {
        $path = $this->projectDir . '/';
        $path .= 'src/';
        $path .= $this->project->value(true) . '/';
        $path .= 'src';

        return $path;
    }

    public function applicationDir(): string
    {
        $path = $this->srcDir() . '/';

        if ($this->project->useInternalModule()) {
            $path .= $this->module() . '/';
        }

        $path .= 'Application';

        return $path;
    }

    public function workDir(): string
    {
        $path = $this->applicationDir() . '/';
        $path .= $this->cqs->value(true) . '/';
        $path .= $this->name;

        return $path;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function namespace(): string
    {
        $namespace = '';

        if ($this->initNamespace) {
            $namespace = $this->initNamespace . '\\';
        }
        
        $namespace .= $this->project->value(true) . '\\';
        if ($this->project->useInternalModule()) {
            $namespace .= $this->module(true) . '\\';
        }
        $namespace .= 'Application\\';
        $namespace .= $this->cqs->value(true) . '\\';
        $namespace .= $this->name;

        return $namespace;
    }

    public function module(bool $format = false): ?string
    {
        if ($format && $this->module !== null) {
            return ucfirst($this->module);
        }
        return $this->module;
    }

    public function setModule(string $module): void
    {
        $this->module = $module;
    }
}