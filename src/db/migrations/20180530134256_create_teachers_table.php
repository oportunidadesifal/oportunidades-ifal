<?php


use Phinx\Migration\AbstractMigration;

class CreateTeachersTable extends AbstractMigration
{
    public function up()
    {
        $teachers = $this->table('teachers', [
            'id' => false,
            'primary_key' => 'user_id'
        ]);
        $teachers->addColumn('user_id', 'integer')
            ->addColumn('university_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['constraint' => 'fk_teachers_users'])
            ->save();
    }

    public function down()
    {
        $teachers = $this->table('teachers');
        $teachers->dropForeignKey('user_id');
        $this->dropTable('teachers');
    }
}
