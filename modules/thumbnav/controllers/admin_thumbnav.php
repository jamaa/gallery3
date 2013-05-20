<?php defined("SYSPATH") or die("No direct script access.");

class Admin_thumbnav_Controller extends Admin_Controller {

  public function index() {
    $view = new Admin_View("admin.html");
    $view->content = new View("admin_thumbnav.html");
    $view->content->form = $this->_get_setting_form();
    $view->content->help = $this->get_edit_form_help();
    print $view;
  }

  public function save() {
    access::verify_csrf();

    $form = $this->_get_setting_form();
    if ($form->validate()):
      $thumb_count = $form->g_admin_thumbnavcfg->thumb_count->value;
      if ($thumb_count==9):
        module::clear_var("thumbnav", "thumb_count");
      else:
        module::set_var("thumbnav", "thumb_count", $thumb_count);
      endif;
      if ($form->g_admin_thumbnavcfg->hidealbum->value):
        module::set_var("thumbnav", "hide_albums", TRUE);
      else:
        module::clear_var("thumbnav", "hide_albums");
      endif;

      message::success("Settings have been Saved.");
      url::redirect("admin/thumbnav");
    endif;

    $view = new Admin_View("admin.html");
    $view->content = new View("admin_thumbnav.html");
    $view->content->form = $form;
    $view->content->help = $this->get_edit_form_help();
    print $view;
  }

  private function _get_setting_form() {
    $form = new Forge("admin/thumbnav/save", "", "post", array("id" => "g-admin-thumbnav-form"));
    $group = $form->group("g_admin_thumbnavcfg")->label(t("Settings"));
    $group->input("thumb_count")
      ->label(t("Thumbs displayed"))
      ->rules("required|valid_digit")
      ->value(module::get_var("thumbnav", "thumb_count", 9));
    $group->checkbox("hidealbum")->label(t("Hide Albums in the list"))
      ->checked(module::get_var("thumbnav", "hide_albums"));
    $form->submit("")->value(t("Save"));
    return $form;
  }

  protected function get_edit_form_help() {
    $help = '<fieldset>';
    $help .= '<legend>Help</legend><ul>';
    $help .= '<li><h3>Settings</h3>
      <p>Adjust Max Number of images in the block using <b>Thumbs displayed</b>. Default is 9. 
      </li>';

    $help .= '</ul></fieldset>';
    return t($help);
  }

}
