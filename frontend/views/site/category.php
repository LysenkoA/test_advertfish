<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="">

    <div class="body-content">

        <div class="row">

            <?php foreach ($news as $item): ?>

            <div class="col-lg-3">
                <h2><?= $item->title ?></h2>
                <p>
                    <?= Html::img($item->image, ['class' => 'img-responsive']) ?>
                </p>

                <p>
                    <?= $item->description ?>
                </p>

                <p>
                    <?= Html::a('more ...', ['/site/news', 'id' => $item->id], ['class' => 'btn btn-primary']) ?>
                </p>

            </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>
