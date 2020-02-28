<?php


use Phinx\Migration\AbstractMigration;

class CreateCoursesTable extends AbstractMigration
{
    public function change()
    {
        $courses = $this->table('courses');
        $courses->addColumn('name', 'string', ['limit' => 255])
            ->create();
    }
}
