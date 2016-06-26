<div class="well well-sm" id="<?= $post->url_title ?>">
    <h1> <a href="/<?=$blog->name?>/post/<?=$post->url_title?>"><?= $post->title ?></a></h1>
    <div>
        <?= $post->content ?>
    </div>
    <p><strong>Published on </strong><span class="text-info"><?=$post->publishing_time?></span></p>
    <div class="">
        <?php
        foreach ($post->tags as $t) {
            echo "<a href=\"/$blog->name/tag/$t\"><span class=\"label label-muted\">$t</span></a>";
        }
        ?>
    </div>
</div>

