<?php


use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function up()
    {
        $user = $this->table('users');
        $user->addColumn('username', 'string',  [
            'limit' => 30
            ])
            ->addColumn('password', 'string', [
                'limit' => 255
            ])
            ->addColumn('category', 'enum', [
                'values' => [
                    'Teacher',
                    'Student'
                ]
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('lastUpdate', 'timestamp', [
                'null' => true,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->save();
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
