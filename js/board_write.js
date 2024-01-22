function getUrlParams() {
    const params = {};

    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,
        function (str, key, value) {
            params[key] = value;
        }
    );
    return params;
}


document.addEventListener("DOMContentLoaded", () => {

    //목록버튼 클릭
    const btn_board_list = document.querySelector("#btn_board_list");
    btn_board_list.addEventListener("click", () => {
        const params = getUrlParams();
        self.location.href = './board.php?bcode=' + params['bcode'];
    });

    //확인 버튼 클릭
    const btn_write_submit = document.querySelector("#btn_write_submit");
    btn_write_submit.addEventListener("click", () => {
        const id_subject = document.querySelector("#id_subject");
        //validate
        if(id_subject.value == ''){
            alert("제목을 입력해주세요.");
            id_subject.focus();
            return false;
        }
        const markupStr = $('#summernote').summernote('code');
        if(markupStr== '<p><br></p>'){
            alert("내용을 입력해주세요.");
            return false;
        }

        // 파일 첨부
        const id_attach = document.querySelector("#id_attach");
        const file = id_attach.files[0];

     
        //
        const params = getUrlParams();
       
        const f = new FormData();
        f.append("subject", id_subject.value)   //게시글 제목
        f.append("content", markupStr)          //게시글 내용
        f.append("bcode", params['bcode']);     //게시판 코드
        f.append("mode", "input");              //모드 : 글등록
        // f.append("files", file)                 //파일첨부
        for(const file of id_attach.files) {
            f.append("files[]", file);
        }

        const xhr = new XMLHttpRequest();
        xhr.open("post", "./pg/board_process.php", "true");
        
        xhr.send(f);
        xhr.onload = ()=>{
            if(xhr.status == 200){
                console.log(xhr.responseText);
                const data= JSON.parse(xhr.responseText);
             
                if(data.result =="success"){
                    alert("등록 완료");
                    self.location.href='./board.php?bcode=' + params['bcode']
                }
            }else if(xhr.status == 404){
                alert('통신실패')
            }

        }
    });

})