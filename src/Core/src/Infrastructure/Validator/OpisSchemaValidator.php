<?php
declare(strict_types=1);

namespace Core\Infrastructure\Validator;

use Core\Domain\Exception\InvalidPathException;
use Core\Domain\Exception\SchemaValidatorException;
use Core\Domain\Validator\FormatValidator;
use Core\Domain\Validator\SchemaValidator;
use Opis\JsonSchema\Errors\ErrorFormatter;
use Opis\JsonSchema\Validator;
use Symfony\Component\HttpKernel\KernelInterface;

class OpisSchemaValidator implements SchemaValidator
{
    private Validator $validator;

    public function __construct(
        private KernelInterface $kernel,
        private array $config
    ) {
        $this->init();
        $this->declareResources();
        $this->registerCallable();
    }

    private function init(): void
    {
        $this->validator = new Validator();
        $this->configure();
    }

    private function configure(): void
    {
        $this->validator->setMaxErrors(10);
        $this->validator->parser()->setOption('defaultDraft', '07');
//        dd($this->validator->parser()->getOptions());
    }

    private function declareResources(): void
    {
        $resolver = $this->validator->resolver();

        foreach ($this->config['declare'] as $item) {
            $path = $this->realPath($item['path']);
            $resolver->registerPrefix($item['prefix'], $path);
        }
    }

    private function registerCallable(): void
    {
        foreach ($this->config['format'] as $format) {
            if (in_array(FormatValidator::class, class_implements($format))) {
                $this->validator->parser()->getFormatResolver()->registerCallable(
                    $format::type(),
                    $format::name(),
                    $format::validate()
                );
            }
        }
    }

    /**
     * @throws InvalidPathException
     */
    private function realPath(string $path): string
    {
        if ($path[0] === '@') {
            $newPath = $this->kernel->locateResource($path);
        } else {
            $newPath = realpath($path);
            if ($newPath == false) {
                throw new InvalidPathException($path);
            }
        }

        return $newPath;
    }

    public function validate(object|array $data, string $pathSchema): object|array
    {
        $newData = $data;
        $isArray = is_array($newData);

        if (is_array($newData)) {
            $newData = json_decode(json_encode($newData));
        }

        $path = $this->realPath($pathSchema);
        $schema = file_get_contents($path);

        $result = $this->validator->validate($newData, $schema);

        if ($result->hasError()) {
            $error = $result->error();
            $formatter = new ErrorFormatter();

            throw new SchemaValidatorException($formatter->format($error, false));
        }

        if ($isArray) {
            $newData = json_decode(json_encode($newData), true);
        }

        return $newData;
    }
}