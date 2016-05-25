<div class="well well-sm" id="<?=$post->url_title?>">
  <h1><?=$post->title?></h1>
  <div>
    <?=$post->content?>
  </div>

  <div class="">
      <?php
        foreach($post->tags as $t) {
          echo "<a href=\"/$blog->name/tag/$t\"><span class=\"label label-muted\">$t</span></a>";
        }
      ?>
  </div>
</div>

