<?php
use Migrations\AbstractMigration;

class AddingClosingsStatus extends AbstractMigration
{

    public function up()
    {

        $this->table('closings')
            ->addColumn('status', 'string', [
                'default' => null,
                'length' => 45,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('closings')
            ->removeColumn('status')
            ->update();
    }
}

