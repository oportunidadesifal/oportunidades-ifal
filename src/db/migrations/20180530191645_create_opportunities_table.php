<?php


use Phinx\Migration\AbstractMigration;

class CreateOpportunitiesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('opportunities');

        $table->addColumn('title', 'string', [
            'limit' => 255
        ])
            ->addColumn('description', 'text')
            ->addColumn('authorId', 'integer')
            ->addColumn('type', 'string', [
                'limit' => 30
            ])
            ->addColumn('version', 'integer', [
                'default' => 0
            ])
            ->addColumn('closed', 'boolean', [
                'default' => false
            ])
            ->addColumn('posterBackgroundId', 'integer', [
                'default' => 0
            ])
            ->addColumn('posterIconId', 'integer', [
                'default' => 0
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('lastUpdate', 'timestamp', [
                'null' => true
                
            ])
            ->addColumn('deleted', 'boolean', [
                'default' => false
            ])
            ->addForeignKey('authorId', 'users', 'id', [
                'constraint' => 'fk_opportunities_users'
            ])
            ->create();

    }
}
