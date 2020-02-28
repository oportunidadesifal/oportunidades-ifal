<?php

namespace Oportunista\entities\users;

class UserLoginTest extends \PHPUnit\Framework\TestCase
{
    public function testCheckUserWithValidUser()
    {
        $user = new User("teste", "teste");
        $userLogin = new userLogin($user);
        $result = $userLogin->checkUser();

        $this->assertNotEmpty($result);
    }

    public function testCheckUserWithInvalidUser()
    {
        $user = new User("ljsahdf", "sljkdahf");
        $userLogin = new userLogin($user);
        $result = $userLogin->checkUser();
        
        $this->assertEmpty($result);
        $this->assertEquals(false, $result);
    }
}
