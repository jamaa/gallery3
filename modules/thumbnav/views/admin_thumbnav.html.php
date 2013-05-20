<?php defined("SYSPATH") or die("No direct script access.") ?>
<?
  $view = new View("admin_include.html");

  $view->is_module = TRUE;
  $view->name = "thumbnav";
  $view->form = $form;
  $view->help = $help;
  print $view;
?>
