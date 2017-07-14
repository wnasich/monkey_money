<?php
use Migrations\AbstractMigration;

class DefaultValueForClosingAmount extends AbstractMigration
{

    public function up()
    {

        $this->table('closings')
            ->changeColumn('closing_amount', 'decimal', [
                'default' => 0,
            ])
            ->update();
    }

    public function down()
    {

        $this->table('closings')
            ->changeColumn('closing_amount', 'decimal', [
                'default' => null,
                'length' => 10,
                'null' => false,
                'precision' => null,
                'scale' => 2,
            ])
            ->update();
    }
}

