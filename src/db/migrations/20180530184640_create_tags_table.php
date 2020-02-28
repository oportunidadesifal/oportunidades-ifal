<?php


use Phinx\Migration\AbstractMigration;

class CreateTagsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('tags');
        $table->addColumn('name', 'string', [
            'limit' => '50'
        ])
            ->create();
    }
}
