
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
