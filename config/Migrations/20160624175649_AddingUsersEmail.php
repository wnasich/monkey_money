<?php
use Migrations\AbstractMigration;

class AddingUsersEmail extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('email', 'string', [
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('email')
            ->update();
    }
}

