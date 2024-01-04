var first_id = '';
var first_email = '';

document.addEventListener("DOMContentLoaded", () => {


    //이메일 중복체크
    const btn_email_check = document.querySelector("#btn_email_check");
    btn_email_check.addEventListener("click", () => {
        const f_email = document.querySelector("#f_email")
        if (f_email.value == '') {
            alert("이메일을 입력해 주세요.");
            return false;
        }
        if (document.input_form.first_email.value == f_email.value) {
            alert('사용 가능한 이메일입니다.')
            return false;
        }

        //AJAX
        const f2 = new FormData();
        f2.append('email', f_email.value)
        f2.append('mode', 'email_chk')

        const xhr = new XMLHttpRequest()
        xhr.open("POST", "./pg/member_process.php", "true");
        xhr.send(f2);

        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.responseText)
                if (data.result == 'success') {
                    alert('사용 가능한 이메일입니다.');
                    document.input_form.email_chk.value = "1";
                    first_email = f_email.value;

                } else if (data.result == 'fail') {
                    alert("이미 사용중인 이메일입니다. 다른 이메일를 입력해 주세요.");
                    document.input_form.email_chk.value = "0";
                    f_email.value = '';
                    f_email.focus();
                } else if (data.result == 'empty_email') {
                    alert('이메일이 비어있습니다.');
                    f_email.focus();
                } else if (data.result == 'email_format_wrong') {
                    alert('이메일이 형식에 맞지 않습니다.');
                }
            }
        }
    });
    document.addEventListener("DOMContentLoaded", () => {

    });



    //가입 버튼 클릭시 
    const btn_submit = document.querySelector("#btn_submit");
    btn_submit.addEventListener("click", () => {
        const f = document.input_form


        if (f.name.value == '') {
            alert('이름을 입력해 주세요.');
            f.name.focus();
            return false;
        }
        // //비밀번호 여부 체크
        // if (f.pw1.value == '') {
        //     alert("비밀번호를 작성해주세요.");
        //     f.pw1.focus();
        //     return false;
        // }

        if (f.pw1.value != '') {
            //비밀번호2 여부 체크
            if (f.pw2.value == '') {
                alert("비밀번호 확인을 작성해주세요.");
                f.pw2.focus();
                return false;
            }

            //비밀번호 일치여부
            if (f.pw1.value != f.pw2.value) {
                alert("비밀번호가 일치하지 않습니다.");
                f.pw1.focus();
                return false;
            }
        }
        //기존 이메일과 같은지 확인
        if (f.email.value != f.first_email.value) {
           
            //이메일 입력 확인
            if (f.email_chk.value == '') {
                alert("이메일을 입력해주세요.");
                f.email.focus();
                return false;
            }
            //이메일 중복확인 여부 체크
            if (f.email_chk.value == 0 || f.email.value != first_email) {
                alert("이메일 중복체크를 다시해주세요.");
                f.email.focus();
                return false;
            }

        }

        //우편번호 입력확인
        if (f.zipcode.value == '') {
            alert("우편번호를 입력해 주세요.");
            return false;
        }
        //주소 입력확인
        if (f.addr1.value == '' || f.addr2.value == '') {
            alert("주소를 입력해 주세요.");
            return false;
        }

        f.submit();
        // alert("성공^^");
    })

    //우편번호 찾기

    const btn_zipcode = document.querySelector("#btn_zipcode")
    btn_zipcode.addEventListener("click", () => {
        new daum.Postcode({
            oncomplete: function (data) {
                console.log(data);
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
                // 예제를 참고하여 다양한 활용법을 확인해 보세요.
                if (data.userSelectedType == 'J') {
                    addr = data.jibunAddress
                } else if (data.userSelectedType == 'R') {
                    addr = data.roadAddress
                }

                const f_addr1 = document.querySelector("#f_addr1")
                const f_addr2 = document.querySelector("#f_addr2")
                const zipcode = document.querySelector("#zipcode")
                zipcode.value = data.zonecode;
                f_addr1.value = addr;
                f_addr2.focus();
            }
        }).open();
    })

    const f_photo = document.querySelector("#f_photo");
    f_photo.addEventListener("change", (e) => {

        const reader = new FileReader()//파일 내용을 핸들링 할 수 있게 해줌
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function (event) {
            // const img = document.createElement("img")
            // img.setAttribute("src", event.target.result)
            // document.querySelector("#f_preview").appendChild(img);

            const f_preview = document.querySelector("#f_preview");
            f_preview.setAttribute("src", event.target.result)
        }

        console.log(e);
    })


});