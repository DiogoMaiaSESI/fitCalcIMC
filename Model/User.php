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
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password , PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $error) {
            echo 'Erro ao executar o comando' . $error->getMessage();
            return false;
        }
    }
    
    public function getUserByEmail($email){
        try{
            $sql = 'SELECT * FROM user WHERE email = :email LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $error){
            echo 'Erro ao executar o comando' . $error->getMessage();
            return false;
        }
    }

    public function getUserInfo($id, $user_fullname, $email) {
        try {
            $sql = 'SELECT user_fullname, email FROM user WHERE  id = :id AND user_fullname = :user_fullname AND email = :email';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':user_fullname', $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            /**
            * fetch = queryselect();
            * fetchAll = queryselectorAll();
            * FETCH_ASSOC :
            * $user[
            *   '$user_fullname' => 'teste',
            *   'email'=> 'teste@example.com'
            * ]
            * COMO OBTER INFORMAÇÕES:
            * $user['user_fullname'];
            */
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo 'Erro ao executar o comando' . $error->getMessage();
            return false;
        }
    }
}
?>