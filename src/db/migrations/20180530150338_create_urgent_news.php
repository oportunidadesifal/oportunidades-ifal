<?php


use Phinx\Migration\AbstractMigration;

class CreateUrgentNews extends AbstractMigration
{
    public function change()
    {
        $urgentNews = $this->table('urgent_news');
        $urgentNews->addColumn('title', 'string', ['limit' => 50])
            ->addColumn('description', 'string', ['limit' => 100])
            ->addColumn('authorId', 'integer')
            ->addColumn('subjectId', 'integer')
            ->addColumn('created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('lastUpdate', 'timestamp', [
                'null' => true
                
            ])
            ->addForeignKey('authorId', 'users', 'id', [
                'constraint' => 'fk_urgentNews_users'
            ])
            ->addForeignKey('subjectId', 'subjects', 'id', [
                'constraint' => 'fk_urgentNews_subject'
            ])
            ->create();
    }
}
