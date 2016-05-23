<aside class="col-md-2">
    <div class="well">
        <h4 class="text-primary">Post index</h4>
        <ul class="list">
            <?php
            foreach($posts as $post){
                echo "<li><a href='#$post->url_title'>$post->title</a></li>";
            }
            ?>
        </ul>
    </div>
</aside>