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

        //단방향 암호화
        $new_hash_password = password_hash($marray["password"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO member(id, name, password, email, zipcode, addr1, addr2, photo, create_at, ip) VALUES
        (:id, :name, :password, :email, :zipcode, :addr1, :addr2, :photo, NOW(), :ip)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $marray['id']);
        $stmt->bindParam(":name", $marray['name']);
        $stmt->bindParam(":password", $new_hash_password);
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
    public function email_format_check($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //로그인
    public function login($id, $pw)
    {

        //password_verify($password, $new_password)
        $sql = 'SELECT password FROM member where id=:id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if (password_verify($pw, $row["password"])) {
                $sql = "UPDATE member SET login_dt=NOW() WHERE id=:id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }


        // return $stmt->rowCount() ? true : false;
    }

    public function logout(){
        session_Start();
        session_destroy();

        die('<script>self.location.href="../index.php";</script>');
    }
}