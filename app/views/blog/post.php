<?php
$blog = $data["blog"];
$post = $data["post"];
$author = $data["author"];
$sideMenuItems = $data['sideMenuItems'];
?>

<?php include('../app/templates/blog/head.php') ?>
<body>
<?php include('../app/templates/blog/header.php') ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../app/templates/blog/sidemenu.php') ?>
        <main class="col-md-8">
            <?php
            include_once '../app/templates/blog/post.php';
            ?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
<?php include('../app/templates/footer.php') ?>
</body>
