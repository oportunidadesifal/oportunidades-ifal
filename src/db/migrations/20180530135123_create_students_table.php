<?php


use Phinx\Migration\AbstractMigration;

class CreateStudentsTable extends AbstractMigration
{
    public function up()
    {
        $students = $this->table('students', [
            'id' => false,
            'primary_key' => 'user_id'
        ]);
        $students->addColumn('user_id', 'integer')
            ->addColumn('university_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['constraint' => 'fk_students_users'])
            ->save();
    }

    public function down()
    {
        $students = $this->table('students');
        $students->dropForeignKey('user_id');
        $this->dropTable('students');
    }
}
