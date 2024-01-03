<?php

$js_array = ['js/member.js'];
$menu_code = 'member';
include 'inc_header.php';
?>

<main class="p-5 border rounded-5">
  <h1 class="text-center "> 회원 약관 및 개인정보 취급 방침 동의</h1>
  <h4>회원 약관</h4>
  <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium similique, eveniet nobis libero iure, adipisci tenetur sequi iusto reprehenderit perspiciatis ut temporibus quia omnis at repellendus velit, quos in unde ipsa hic nam. Reiciendis aspernatur fugiat itaque, molestiae praesentium fugit autem odit ipsam veritatis mollitia saepe totam magnam quia voluptate cum nesciunt officiis aliquam repudiandae quod ducimus, maiores laborum? Nesciunt, natus quidem libero minima, quos necessitatibus cumque, dolorum hic mollitia voluptatum commodi a iste itaque. Quas modi inventore cum blanditiis accusantium sit perferendis corrupti, eius amet nulla, illum quia laudantium nam temporibus. Nihil ipsum odio sed, hic consectetur sapiente at nesciunt quae ullam officia eveniet illo cumque praesentium eaque assumenda sint autem minus maxime saepe. Dolorem minus nostrum, voluptates hic voluptatem alias eius rerum fugiat nesciunt. Dolorum odit blanditiis perspiciatis eos reprehenderit minus alias debitis ab ipsa voluptas facere eius ullam praesentium at repellat aliquid, incidunt vel natus deserunt dicta dolorem? Iure perferendis consectetur voluptatum laudantium ipsa, vitae dicta aperiam mollitia possimus deleniti ullam tenetur veniam accusamus a non consequatur magnam eum earum qui voluptas repellat. Libero itaque deleniti dolores ex assumenda, necessitatibus sunt veritatis. Iusto sapiente magnam, vel cupiditate, nobis enim sunt similique ipsum cum autem nostrum facilis non ratione magni ea tenetur officiis! Explicabo expedita dolorum cupiditate necessitatibus obcaecati facilis, dolore ab libero exercitationem officiis quas aliquid aperiam qui consectetur ullam quibusdam nisi molestias? Beatae laborum ad repellendus a est rem voluptates suscipit! Iste facilis quis sint illum error perspiciatis in, quia tenetur, repellendus vel, animi ab? Iste natus quod iure consectetur laboriosam quos dignissimos ducimus, non fugiat! Consectetur ut totam iusto omnis accusantium at enim repellat minus. Aliquam magnam minus corporis et, nulla repellendus laudantium odit illum numquam accusamus ipsa, animi possimus! Ab maxime commodi culpa tempore velit, tenetur quos obcaecati, quasi reiciendis quam error illo provident?
      </textarea>


  <div class="form-check mt-2">
    <input class="form-check-input" type="checkbox" value="1" id="chk_member1">
    <label class="form-check-label" for="flexCheckDefault">
      위 약관에 동의하시겠습니까?
    </label>
  </div>

  <h4 class="mt-3">개인정보 취급방침</h4>
  <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium similique, eveniet nobis libero iure, adipisci tenetur sequi iusto reprehenderit perspiciatis ut temporibus quia omnis at repellendus velit, quos in unde ipsa hic nam. Reiciendis aspernatur fugiat itaque, molestiae praesentium fugit autem odit ipsam veritatis mollitia saepe totam magnam quia voluptate cum nesciunt officiis aliquam repudiandae quod ducimus, maiores laborum? Nesciunt, natus quidem libero minima, quos necessitatibus cumque, dolorum hic mollitia voluptatum commodi a iste itaque. Quas modi inventore cum blanditiis accusantium sit perferendis corrupti, eius amet nulla, illum quia laudantium nam temporibus. Nihil ipsum odio sed, hic consectetur sapiente at nesciunt quae ullam officia eveniet illo cumque praesentium eaque assumenda sint autem minus maxime saepe. Dolorem minus nostrum, voluptates hic voluptatem alias eius rerum fugiat nesciunt. Dolorum odit blanditiis perspiciatis eos reprehenderit minus alias debitis ab ipsa voluptas facere eius ullam praesentium at repellat aliquid, incidunt vel natus deserunt dicta dolorem? Iure perferendis consectetur voluptatum laudantium ipsa, vitae dicta aperiam mollitia possimus deleniti ullam tenetur veniam accusamus a non consequatur magnam eum earum qui voluptas repellat. Libero itaque deleniti dolores ex assumenda, necessitatibus sunt veritatis. Iusto sapiente magnam, vel cupiditate, nobis enim sunt similique ipsum cum autem nostrum facilis non ratione magni ea tenetur officiis! Explicabo expedita dolorum cupiditate necessitatibus obcaecati facilis, dolore ab libero exercitationem officiis quas aliquid aperiam qui consectetur ullam quibusdam nisi molestias? Beatae laborum ad repellendus a est rem voluptates suscipit! Iste facilis quis sint illum error perspiciatis in, quia tenetur, repellendus vel, animi ab? Iste natus quod iure consectetur laboriosam quos dignissimos ducimus, non fugiat! Consectetur ut totam iusto omnis accusantium at enim repellat minus. Aliquam magnam minus corporis et, nulla repellendus laudantium odit illum numquam accusamus ipsa, animi possimus! Ab maxime commodi culpa tempore velit, tenetur quos obcaecati, quasi reiciendis quam error illo provident?
    </textarea>


  <div class="form-check mt-2">
    <input class="form-check-input" type="checkbox" value="1" id="chk_member2">
    <label class="form-check-label" for="flexCheckDefault">
      위 개인정보 취급방침에 동의하시겠습니까?
    </label>
  </div>
  <div class="mt-4 d-flex justify-content-center gap-2">
    <button class="btn btn-primary  w-50" id="btn_member">회원가입</button>
    <button class="btn btn-secondary w-50">가입취소</button>
  </div>
  <form method="post" name="stipulation_form" action="member_input.php" style="display:none">
    <input type="hidden" name="chk" value="0">

</main>
<?php include 'inc_footer.php'; ?>