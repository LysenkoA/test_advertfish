<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">

            <?php foreach ($categories as $category): ?>

            <div class="col-lg-3">
                <h2><?= $category->name ?></h2>
                <p>
                    <?= Html::img($category->image, ['class' => 'img-responsive']) ?>
                </p>
                <p>
                    <?= Html::a('more ...', ['/site/category', 'id' => $category->id], ['class' => 'btn btn-primary']) ?>
                </p>

            </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>
