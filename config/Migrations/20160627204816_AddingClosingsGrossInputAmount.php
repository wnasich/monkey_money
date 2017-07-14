<?php
use Migrations\AbstractMigration;

class AddingClosingsGrossInputAmount extends AbstractMigration
{

    public function up()
    {

        $this->table('closings')
            ->addColumn('since', 'datetime', [
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('gross_input_amount', 'decimal', [
                'default' => null,
                'length' => 10,
                'null' => false,
                'precision' => null,
                'scale' => 2,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('closings')
            ->removeColumn('since')
            ->removeColumn('gross_input_amount')
            ->update();
    }
}

