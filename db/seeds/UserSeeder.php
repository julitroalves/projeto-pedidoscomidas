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
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => 'qwe123',
                'email'    => 'contato@housecursos.com',
                'name'     => 'Julio Alves',
                'created'  => date('Y-m-d H:i:s')
            ]
        ];

        $users = $this->table('users');
        $users->insert($data);
        $users->save();
    }
}
