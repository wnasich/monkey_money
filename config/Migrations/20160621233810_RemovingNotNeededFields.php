<?php
use Migrations\AbstractMigration;

class RemovingNotNeededFields extends AbstractMigration
{

    public function up()
    {
        $this->table('closings')
            ->removeColumn('closing_bills')
            ->removeColumn('status')
            ->addIndex(
                [
                    'created',
                ],
                [
                    'name' => 'by_created',
                ]
            )
            ->update();

    }

    public function down()
    {

        $this->table('closings')
            ->removeIndexByName('by_created')
            ->update();

        $this->table('closings')
            ->addColumn('closing_bills', 'text', [
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => null,
                'length' => 255,
                'null' => true,
            ])
            ->update();
    }
}

