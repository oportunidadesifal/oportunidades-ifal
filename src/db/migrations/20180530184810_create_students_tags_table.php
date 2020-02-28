<?php


use Phinx\Migration\AbstractMigration;

class CreateStudentsTagsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('students_tags');

        $table->addColumn('studentId', 'integer')
            ->addColumn('tagId', 'integer')
            ->addForeignKey('studentId', 'students', 'user_id', [
                'constraint' => 'fk_studentsTags_students'
            ])
            ->addForeignKey('tagId', 'tags', 'id', [
                'constraint' => 'fk_studentsTags_tags'
            ])
            ->create();
    }
}
