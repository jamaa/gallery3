<?php defined("SYSPATH") or die("No direct script access.");
class thumbnav_event_Core {

  static function activate() {
    thumbnav::check_config();
  }

  static function deactivate() {
    site_status::clear("thumbnav_config");
  }

  static function admin_menu($menu, $theme) {
    $menu
      ->get("settings_menu")
      ->append(Menu::factory("link")
               ->id("thumbnav")
               ->label(t("Thumb Navigator"))
               ->url(url::site("admin/thumbnav")));
  }
}
