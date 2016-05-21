<div class="well well-sm">
  <h3><?=$post->title?></h3>
  <div>
    <?=$post->content?>
  </div>

  <div class="">
      <?php
        foreach($post->tags as $t) {
          echo "<a href=\"/brolaugh/tag/$t\"><span class=\"label label-muted\">$t</span></a>";
        }
      ?>
  </div>
</div>

