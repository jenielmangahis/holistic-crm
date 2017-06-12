<!DOCTYPE html>
<html lang="en-us">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Homelux : <?= (isset($page_title) ? $page_title : $this->fetch('title')) ?>
    </title>

    <!-- Bootstrap core CSS -->
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <link href="css/styles.css" rel="stylesheet"> -->
    <?php
 
        echo $this->Html->css('bootstrap.min.css');
        //echo $this->Html->css('main.css');
        echo $this->Html->css('styles.css');

        echo $this->Html->css('font-awesome.min.css');
        echo $this->Html->meta('icon');
 
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>

    <script>
        var BASE_URL = '<?= $this->Url->build("/") ?>';
    </script>

    <link rel="shortcut icon" href="<?= $this->Url->build("/webroot/img/") ?>favicon.ico">

</head>

<body class="">
    <header class="header">
        <?php include("inner_header.ctp"); ?>
    </header>

    <div class="full-bread">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <h3><?= __('Products') ?></h3>
            </div>
            <?php echo $this->element('breadcrumb'); ?>
        </div>
    </div>
    </div> 

   
        <?= $this->fetch('content') ?>
   

    <footer>
        <?php include("inner_footer.ctp"); ?>
    </footer>  
      
</body>
</html>
