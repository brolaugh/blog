<?php
/**
 * Created by IntelliJ IDEA.
 * User: Brolaugh
 * Date: 2016-05-20
 * Time: 20:44
 */
$blog = $data["blog"];
$author = $data["author"];
$post = $data['post'];
$unPublishedPosts = $data['unpublishedPosts'];
$utility = $data['utility'];
?>

<?php include('../app/Brolaugh/templates/blog/head.php') ?>
<body>
<?php include('../app/Brolaugh/templates/blog/header.php') ?>
<div class="container-fluid">
    <div class="row">
        <!--Switch out for list of non published and draft posts-->
        <?php include('../app/Brolaugh/templates/blog/compose/sidemenu.php') ?>
        <main class="col-md-8">
            <?php include('../app/Brolaugh/templates/blog/compose.php') ?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
<?php include('../app/Brolaugh/templates/footer.php') ?>
</body>
