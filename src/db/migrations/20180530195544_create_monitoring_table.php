<?php


use Phinx\Migration\AbstractMigration;

class CreateMonitoringTable extends AbstractMigration
{
   public function change()
    {
        $table = $this->table('monitoring', [
            'id' => false,
            'primary_key' => 'id'
        ]);

        $table->addColumn('id', 'integer')
            ->addColumn('monitors', 'integer')
            ->addColumn('scholarship', 'float')
            ->addColumn('numberOfMonitors', 'integer')
            ->addColumn('disciplineCode', 'string', [
                'limit' => 255
            ])
            ->addForeignKey('id', 'opportunities', 'id', [
                'constraint' => 'fk_monitoring_opportunities'
            ])
            ->create();



    }
}
