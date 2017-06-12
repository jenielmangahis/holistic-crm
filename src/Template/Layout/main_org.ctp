<!DOCTYPE html>
<html lang="en-us">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= (isset($website_title) ? $website_title : 'CleanseTech') ?> : <?= (isset($page_title) ? $page_title : $this->fetch('title')) ?>
    </title>

    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('styles.css');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>

    <script>
        var BASE_URL = '<?= $this->Url->build("/") ?>';
    </script>

    <link rel="shortcut icon" href="<?= $this->Url->build("/webroot/img/") ?>favicon.ico">

</head>

<body class="home">
    <header class="header">
        <?php include_once("main_header.ctp"); ?>
    </header>

    <?= $this->fetch('content') ?>

    <footer>
        <?php include_once("main_footer.ctp"); ?>
    </footer>  
      
</body>
</html>
