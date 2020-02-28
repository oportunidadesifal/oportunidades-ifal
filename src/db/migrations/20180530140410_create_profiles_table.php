<?php


use Phinx\Migration\AbstractMigration;

class CreateProfilesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $profiles = $this->table('profiles');
        $profiles->addColumn('user_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('surname', 'string', ['limit' => 255])
            ->addColumn('image_id', 'string', [
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('gender', 'enum', ['values' => ['m', 'f']])
            ->addColumn('enrollment', 'string', ['limit' => 30])
            ->addColumn('birthday', 'string', ['limit' => 30])
            ->addForeignKey('user_id', 'users', 'id', ['constraint' => 'fk_profiles_users'])
            ->create();
    }
}
