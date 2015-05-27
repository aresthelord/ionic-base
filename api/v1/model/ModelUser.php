<?php

class ModelUser
{

    protected $id;

    protected $username;

    protected $email;

    protected $phone;

    protected $password;

    protected $token;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getToken()
    {
        return $this->token;
    }


    public function get($user, $db)
    {

        $sql = "SELECT uid,name, email, phone FROM users where name =:username and password =:password";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam('username', $user->username, PDO::PARAM_STR);
            $stmt->bindParam('password', $user->password, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            //echo '{"error":{"text":"'. $e->getMessage() .'"}}';
            throw $e;
            //serviceResponse(null, $error->getMessage());
        }
    }

    public function save($user, $db)
    {
        $sql = "INSERT INTO users (name, email, tel, password) VALUES (:username, :email, :phone, :password)";
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam('username', $user->username, PDO::PARAM_STR);
            $stmt->bindParam('email', $user->email, PDO::PARAM_STR);
            $stmt->bindParam('phone', $user->phone, PDO::PARAM_INT);
            $stmt->bindParam('password', $user->password, PDO::PARAM_STR);
            $stmt->execute();
            $user->id = $db->lastInsertId();
            return $user;
        } catch (PDOException $e) {
            //echo '{"error":{"text":"'. $e->getMessage() .'"}}';
            throw $e;
            //serviceResponse(null, $error->getMessage());
        }
    }


}