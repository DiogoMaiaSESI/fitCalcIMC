<?php

namespace Controller;
use Model\User;
use Exception;
class UserController {
    private $userModel;
    public function __construct(User $userModel){
        $this->userModel = new User();
    }
    public function registerUser($user_fullname, $email, $password){
        try {
            if(empty($user_fullname) or empty($email) or empty($password)) {
                return false;
            }
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            return $this->userModel->registerUser($user_fullname, $email, $hashedpassword);
        } catch (Exception $error) {
            echo 'Erro ao cadastrar usuário: ' . $error->getMessage();
            return false;
        }
    }
    public function login($email, $password) {
        $user = $this->userModel->getUserByEmail($email);
        if ($user) {
            if(crypt($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['user_fullname'] = $user['user_fullname'];
                $_SESSION['email'] = $user['email'];
                return true;
            } else {
                return false;
            }
        }
        return false;
    }   
}
?>