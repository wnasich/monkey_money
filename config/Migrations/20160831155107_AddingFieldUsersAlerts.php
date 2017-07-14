<?php
use Migrations\AbstractMigration;

class AddingFieldUsersAlerts extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('alerts', 'text', [
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('users')
            ->removeColumn('alerts')
            ->update();
    }
}

