<?php
namespace Model;

use Model\Connection;

use PDO;
use PDOException;
class User {
    private $db;
    public function __construct(){
        $this->db = Connection::getInstance();
    }
    public function registerUser($user_fullname, $email ,$password){
        try {
            $sql = 'INSERT INTO user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password, NOW())';
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedpassword , PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $error) {
            echo 'Erro ao executar o comando' . $error->getMessage();
            return false;
        }
    }
}
?>