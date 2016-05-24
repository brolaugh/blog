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

  <?php include('../app/templates/blog/head.php')?>
<body>
<?php include('../app/templates/blog/header.php')?>
<div class="container-fluid">
    <div class="row">
        <?php include('../app/templates/blog/sidemenu.php')?>
        <main class="col-md-8">
            <?php
            foreach($posts as $post){
                include '../app/templates/blog/post.php';
            }
            ?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
    <?php include('../app/templates/footer.php') ?>
</body>
