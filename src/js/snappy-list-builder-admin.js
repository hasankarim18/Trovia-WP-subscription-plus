// wait until the page and jQuery have loaded before running the code below
jQuery(document).ready(function ($) {
  // stop our admin menus from collapsing
  if (
    $('body[class*=" twsp_"]').length ||
    $('body[class*=" post-type-twsp_"]').length
  ) {
    $slb_menu_li = $("#toplevel_page_twsp_dashboard_admin_page");

    $slb_menu_li
      .removeClass("wp-not-current-submenu")
      .addClass("wp-has-current-submenu")
      .addClass("wp-menu-open");

    $("a:first", $slb_menu_li)
      .removeClass("wp-not-current-submenu")
      .addClass("wp-has-submenu")
      .addClass("wp-has-current-submenu")
      .addClass("wp-menu-open");
  }
});
