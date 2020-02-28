<?php

namespace Oportunista\entities\users;

use Oportunista\Connection;

class TeacherDao
{
    protected $connect;
    protected $teacher;

    public function __construct(Teacher $teacher = null)
    {
        $this->connect = Connection::connect();
        $this->teacher = $teacher;
    }
    
    public function save()
    {
        $this->connect->beginTransaction();

        $sql = "INSERT INTO profiles (user_id, name, surname, gender, enrollment, birthday) values (:user_id, :name, :surname, :gender, :enrollment, :birthday)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':user_id', $this->teacher->getUserId());
        $stmt->bindValue(':name', $this->teacher->getName());
        $stmt->bindValue(':surname', $this->teacher->getSurname());
        $stmt->bindValue(':gender', $this->teacher->getGender());
        $stmt->bindValue(':enrollment', $this->teacher->getEnrollment());
        $stmt->bindValue(':birthday', $this->teacher->getBirthday());

        $result= $stmt->execute();

        if ($result != 1) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $sql = "INSERT INTO teachers (user_id, university_id) 
                values (:user_id, :university_id)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':user_id', $this->teacher->getUserId());
        $stmt->bindValue(':university_id', $this->teacher->getUniversityId());
        
        $result = $stmt->execute();

        if ($result != 1) {
            $this->connect->rollback();
            return "Could not process transaction";
        }

        $this->connect->commit();
        return true;
    }

    public function find (User $user)
    {
        $sql = "SELECT p.name, p.surname, p.gender, p.enrollment, p.image_id, p.birthday,
            t.university_id 
            FROM profiles p 
            JOIN teachers t 
            ON p.user_id = t.user_id 
            WHERE p.user_id = :userId";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue('userId', $user->getId());
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        $student = new Teacher($result, $user);

        return $student;
    }
}
