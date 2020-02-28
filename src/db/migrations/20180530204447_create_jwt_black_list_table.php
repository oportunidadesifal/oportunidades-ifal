<?php


use Phinx\Migration\AbstractMigration;

class CreateJwtBlackListTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('jwtBlackList');
        $table->addColumn('jwtId', 'string')
            ->addColumn('expTime', 'timestamp')
            ->create();
    }
}
