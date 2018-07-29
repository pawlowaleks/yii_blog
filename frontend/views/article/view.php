<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    Author: <?= $model['userId']; ?>
    Created at: <?= $model['createdAt']; ?>
    <p><?= $model['content'] ?></p>

    <h4>Comments:</h4>

    <?php foreach ($comment as $item) { ?>
        <p>
            Author: <?= $item->userId?> <br>
            <?= $item->comment ?>

        </p>

    <?php } ?>

    <?= Html::a('Create comment', '/comment/create?articleId=' . $model->articleId, ['class' => 'btn btn-primary']); ?>


</div>