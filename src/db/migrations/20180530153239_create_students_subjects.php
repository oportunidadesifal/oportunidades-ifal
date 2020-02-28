<?php


use Phinx\Migration\AbstractMigration;

class CreateStudentsSubjects extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('students_subjects');
        $table->addColumn('studentId', 'integer')
            ->addColumn('subjectId', 'integer')
            ->addForeignKey('studentId', 'students', 'user_id', [
                'constraint' => 'fk_studentsSubjects_students'
            ])
            ->addForeignKey('subjectId', 'subjects', 'id', [
                'constraint' => 'fk_studentsSubjects_subjects'
            ])
            ->create();
    }
}
