<?php

namespace Oportunista\entities\news;

use Oportunista\Connection;

class NewsDao
{
    protected $connect;
    protected $news;

    public function __construct(News $news = null)
    {
        $this->connect = Connection::connect();
        $this->news = $news;
    }

    public function save()
    {
        $sql = "INSERT INTO urgent_news (title, description, authorId, subjectId) values(
                :title, :description, :authorId, :subjectId)";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('title', $this->news->getTitle());
        $stmt->bindValue('description', $this->news->getDescription());
        $stmt->bindValue('authorId', $this->news->getAuthor()->getId());
        $stmt->bindValue('subjectId', $this->news->getSubject()->getId());

        $result = $stmt->execute();

        if ($result != 1) {
            return "Could not process transaction";
        }

        return true;
    }
}