<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class Photos_Controller extends Items_Controller {

  /**
   *  @see Rest_Controller::_show($resource)
   */
  public function _show($item) {
    $template = new View("page.html");

    // @todo: this needs to be data-driven
    $theme = new Theme("default", $template);

    $template->set_global("page_type", "photo");
    $template->set_global('item', $item);
    $template->set_global('children', $item->children());
    $template->set_global('children_count', $item->children_count());
    $template->set_global('parents', $item->parents());
    $template->set_global('theme', $theme);
    $template->set_global('user', Session::instance()->get('user', null));
    $template->content = new View("photo.html");

    print $template;
  }
}
