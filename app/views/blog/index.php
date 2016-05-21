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
<header class="container-fluid">
    <div class="col-md-12 col-lg-12">
        <div class="jumbotron">
            <img src="http://demo.qodeinteractive.com/central/wp-content/uploads/2013/05/header.jpg" width="100%" alt="" class=""/>
        </div>
    </div>

</header>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2">
            <div class="well">
                <h5 class="text-primary">Tags</h5>
                <ul class="list-unstyled">
                    <li>Test</li>
                    <li>Test</li>
                    <li>Test</li>
                    <li>Test</li>
                    <li>Test</li>
                    <li>Test</li>
                </ul>

            </div>
        </aside>
        <main class="col-md-8">
            Main
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
<footer class="container-fluid">

</footer>
</body>

