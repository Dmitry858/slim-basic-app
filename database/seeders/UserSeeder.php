<?php

use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'name'  => 'Test',
                'email' => 'test@test.ru',
                'password' => sha1('secret'),
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->saveData();
    }
}
