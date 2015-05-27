<?php

class ModelMessage {
	
	protected $id ;
	
	protected $username;
	
	protected $email;
	
	protected $phone;
	
	protected $message;
	
	public function setId($id){
		$this->id = $id;
	}
	public function setUsername($username){
		$this->username = $username;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function setPhone($phone){
		$this->phone = $phone;
	}
	public function setMessage($message){
		$this->message = $message;
	}
	
	public function getId(){
		return $this->id ;
	}
	public function getUsername(){
		return $this->username ;
	}
	public function getEmail(){
		return $this->email ;
	}
	public function getPhone(){
		return $this->phone ;
	}
	public function getMessage(){
		return $this->message ;
	}
	
	public function filterByRange($begin = 0, $end = 10 ,$db) {
		$sql = "SELECT id,name, email, tel, message FROM messages  LIMIT :begin , :end ";
    try { 
		$begin = (int) $begin;
		$end = (int) $end;
		$stmt = $db->prepare($sql);
        $stmt->bindParam(':begin',  $begin, PDO::PARAM_INT);
        $stmt->bindParam(':end',  $end, PDO::PARAM_INT);
		$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    } catch(PDOException $e) {
        throw $e;
        
    }
	}
	
	public function getAll($db) {
		$sql = "SELECT id,name, email, tel, message FROM messages ";
    try {
        
        $stmt = $db->prepare($sql);
       $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    } catch(PDOException $e) {
       throw $e;
     }
	}
	public function get($id , $db) {
		$sql = "SELECT id,name, email, tel, message FROM messages where id =:id";
    try {
        
        $stmt = $db->prepare($sql);
		$stmt->bindParam('id', $id, PDO::PARAM_INT);
		$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    } catch(PDOException $e) {
        //echo '{"error":{"text":"'. $e->getMessage() .'"}}';
		throw $e;
        //serviceResponse(null, $error->getMessage());
    }
	}
	public function filterByName($name , $db) {
		$sql = "SELECT id,name, email, tel, message FROM messages WHERE MATCH (name,message)  AGAINST (:name IN BOOLEAN MODE)";
    try {
        
		$stmt = $db->prepare($sql);
		$stmt->bindParam('name', $name, PDO::PARAM_STR);
		
		$stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    } catch(PDOException $e) {
        
		throw $e;
        
    }
	}
	
	public function save($post , $db) {
		 $sql = "INSERT INTO messages (name, email, tel, message) VALUES (:username, :email, :phone, :message)";
    try {
		$stmt = $db->prepare($sql);
        $stmt->bindParam('username', $post->username, PDO::PARAM_STR);
        $stmt->bindParam('email', $post->email, PDO::PARAM_STR);
        $stmt->bindParam('phone', $post->phone ,PDO::PARAM_INT);
        $stmt->bindParam('message', $post->message, PDO::PARAM_STR);
        $stmt->execute();
        $post->id = $db->lastInsertId();
		return $post;
	} catch(PDOException $e) {
        //echo '{"error":{"text":"'. $e->getMessage() .'"}}';
		throw $e;
        //serviceResponse(null, $error->getMessage());
    }
	}
	
	
}