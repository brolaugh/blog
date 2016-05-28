<?php
$backlink = $data['backlink'];
?>
<?php include('../app/templates/blog/head.php') ?>
<body>
<?php include('../app/templates/blog/header.php') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-8">
            <h1>Error 404</h1>
            <h2>Looks like you found a page that doesn't exist</h2>
            <p>Head back where you came from with this: <a href="<?= $backlink ?>">Link</a></p>
        </main>
    </div>


</div>
<?php include('../app/templates/footer.php') ?>
</body>
