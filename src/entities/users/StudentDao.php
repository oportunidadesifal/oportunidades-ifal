<?php

namespace Oportunista\entities\users;

use Oportunista\Connection;
use Oportunista\entities\tags\TagDao;

class StudentDao
{

    protected $connect;
    protected $student;

    public function __construct(Student $student = null)
    {
        $this->connect = Connection::connect();
        $this->student = $student;
    }

    public function save()
    {
        $this->connect->beginTransaction();

        $sql = "INSERT INTO profiles (user_id, name, surname, gender, enrollment, birthday) values (:user_id, :name, :surname, :gender, :enrollment, :birthday)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':user_id', $this->student->getUserId());
        $stmt->bindValue(':name', $this->student->getName());
        $stmt->bindValue(':surname', $this->student->getSurname());
        $stmt->bindValue(':gender', $this->student->getGender());
        $stmt->bindValue(':enrollment', $this->student->getEnrollment());
        $stmt->bindValue(':birthday', $this->student->getBirthday());

        $result= $stmt->execute();

        if ($result != 1) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $sql = "INSERT INTO students (user_id, university_id) 
                values (:user_id, :university_id)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':user_id', $this->student->getUserId());
        $stmt->bindValue(':university_id', $this->student->getUniversityId());
        
        $result = $stmt->execute();

        if ($result != 1) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $interestTags = $this->student->getInterests();
        $tagDao = new TagDao();
        $tags = $tagDao->checkTags($interestTags);

        if (!$tags) {
            $this->connect->rollback();
            return "Invalid tag Id";
        }

        foreach ($tags as $tag) {
            $this->saveInterestTag($tag);
        }

        $this->connect->commit();
        return true;
    }

    private function saveInterestTag($tag)
    {
        $sql = "INSERT INTO students_tags (studentId, tagId) VALUES (:studentId, :tagId)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('studentId', $this->student->getUserId());
        $stmt->bindValue('tagId', $tag->getId());
        return $stmt->execute();
    }

    public function find (User $user)
    {
        $sql = "SELECT p.name, p.surname, p.gender, p.enrollment, p.image_id, p.birthday,
            s.university_id 
            FROM profiles p 
            JOIN students s 
            ON p.user_id = s.user_id 
            WHERE p.user_id = :userId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('userId', $user->getId());
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        $student = new Student($result, $user);

        $tagDao = new TagDao();
        $tags = $tagDao->getTagsByUserId($user);
        $student->setInterests($tags);

        return $student;
    }
}
