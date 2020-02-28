<?php


use Phinx\Migration\AbstractMigration;

class CreateOpportunitiesTagsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('opportunities_tags');

        $table->addColumn('opportunityId', 'integer')
            ->addColumn('tagId', 'integer')
            ->addForeignKey('opportunityId', 'opportunities', 'id', [
                'constraint' => 'fk_opportunitiesTags_opportunities'
            ])
            ->addForeignKey('tagId', 'tags', 'id', [
                'constraint' => 'fk_opportunitiesTags_tags'
            ])
            ->create();
    }
}
