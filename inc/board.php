<?php

class Board
{
    private $conn;

    //생성자
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //글등록
    public function input($arr)
    {
        $sql = "INSERT into board(bcode, id, name, subject, content, files, ip, create_at) 
                value (:bcode, :id, :name, :subject, :content, :files, :ip, NOW())";
        $stmt = $this->conn->prepare($sql); //db커넥션 세팅
        $stmt->bindParam(":bcode", $arr['bcode']);       
        $stmt->bindParam(":id", $arr['id']);       
        $stmt->bindParam(":name", $arr['name']);       

        $stmt->bindParam(":subject", $arr['subject']);      
        $stmt->bindParam(":content", $arr['content']);       
        $stmt->bindParam(":files", $arr['files']);       

        $stmt->bindParam(":ip", $arr['ip']);       

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //index값 말고 필드명으로만 나오게끔F

    }
}