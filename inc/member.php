<?php
//Member Class file

class Member
{
    private $conn;

    //생성자
    public function __construct($db)
    {
        $this->conn = $db;
    }
    //아이디 중복체크용 멤버 함수, 메소드
    public function id_exists($id)
    {
        $sql = "SELECT * FROM member WHERE  id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->rowCount() ? true : false;
    }
    //이메일 중복확인
    public function email_exists($email)
    {
        $sql = "SELECT * FROM member WHERE  email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->rowCount() ? true : false;
    }

    //회원정보 입력
    public function input($marray)
    {
        $sql = "INSERT INTO member(id, name, password, email, zipcode, addr1, addr2, photo, create_at, ip) VALUES
        (:id, :name, :password, :email, :zipcode, :addr1, :addr2, :photo, NOW(), :ip)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $marray['id']);
        $stmt->bindParam(":name", $marray['name']);
        $stmt->bindParam(":password", $marray['password']);
        $stmt->bindParam(":email", $marray['iemaild']);
        $stmt->bindParam(":zipcode", $marray['zipcode']);
        $stmt->bindParam(":addr1", $marray['addr1']);
        $stmt->bindParam(":addr2", $marray['addr2']);
        $stmt->bindParam(":photo", $marray['photo']);
        $stmt->bindParam(":ip", $_SERVER['REMOTE_ADDR']);


        $stmt->execute();
        return $stmt->rowCount() ? true : false;

    }

    //이메일 형식 체크
    public function email_format_check($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //로그인
    public function login($id, $pw){
        $sql = 'SELECT * FROM member where id=:id and password= :password';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":password", $pw);
        $stmt->execute();

        return $stmt->rowCount() ? true : false;
    }
}