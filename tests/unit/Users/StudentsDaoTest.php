<?php

namespace Oportunista\entities\users;

class StudentsDaoTest extends \PHPUnit\Framework\TestCase
{
    public function testInsertStudentWithAExistentStudentUsername()
    {
        $user = array();
        $user =  [
            "username" => "tesse",
            "password" => "teste",
            "name" => "Joao",
            "surname" => "Da Silva",
            "gender" => "m",
            "enrollment" => 12453245345,
            "birthday" => "11/11/1992",
            "category" => "students",
            "university_id" => 12
        ];
        $category = "Student";
        
        $student = new Student($user, $category);
        $studentsDao = new StudentDao($student);

        $result = $studentsDao->save();

        $expected = "This username already exists.";
        $this->assertEquals($expected, $result);
    }

    public function testInsertStudentWithANonexistingStudentUsername()
    {
        $user = array();
        $username = "teste" . rand();
        $user =  [
            "username" => "$username",
            "password" => "teste",
            "name" => "Joao",
            "surname" => "Da Silva",
            "gender" => "m",
            "enrollment" => 12453245345,
            "birthday" => "11/11/1992",
            "category" => "students",
            "university_id" => 12
        ];
        $category = "Student";
        
        $student = new Student($user, $category);
        $studentsDao = new StudentDao($student);

        $result = $studentsDao->save();

        $expected = true;
        $this->assertEquals($expected, $result);
    }
}
