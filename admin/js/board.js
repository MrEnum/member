document.addEventListener("DOMContentLoaded", () => {
    const btn_board_create = document.querySelector("#btn_board_create");
    const board_title = document.querySelector("#board_title");
    const board_mode = document.querySelector("#board_mode");

    btn_board_create.addEventListener("click", () => {
        if (board_title.value == "") {
            alert('게시판 이름을 입력해 주세요.')
            board_title.focus();
            return false;
        }

        btn_board_create.disabled = true;

        alert("이것이 처음이당꼐 : " + board_mode.value);
        const xhr = new XMLHttpRequest();
        const f = new FormData();
        f.append('board_title', board_title.value);
        f.append('board_type', document.querySelector("#board_type").value);
        f.append('mode', board_mode.value);
        f.append('idx', document.querySelector("#board_idx").value);


        xhr.open("POST", "./pg/board_process.php", true);
        xhr.send(f)
        xhr.onload = () => {
            if (xhr.status == 200) {
                console.log(xhr);
                const data = JSON.parse(xhr.responseText);
                if (data.result == 'mode_empty') {
                    alert('Mode 값이 누락되었습니다.');
                    btn_board_create.disabled = false;
                    return false;
                } else if (data.result == 'title_empty') {
                    alert('게시판 이름이 누락되었습니다.');
                    board_title.focus();
                    btn_board_create.disabled = false;
                    return false;
                } else if (data.result == 'btype_empty') {
                    alert('게시판 타입이 누락되었습니다.');
                    btn_board_create.disabled = false;
                    return false;
                } else if (data.result == 'success') {
                    alert('게시판이 생성되었습니다.');
                    self.location.reload();
                    return false;
                } else if (data.result == 'edit_success') {
                    alert('게시판이 수정되었습니다.');
                    self.location.reload();
                    return false;
                }
            } else {
                alert("통신 실패" + xhr.status);
            }
        }
    })



    //게시판 생성 버튼 클릭
    const board_create_modal = document.querySelector("#create_modal_open");
    board_create_modal.addEventListener("click", () => {
        board_title.value = '';
        board_mode.value = 'input';
        document.querySelector("#modalTitle").textContent = '게시판 생성'
    })
   

    //수정버튼 클릭
    const btn_mem_edit = document.querySelectorAll(".btn_mem_edit");
    btn_mem_edit.forEach((box) => {
        box.addEventListener("click", () => {
            const idx = box.dataset.idx;
            const board_mode = document.querySelector("#board_mode");
            board_mode.value = 'edit';
            const board_idx = document.querySelector("#board_idx");
            board_idx.value = idx;

            document.querySelector("#modalTitle").textContent = '게시판 수정'

            const f = new FormData()
            f.append('idx', idx);
            f.append('mode', "getInfo");

            const xhr = new XMLHttpRequest();

            xhr.open("POST", "./pg/board_process.php", true);
            xhr.send(f);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.responseText)
                    if (data.result == 'empty_idx') {
                        alert('idx값이 누락되었습니다.');
                        return false;
                    } else if (data.result == 'success') {
                        document.querySelector('#board_title').value = data.list.name;
                        document.querySelector('#board_type').value = data.list.btype;
                        board_mode.value = "edit";

                        board_idx.value = idx;
                    }
                } else {
                    alert('수정 실패');
                }
            }
        })
    })

    //삭제버튼 클릭
    const btn_mem_delete = document.querySelectorAll(".btn_mem_delete")
    btn_mem_delete.forEach((box) => {
        box.addEventListener("click", () => {

            if (!confirm('본 게시판을 삭제하시겟습니까?')) {
                return false;
            }
            const idx = box.dataset.idx;
            const xhr = new XMLHttpRequest();
            const f = new FormData()
            f.append('idx', idx);
            f.append('mode', "delete");


            xhr.open("POST", "./pg/board_process.php", true);
            xhr.send(f);
            xhr.onload = () => {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.responseText)
                    if (data.result = 'success') {
                        alert('게시판이 삭제 되었습니다.');
                        self.location.reload();
                    }
                } else {
                    alert('통신 실패');
                }
            }
        })
    })


})