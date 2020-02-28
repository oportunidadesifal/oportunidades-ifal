<?php


use Phinx\Migration\AbstractMigration;

class CreateResearchesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('researches', [
            'id' => false,
            'primary_key' => 'id'
        ]);

        $table->addColumn('id', 'integer')
            ->addColumn('status', 'text')
            ->addColumn('modality', 'text')
            ->addColumn('startDate', 'string', [
                'limit' => 30
            ])
            ->addColumn('duration', 'integer')
            ->addColumn('scholarship', 'float')
            ->addColumn('members', 'integer')
            ->addForeignKey('id', 'opportunities', 'id', [
                'constraint' => 'fk_researches_opportunities'
            ])
            ->create();
    }
}
