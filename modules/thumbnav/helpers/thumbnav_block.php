<?php defined("SYSPATH") or die("No direct script access.");

class ThumbNav_block_Core {

  static function get_site_list() {
    return array("thumbnav_block" => t("Navigator"));
  }

  static function get($block_id, $theme) {
    $block = "";
    switch ($block_id) {
      case "thumbnav_block":
        $item = $theme->item;
        if ((!isset($item)) or (!$item->is_photo())): // Only should be used in photo pages
          break;
        endif;

        $hide_albums = module::get_var("thumbnav", "hide_albums", TRUE);

        $siblings = $item->parent()->children();
        $itemlist = Array();
        foreach ($siblings as $sibling):
	        if (isset($sibling)):
            if ($sibling->viewable()):
		          if (($hide_albums and ($sibling->is_photo())) or (!$hide_albums)):
			          $itemlist[] = $sibling;
			        endif;
		        endif;
	        endif;
	      endforeach;

        $current = -1;
        $total = count($itemlist);

        $thumb_count = module::get_var("thumbnav", "thumb_count", 9);
        $thumb_count = min($thumb_count, $total);

        $shift_right = floor($thumb_count / 2);
        $shift_left = $thumb_count - $shift_right - 1;

        for ($i = 1; $i <= $total; $i++):
          if ($itemlist[$i-1]->rand_key == $item->rand_key):
            $current = $i;
            break;
          endif;
        endfor;

  	    $content = '<ul>';
        if ($current >= 1):
          $first = $current - $shift_left;
          $last = $current + $shift_right;
          if ($first <= 0):
            $last = min($last - $first + 1, $total);
            $first = 1;
          elseif ($last > $total):
            $first = max($first - ($last - $total), 1);
            $last = $total;
          endif;

          for ($i = $first; $i <= $last; $i++):
            $thumb_item = $itemlist[$i - 1];

	          if ($i == $current):                                
  	          $content .= '<li class="g-current">';
	          else:
  	          $content .= '<li>';
	          endif;
  	        $content .= '<a href="' . $thumb_item->url() . '" title="' . html::purify($thumb_item->title) . '" target="_self">';
	          $content .= $thumb_item->thumb_img(array("class" => "g-navthumb"), 60);         
  	        $content .= '</a></li>';
          endfor; 
        endif;

        $content .= "</ul>";
        $content .= "<div style=\"clear: both;\"></div>";

        $block = new Block();
        $block->css_id = "g-thumbnav-block";
        $block->title = t("Navigator");
        $block->content = new View("thumbnav_block.html");
        $block->content->player = $content;
        break;
    }

    return $block;
  }
}

?>