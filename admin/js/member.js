document.addEventListener("DOMContentLoaded", () => {
    const btn_search = document.querySelector("#btn_search")
    btn_search.addEventListener("click", () => {
        const sf = document.querySelector("#sf")
        if (sf.value == '') {

            alert("검색어를 입력해주세요.");
            return false;
        }
        const sn = document.querySelector("#sn")
        self.location.href = './member.php?sn=' + sn.value + '&sf=' + sf.value;
    })

    const btn_all = document.querySelector("#btn_all");
    btn_all.addEventListener("click", () => {
        self.location.href = './member.php';

    });
    //엑셀로 저장
    const btn_excel = document.querySelector("#btn_excel");
    btn_excel.addEventListener("click", () => {
        self.location.href = './member_to_excel.php';

    })
})