<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventListener;

use Core\Domain\Validator\RequestValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class RequestValidatorListener
{
    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        $controllerArguments = $event->getArguments();

        $newRequest = null;
        foreach ($controllerArguments as $argument) {
            if ($argument instanceof RequestValidator) {
                $argument->validate($event->getRequest());
                $newRequest = $argument->request();
            }
        }

        if ($newRequest !== null) {
            foreach ($controllerArguments as $key => $argument) {
                if ($argument instanceof Request) {
                    $controllerArguments[$key] = $newRequest;
                }
            }

            // set the controller arguments to modify the original arguments or add new ones
            $event->setArguments($controllerArguments);
        }
    }
}