<?php


use Phinx\Migration\AbstractMigration;

class CreateEventsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('events', [
            'id' => false,
            'primary_key' => 'id'
        ]);

        $table->addColumn('id', 'integer')
            ->addColumn('location', 'string', [
                'limit' => 255
            ])
            ->addColumn('eventSchedule', 'string', [
                'limit' => 255
            ])
            ->addColumn('eventDate', 'string', [
                'limit' => 30
            ])
            ->addColumn('site', 'string', [
                'limit' => 255
            ])
            ->addColumn('price', 'float')
            ->addForeignKey('id', 'opportunities', 'id', [
                'constraint' => 'fk_events_opportunities'
            ])
            ->create();

    }
}
