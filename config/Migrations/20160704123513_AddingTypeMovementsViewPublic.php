<?php
use Migrations\AbstractMigration;

class AddingTypeMovementsViewPublic extends AbstractMigration
{

    public function up()
    {

        $this->table('movement_types')
            ->addColumn('view_public', 'integer', [
                'default' => 0,
                'length' => 3,
                'null' => true,
            ])
            ->update();

            $count = $this->execute('UPDATE movement_types SET view_public = 1;');
    }

    public function down()
    {

        $this->table('movement_types')
            ->removeColumn('view_public')
            ->update();
    }
}

