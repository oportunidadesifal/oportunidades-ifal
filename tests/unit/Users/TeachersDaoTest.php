<?php

namespace Oportunista\entities\users;

class TeachersDaoTest extends \PHPUnit\Framework\TestCase
{
    public function testInsertTeacherWithAExistentTeacherUsername()
    {
        $user = array();
        $user =  [
            "username" => "kenji",
            "password" => "teste",
            "name" => "Joao",
            "surname" => "Da Silva",
            "gender" => "m",
            "enrollment" => 12453245345,
            "birthday" => "11/11/1992",
            "category" => "teachers",
            "university_id" => 12
        ];
        $category = "Teacher";
        
        $teacher = new Teacher($user, $category);
        $teachersDao = new TeacherDao($teacher);

        $result = $teachersDao->save();

        $expected = "This username already exists.";
        $this->assertEquals($expected, $result);
    }

    public function testInsertTeacherWithANonexistingTeacherUsername()
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
            "category" => "teachers",
            "university_id" => 12
        ];
        $category = "Teacher";
        
        $teacher = new Teacher($user, $category);
        $teachersDao = new TeacherDao($teacher);

        $result = $teachersDao->save();

        $expected = true;
        $this->assertEquals($expected, $result);
    }
}
