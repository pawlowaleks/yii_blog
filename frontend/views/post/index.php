<?php
/* @var $this yii\web\View */
?>
<h1>post/index</h1>

<?php
foreach ($post as $item) { ?>
    <div>
        <h2><?=$item['name'];?></h2>
        <p>Author: <?=$item['author'];?></p>
        <p>Created at: <?=$item['created_at'];?></p>
        <p><?=$item['post'];?></p>
    </div>
<?php
}
?>
