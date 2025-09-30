<?php

use PHPUnit\Framework\TestCase;

use Controller\UserController;

use Model\User;

class UserTest extends TestCase {
    private $userController;
    private $mockUserModel;

    public protected function setUp(): void {
        $this->mockUserModel = $this->createMock(User::class);

        $this->userController = new UserController($this->mockUserModel);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_create_user() {
        $userResult = $this->userController->registerUser('Ana Luisa Santos', 'ana@rxample.com', '123456');
        $this->assertTrue($userResult);
    }

    #[\PHPunit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in() {
        $this->mockUserModel->method('getUserByEmail')->willReturn([
            'id' => 1,
            'user_fullname' => 'Ana Luisa Santos',
            'email' => 'ana@example.com',
            'password' => password_hash('123456', PASSWORD_DEFAULT)
        ]);
    }
}
?>