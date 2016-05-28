<head>
    <meta charset="utf-8"/>
    <meta name="description" content="<?= ($blog->description) ? $blog->description : "kappa" ?>"/>
    <meta name="keywords" content="Hello from the others side"/>
    <?= (isset($author->var->name)) ? '<meta name="author" content="' . $author->var->name . '"/>' : false ?>
    <link rel="stylesheet"
          href="<?= (isset($blog->stylesheet)) ? $blog->stylesheet : "http://static.brolaugh.com/blog/css/material-design.min.css" ?>"
          charset="utf-8"/>
    <title><?= $blog->title . " - Brolaugh Blog Platform yo" ?></title>
</head>
