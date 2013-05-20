<?php defined("SYSPATH") or die("No direct script access.") ?>
<script type="text/javascript" src="<?= url::file("/modules/rebuild_items/js/jquery.tablesorter.min.js") ?>"></script>
<style type="text/css">
input.rebuild_text {
width: 250px;
background-color: white;
}
input.rebuild_number {
width: 50px;
background-color: white;
}
.g-rebuild-table {
  width: 800px;
}
.g-rebuild-table {
  border: 1px solid #f0f0f0;" 
}
.g-rebuild-table th {
	/* black (unsorted) double arrow */
	background-image: url(data:image/gif;base64,R0lGODlhFQAJAIAAACMtMP///yH5BAEAAAEALAAAAAAVAAkAAAIXjI+AywnaYnhUMoqt3gZXPmVg94yJVQAAOw==);
	background-repeat: no-repeat;
	background-position: center left;
	background-color: #D0E5F5;
	padding: 4px 18px 4px 20px;
	white-space: normal;
	cursor: pointer;
}
.sorter-false {
	background-image: none!important;
}
</style>
<h3><?= (t('Back to: <a href="%url">%img</a>', 
		array("img" => $item->title, "url" => $item->url()))); ?>
</h3>
<? if (count($photos) < 1) { 
  echo(t("There is no photos in this album.  Try sub-albums."));
  } else { ?>
<div id="g-admin-comment-block-block">
  <h2><?= t("Rebuild items administration") ?></h2>
  <p><?= t("This module acctually marks the items in the album as 'dirty' and Gallery will rebuild those items.<br>
			On some hosts with limited resources the image toolkit generating the thumbs and resizes fails.  <br>
			At this time Gallery can't detect this failure.<br>
			If some of your thumbs & resizes are full sized you can let this module detect the oversize items and have them marked for rebuilding.<br>
			This saves resoureses if some thumbs/resizes have already been generated properly.") ?></p>
  <?= $form ?>
</div>
<table class="g-rebuild-table g-rebuild-thumbs">
  <caption><h2><?= t("Thumbnail dimensions in this album") ?></h2></caption>
  <thead>
  <tr><th class="sorter-false"><?= t("Rebuild") ?></th><th><?= t("Title") ?></th>
  <th><?= t("DB dimensions") ?></th><th><?= t("File system dimensions") ?></th>
  </tr></thead>
  <tbody>
  <? foreach ($photos as $photo): ?>
	<tr class="<?= text::alternate("g-odd", "g-even") ?>">
	<td>
	  <form action="<?= url::site('admin/rebuild_items/single_handler?build_thumbs=1') ?>&item_id=<?= $photo->id ?>&album_id=<?= $album_id ?>" method="post">
	  <input name="csrf" type="hidden" value="<?= access::csrf_token(); ?>">
	  <input type="submit" value="<?= t("Rebuild") ?>" />
	  </form>
	</td>
	<td><a href="<?= $photo->abs_url() ?>"><?= $photo->title ?></a></td>
	<td><?= $photo->thumb_width ?> X <?= $photo->thumb_height ?></td>
	<? $imagedata = @getimagesize($photo->thumb_path()); ?>
	<td><?= $imagedata[0] ?> X <?= $imagedata[1] ?></td>
	</tr>
  <? endforeach ?>
  </tbody>
</table>
<table class="g-rebuild-table g-rebuild-resize">
  <caption><h2><?= t("Resize dimensions in this album") ?></h2><?= t("Movies do not have resized versions.") ?></caption>
  <thead>
  <tr><th class="sorter-false"><?= t("Rebuild") ?></th><th><?= t("Title") ?></th>
  <th><?= t("DB dimensions") ?></th><th><?= t("File system dimensions") ?></th>
  </tr></thead>
  <tbody>
  <? foreach ($photos as $photo): ?>
  <? if($photo->type != 'movie') : ?>
	<tr class="<?= text::alternate("g-odd", "g-even") ?>">
	<td>
	  <form action="<?= url::site('admin/rebuild_items/single_handler?build_resizes=1') ?>&item_id=<?= $photo->id ?>&album_id=<?= $album_id ?>" method="post">
	  <input name="csrf" type="hidden" value="<?= access::csrf_token(); ?>">
	  <input type="submit" value="<?= t("Rebuild") ?>" />
	  </form>
	</td>
	<td><a href="<?= $photo->abs_url() ?>"><?= $photo->title ?></a></td>
	<td><?= $photo->resize_width ?> X <?= $photo->resize_height ?></td>
	<? $imagedata = @getimagesize($photo->resize_path()); ?>
	<td><?= $imagedata[0] ?> X <?= $imagedata[1] ?></td>
	</tr>
  <? endif ?>
  <? endforeach ?>
  </tbody>
</table>
<script>
$(function(){
  $(".g-rebuild-table").tablesorter();
});
// Make checkboxes like radio buttons.  Forge does not have radio buttons.
$('input.g-unique').click(function() {
    $('input.g-unique:checked').not(this).removeAttr('checked');
});
// highlight the table with differing sizes
$(".g-rebuild-thumbs tbody tr").each(function () {
    if ($(this).find("td")[2].innerHTML != $(this).find("td")[3].innerHTML) {
        $(this).find("td")[0].bgColor = "orange";
    }
});
$(".g-rebuild-resize tbody tr").each(function () {
    if ($(this).find("td")[2].innerHTML != $(this).find("td")[3].innerHTML) {
        $(this).find("td")[0].bgColor = "orange";
    }
});
</script>
<? } ?>