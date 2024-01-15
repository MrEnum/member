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
        $sql = "INSERT into board(bcode, id, name, subject, content, ip, create_at) 
                value (:bcode, :id, :name, :subject, :content, :ip, NOW())";
        $stmt = $this->conn->prepare($sql); //db커넥션 세팅
        $stmt->bindParam(":bcode", $arr['bcode']);       //파라미터 바인딩
        $stmt->bindParam(":id", $arr['id']);       //파라미터 바인딩
        $stmt->bindParam(":name", $arr['name']);       //파라미터 바인딩

        $stmt->bindParam(":subject", $arr['subject']);       //파라미터 바인딩
        $stmt->bindParam(":content", $arr['content']);       //파라미터 바인딩
        $stmt->bindParam(":ip", $arr['ip']);       //파라미터 바인딩

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //index값 말고 필드명으로만 나오게끔F

    }
}