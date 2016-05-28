<?php

$blog = $data["blog"];
$posts = $data["posts"];
$author = $data["author"];
$sideMenuItems = $data['posts'];
$utility = $data['utility'];
?>

<?php include('../app/templates/blog/head.php') ?>
<body>
<?php include('../app/templates/blog/header.php') ?>
<div class="container-fluid">
    <div class="row">
        <?php include('../app/templates/blog/sidemenu.php') ?>
        <main class="col-md-8">
            <div id="posts">
                <?php
                foreach ($posts as $post) {
                    include '../app/templates/blog/post.php';
                }
                ?>
            </div>
            <?php
            require_once '../app/templates/pagination.php'
            ?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
<?php include('../app/templates/footer.php') ?>
</body>
