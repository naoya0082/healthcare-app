$(function () {
  // 削除確認
  $(".del").click(() => {
    const result = confirm("本当に削除しますか？");
    if (!result) {
      return false;
    }
  });
  // プロフィール確認or編集切り替え
  $(".edit").click(function () {
    $(".show_profile").addClass("display");
    $(".update_profile").removeClass("update");
  });
  // ログアウト確認
  $(".logout").click(() => {
    const result = confirm("ログアウトしますか？");
    if (!result) {
      return false;
    }
  });
  // class="on" 追加
  $(".hamburger").click(function () {
    $(".hamburger").toggleClass("on");
    $("#container").toggleClass("on");
  });
  // 新規メニュー追加確認
  $(".add-menubtn").click(() => {
    const result = confirm("メニューを追加しますか？");
    if (!result) {
      return false;
    }
  });
});
