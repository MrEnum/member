console.log("실행");
//dom이 로딩이 다 된 다음에 안에 부분을 실행
document.addEventListener("DOMContentLoaded", ()=>{
    const btn_login = document.querySelector("#btn_login");

    btn_login.addEventListener("click", ()=>{
        self.location.href='./login.php'
    })
})