<html>
<head>
    <title><?=$this->getTitle();?></title>
    <meta name="description" content="<?=$this->getDescription()?>">
    <?php foreach($this->getMeta() as $meta_key => $meta_val):?>
        <meta name="<?=$meta_key?>" content="<?=$meta_val?>">
    <?php endforeach;?>
</head>
<body>
<?php
phpinfo();
?>
</body>
</html>
