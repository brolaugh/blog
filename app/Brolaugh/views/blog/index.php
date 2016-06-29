<?php

$blog = $data["blog"];
$posts = $data["posts"];
$author = $data["author"];
$sideMenuItems = $data['posts'];
$utility = $data['utility'];
?>

<?php include('../app/Brolaugh/templates/blog/head.php') ?>
<body>
<?php include('../app/Brolaugh/templates/blog/header.php') ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../app/Brolaugh/templates/blog/sidemenu.php') ?>
        <main class="col-md-8">
            <div id="posts">
                <?php
                foreach ($posts as $post) {
                    include '../app/Brolaugh/templates/blog/post.php';
                }
                ?>
            </div>
            <?php
            require_once '../app/Brolaugh/templates/pagination.php'
            ?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
<?php include('../app/Brolaugh/templates/footer.php') ?>
</body>
