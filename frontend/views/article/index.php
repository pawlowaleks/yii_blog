<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
foreach ($models as $model) { ?>
    <a href="/article/view?id=<?= $model->articleId?>"><h3><?= $model->title; ?></h3></a>
    Author: <?= $model->userId
    ; ?>
    Created at: <?= $model->createdAt; ?>
    <p><?= $model->content ?></p>
<?php
}

// display pagination
echo LinkPager::widget([
    'pagination' => $pages,
]);
?>
