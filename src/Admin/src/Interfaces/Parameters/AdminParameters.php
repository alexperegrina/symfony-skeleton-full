<?php
declare(strict_types=1);

namespace Admin\Interfaces\Parameters;

use Auth\Domain\Entity\User;

class AdminParameters
{
    const PAGE_HOME = "admin_home";
    const PAGE_DASHBOARD = "admin_dashboard";
    const PAGE_USERS = "admin_users";


    private static function main(User $user): array
    {
        return [
            'user' => [
                'id' => $user->id()->value(),
                'name' => [
                    'first' => $user->name()?->firstName()->value(),
                    'full' => $user->name()?->fullName()->value(),
                ],
                'email' => $user->email()
            ]
        ];
    }

    private static function sidebar(string $page): array
    {
        $sidebar = [
            'page' => [
                'home' => '',
                'dashboard' => '',
                'users' => '',
            ],
        ];

        switch ($page) {
            case self::PAGE_HOME:
                $sidebar['page']['home'] = 'active';
                break;
            case self::PAGE_DASHBOARD:
                $sidebar['page']['dashboard'] = 'active';
                break;
            case self::PAGE_USERS:
                $sidebar['page']['users'] = 'active';
                break;
        }

        return $sidebar;
    }

    public static function home(User $user): array
    {
        $parameters = self::main($user);
        $parameters['sidebar'] = self::sidebar(self::PAGE_HOME);
        return $parameters;
    }

    public static function dashboard(User $user): array
    {
        $parameters = self::main($user);
        $parameters['sidebar'] = self::sidebar(self::PAGE_DASHBOARD);
        return $parameters;
    }

    /**
     * @param User[] $users
     */
    public static function users(User $user, array $users): array
    {
        $parameters = self::main($user);
        $parameters['sidebar'] = self::sidebar(self::PAGE_USERS);

        foreach ($users as $item) {
            $parameters['users'][] = [
                'id' => $item->id()->value(),
                'name' => $item->name()?->fullName()->value(),
                'email' => $item->email(),
                'gender' => $item->gender()?->value()
            ];
        }

        return $parameters;
    }
}