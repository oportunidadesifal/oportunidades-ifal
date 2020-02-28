<?php


use Phinx\Migration\AbstractMigration;

class CreateInternshipsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('internships', [
            'id' => false,
            'primary_key' => 'id'
        ]);

        $table->addColumn('id', 'integer')
            ->addColumn('salary', 'float')
            ->addColumn('numberVacantJob', 'integer')
            ->addColumn('weeklyWorkLoad', 'integer')
            ->addColumn('benefits', 'text')
            ->addColumn('requirements', 'text')
            ->addColumn('location', 'text')
            ->addColumn('shift', 'text')
            ->addColumn('code', 'text')
            ->addColumn('companyId', 'text')
            ->addForeignKey('id', 'opportunities', 'id', [
                'constraint' => 'fk_internships_opportunities'
            ])
            ->create();
    }
}
