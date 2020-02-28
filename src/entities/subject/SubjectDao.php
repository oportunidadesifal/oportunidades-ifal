<?php

namespace Oportunista\entities\subject;


use Oportunista\Connection;

class SubjectDao
{
    protected $connect;
    protected $subject;

    public function __construct(Array $subject = null)
    {
        $this->connect = Connection::connect();
        $this->subject = $subject;
    }

    public static function find($id)
    {
        $connect = Connection::connect();
        $sql = "SELECT * FROM subjects WHERE ID = :id";

        $stmt = $connect->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($result === false)  {
            return false;
        }

        $subject = new Subject($result);
        return $subject;
    }

    public function findSubjectsByCourseId($courseId)
    {
        $sql = "SELECT * FROM subjects WHERE course_id = :courseId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('courseId', $courseId);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if ($result == false) {
            return false;
        }

        $subjects = [];
        foreach ($result as $subject) {
            $subjects[] = new Subject($subject);
        }

        return $subjects;
    }
}