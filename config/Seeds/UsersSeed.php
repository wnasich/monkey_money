<?php
use Phinx\Seed\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Admin',
            'username' => 'admin',
            'password' => '$2y$10$I4PuCZ9S/jlMGBm9aG2mmuDn1O0GD4X/STm3kDZShRnRwAjRKQY4W',
            'role' => 'admin',
            'status' => 'enabled',
        ];

        $table = $this->table('users');
        $table->insert($data)->save();

        $data = [
            'name' => 'Cashier01',
            'username' => 'cashier01',
            'password' => '$2y$10$qLCtOH9sEnV4NOlTfWxHGuy3LvU6w6jg4.zhAlW1f4W7PFaYLsAUu',
            'role' => 'operator',
            'status' => 'enabled',
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
