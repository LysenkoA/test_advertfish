<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = $news->title;
?>
<div class="">

    <div class="body-content">

        <div class="row">
            <div class="col-md=12">
                <h1><?= $this->title ?></h1>
                <div class="row">
                    <div class="col-md-6">
                        <div><?= Html::img($news->image, ['class' => 'img-responsive']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <h3>Категория:</h3>
                            <ul>
                                <?php foreach ($news->categories as $category): ?>
                                    <li><?= $category->name ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div>
                            <h3>Автор:</h3>
                            <ul>
                                <?php foreach ($news->authors as $author): ?>
                                  <li><?= $author->name ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div>
                    <?= $news->body ?>
                </div>
            </div>
        </div>

    </div>
</div>