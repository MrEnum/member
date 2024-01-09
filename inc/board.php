<?php
//게시판 관리 클래스
class Board
{
    private $conn;

    //생성자
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //게시글 리스트
    public function list()
    {
        $sql = "SELECT 
                 idx, name, bcode, btype, cnt, DATE_FORMAT(create_at,'%Y-%m-%d %H:%i') create_at
                      from board_manage 
                      ORDER BY idx ASC ";
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC); //column으로 key가 매핑되게 가져오는 형식
        $stmt->execute();
        return $stmt->fetchAll();
    }

}