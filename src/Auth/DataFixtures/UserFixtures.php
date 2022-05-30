<?php
declare(strict_types=1);

namespace Auth\DataFixtures;

use Auth\Application\Command\CreateUser\CreateUserCommand;
use Auth\Application\Command\SetRoles\SetRolesCommand;
use Auth\Application\Command\VerifyUser\VerifyUserCommand;
use Core\Domain\Messenger\Bus\CommandBus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class UserFixtures extends Fixture
{
    public function __construct(
        private KernelInterface $kernel,
        private CommandBus $commandBus
    ) {}

    public function load(ObjectManager $manager)
    {
        $yamlFile = $this->readUsersData();

        foreach ($yamlFile as $user) {
            $command = CreateUserCommand::make($user['id'], $user['email'], $user['password']);
            $this->commandBus->dispatch($command);

            $command = SetRolesCommand::make($user['id'], $user['roles']);
            $this->commandBus->dispatch($command);

            $command = VerifyUserCommand::make($user['id']);
            $this->commandBus->dispatch($command);
        }
    }

    private function readUsersData(): array
    {
        $path = $this->kernel->locateResource('@AuthBundle/Resources/data/users.yaml');
        return Yaml::parseFile($path);
    }
}