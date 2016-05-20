<?php
/**
 * Created by IntelliJ IDEA.
 * User: Brolaugh
 * Date: 2016-05-20
 * Time: 20:44
 */
$blog = $data["blog"];
$posts = $data["posts"];
$author = $data["author"];
?>

  <?=include('../app/templates/head.php');?>
<body>
    <header>

    </header>
    <aside>

    </aside>
    <main>
        <?php
        foreach($posts as $post){
            include '../app/templates/blog/post.php';
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

