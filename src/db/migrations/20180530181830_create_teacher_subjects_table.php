<?php


use Phinx\Migration\AbstractMigration;

class CreateTeacherSubjectsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('teachers_subjects');
        $table->addColumn('teacherId', 'integer')
            ->addColumn('subjectId', 'integer')
            ->addForeignKey('teacherId', 'teachers', 'user_id', [
                'constraint' => 'fk_teacherSubjects_teachers'
            ])
            ->addForeignKey('subjectId', 'subjects', 'id', [
                'constraint' => 'fk_teacherSubjects_subjects'
            ])
            ->create();
    }
}
