<ul>
    <?php
    foreach ($data['blogs'] as $blog) {
        echo "<li><a href=\"$blog->name\">$blog->title</a></li>";
    }

    ?>


</ul>
