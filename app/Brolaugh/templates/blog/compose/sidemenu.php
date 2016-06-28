<aside class="col-md-2">
    <div class="well">
        <h4 class="text-primary">Posts in Draft</h4>
        <ul class="list">
            <?php
            foreach ($unPublishedPosts as $post) {
                echo "<li><a href='javascript:loadPost( $post->name )'>$post->title</a></li>";
            }
            ?>
        </ul>
    </div>
</aside>