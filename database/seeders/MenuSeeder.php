<?php

use Phinx\Seed\AbstractSeed;

class MenuSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'title'  => 'Главная',
                'link' => '/',
            ],
            [
                'title'  => 'О компании',
                'link' => '/about',
            ],
            [
                'title'  => 'Регистрация',
                'link' => '/register',
            ],
            [
                'title'  => 'Вход',
                'link' => '/login',
            ],
            [
                'title'  => 'Выход',
                'link' => '/logout',
            ],
        ];

        $menu = $this->table('menu');
        $menu->insert($data)->saveData();
    }
}
