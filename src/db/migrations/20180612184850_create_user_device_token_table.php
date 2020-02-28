<?php


use Phinx\Migration\AbstractMigration;

class CreateUserDeviceTokenTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('userDeviceToken');
        $table->addColumn('user_id', 'integer')
            ->addColumn('deviceToken', 'text')
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('lastUpdate', 'timestamp', [
                'null' => true,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('deleted', 'boolean', [
                'default' => false
            ])
            ->addForeignKey('user_id', 'users', 'id', [
                'constraint' => 'fk_userDeviceToken_users'
            ])
            ->create();
    }
}
