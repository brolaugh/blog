<?php
/**
 * Created by IntelliJ IDEA.
 * User: Brolaugh
 * Date: 2016-05-20
 * Time: 20:44
 */
$blog = $data["blog"];
$author = $data["author"];
?>

<?php include('../app/templates/blog/head.php')?>
<body>
<?php include('../app/templates/blog/header.php')?>
<div class="container-fluid">
    <div class="row">
        <?php include('../app/templates/blog/sidemenu.php')?>
        <main class="col-md-8">
            <?php include('../app/templates/blog/compose.php')?>
        </main>
        <aside class="col-md-2">
            Ads
        </aside>
    </div>


</div>
<footer class="container-fluid">
    <script src="js/jquery.min.js" charset="utf-8"></script>
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/material.min.js" charset="utf-8"></script>
    <script src="js/ripples.min.js" charset="utf-8"></script>
</footer>
</body>