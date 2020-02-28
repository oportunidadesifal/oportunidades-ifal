<?php
declare(strict_types=1);
namespace Oportunista\entities\tags;

use Oportunista\Connection;
use Oportunista\entities\users\User;

class TagDao
{
    protected $connect;
    protected $tags;

    public function __construct(Array $tags = null)
    {
        $this->connect = Connection::connect();
        $this->tags = $tags;
    }

    public function get()
    {
        $sql = "SELECT * FROM tags";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($result == null) {
            return false;
        }

        $tags = array();
        foreach ($result as $tag) {
            $tags[] = new Tag($tag);
        }

        return $tags;
    }

    public function checkTags($arrayIds)
    {
        $tags = array();

        foreach ($arrayIds as $tag) {
            $sql = "SELECT * FROM tags WHERE id = :id";
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(':id', $tag);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($stmt->rowCount() <= 0) {
                return false;
            }

            $tags[] = new Tag($result);
        }

        return $tags;
    }

    public function getTagsByUserId(User $user)
    {
        $sql = "SELECT t.id, t.name 
              FROM students_tags st 
              JOIN students s 
              ON s.user_id = st.studentId 
              JOIN tags t 
              ON t.id = st.tagId 
              WHERE s.user_id = :userId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('userId', $user->getId());
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($stmt->rowCount() <= 0) {
            return false;
        }

        foreach ($result as $tag) {
            $tags[] = new Tag($tag);
        }

        return $tags;
    }
}