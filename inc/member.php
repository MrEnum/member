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
        $stmt->bindParam(":email", $marray['email']);
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
            } else {
                return false;
            }
        } else {
            return false;
        }


        // return $stmt->rowCount() ? true : false;
    }

    public function logout()
    {
        session_Start();
        session_destroy();

        die('<script>self.location.href="../index.php";</script>');
    }

    public function getInfoFromIdx($idx)
    {
        $sql = "SELECT * FROM member WHERE  idx=:idx";
        $stmt = $this->conn->prepare($sql); //db커넥션 세팅
        $stmt->bindParam(":idx", $idx);       //파라미터 바인딩
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //index값 말고 필드명으로만 나오게끔

        $stmt->execute();
        return $stmt->fetch();
    }



    public function getInfo($id)
    {
        $sql = "SELECT * FROM member WHERE  id=:id";
        $stmt = $this->conn->prepare($sql); //db커넥션 세팅
        $stmt->bindParam(":id", $id);       //파라미터 바인딩
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //index값 말고 필드명으로만 나오게끔

        $stmt->execute();
        return $stmt->fetch();
    }


    public function edit($marray)
    {

        $sql = "UPDATE member SET 
                name    =:name, 
                email   =:email, 
                zipcode =:zipcode, 
                addr1   =:addr1, 
                addr2   =:addr2,
                photo   =:photo";

        $params = [

            ":name" => $marray['name'],
            ":email" => $marray['email'],
            ":zipcode" => $marray['zipcode'],
            ":addr1" => $marray['addr1'],
            ":addr2" => $marray['addr2'],
            ":photo" => $marray['photo']

        ];
        if ($marray["password"] != '') {
            //단방향 암호화
            $new_hash_password = password_hash($marray["password"], PASSWORD_DEFAULT);
            $sql .= ", password=:password";
            $params[':password'] = $new_hash_password;

        }
        if ($_SESSION['ses_level'] == 10 && isset($marray['idx']) && $marray['idx'] != '') {
            $params[':level'] = $marray['level'];
            $params[':idx'] = $marray['idx'];
            $sql .= ", level=:level";
            $sql .= " WHERE idx=:idx";
        } else {
            $params[':id'] = $marray['id'];
            $sql .= " WHERE id=:id";
        }

        print_r($sql);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    //리스트
    public function list($page, $limit, $paramArr)
    {
        $start = ($page - 1) * $limit;
        $where = '';
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'name';
                    break;
                case 2:
                    $sn_str = 'id';
                    break;
                case 3:
                    $sn_str = 'email';
                    break;
            }
            $where = ' WHERE ' . $sn_str . " like :sf ";
        }


        $sql = "SELECT 
                idx, id, name, email, DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') create_at
                     from member " . $where . " 
                     ORDER BY idx DESC LIMIT " . $start . ", " . $limit; //1페이지면 0
        $stmt = $this->conn->prepare($sql);
        if ($where != '') {
            $paramArr['sf'] = '%' . $paramArr['sf'] . '%';
            $stmt->bindParam(':sf', $paramArr['sf']);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //column으로 key가 매핑되게 가져오는 형식
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //리스트 갯수 조회
    public function total($paramArr)
    {
        $where = '';
        if ($paramArr['sn'] != '' && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1:
                    $sn_str = 'name';
                    break;
                case 2:
                    $sn_str = 'id';
                    break;
                case 3:
                    $sn_str = 'email';
                    break;
            }
            $where = ' WHERE ' . $sn_str . " like :sf ";
        }


        $sql = "SELECT COUNT(*) cnt from member " . $where;
        $stmt = $this->conn->prepare($sql);
        if ($where != '') {
            $paramArr['sf'] = '%' . $paramArr['sf'] . '%';
            $stmt->bindParam(':sf', $paramArr['sf']);
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC); //column으로 key가 매핑되게 가져오는 형식
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['cnt'];
    }

    //회원전체 조회
    public function getAllData()
    {
        $sql = "SELECT * from member ORDER BY idx DESC"; //1페이지면 0
        $stmt = $this->conn->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC); //column으로 key가 매핑되게 가져오는 형식
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //회원삭제
    public function member_del($idx)
    {
        $sql = "DELETE FROM member WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idx", $idx);
        $stmt->execute();
    }

    //프로필 이미지 업로드
    public function profile_upload($id, $new_photo, $old_photo = '')
    {
        //이미지 update 시 삭제
        if ($old_photo != '') {
            echo'<script> alert("원래 사진이 있으면 지워죠.");</script>';
            unlink(PROFILE_DIR . "/". $old_photo);
        }

        //profile image 처리
        $temparr = explode('.', $new_photo['name']);    // ['2','jpg']
        $ext = end($temparr);    // ['2','jpg']
        $photo = $id . '.' . $ext;
        $old_photo = $photo;
        copy($new_photo['tmp_name'], PROFILE_DIR . "/" . $photo);
        echo'<script> alert("사진저장완료");</script>';
        return $photo;
    }


}