<?php


use Phinx\Migration\AbstractMigration;

class CreateInterestsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('interests');

        $table->addColumn('opportunityId', 'integer')
            ->addColumn('userId', 'integer')
            ->addColumn('opportunityData', 'text')
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('lastUpdate', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
                
            ])
            ->addColumn('opportunityVersion', 'integer')
            ->addForeignKey('opportunityId', 'opportunities', 'id', [
                'constraint' => 'fk_interests_opportunities'
            ])
            ->addForeignKey('userId', 'users', 'id', [
                'constraint' => 'fk_interests_users'
            ])
            ->create();
    }
}
