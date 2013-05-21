<?php defined("SYSPATH") or die("No direct script access.") ?>
<? foreach ($items as $item): ?>
<div class="g-image-block">
<? 
if ($item->type == "movie") {
	echo $theme->thumb_top($item);
}
?>
  <a href="<?= url::site("image_block/random/" . $item->id); ?>">
   <?= $item->thumb_img(array("class" => "g-thumbnail")) ?>
  </a>
<? 
if ($item->type == "movie") {
	echo $theme->thumb_bottom($item);
}
?>
</div>
<? endforeach ?>
