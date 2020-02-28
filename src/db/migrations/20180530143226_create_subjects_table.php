<?php


use Phinx\Migration\AbstractMigration;

class CreateSubjectsTable extends AbstractMigration
{
    public function change()
    {
        $subjects = $this->table('subjects');
        $subjects->addColumn('course_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('code', 'string', ['limit' => 20])
            ->addColumn('Schedule', 'text', ['limit' => 20])
            ->addColumn('days', 'string', ['limit' => 255])
            ->addColumn('period', 'integer')
            ->addForeignKey('course_id', 'courses', 'id', [
                'constraint' => 'fk_subjects_course'])
            ->create();
    }
}
