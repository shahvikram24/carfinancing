<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Provinces */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Provinces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="provinces-view">

    <h1><?= Html::encode($this->title) ?></h1>

	    <?php echo Html::beginForm(['/admin/provinces/delete?id=' . $model->id], 'post');
	    echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary', 'style' => 'padding-right: 15px;margin-right:20px;']);
                                echo Html::submitButton(
                                    '<i class="fa fa-trash"></i> Delete',
                                    ['class' => 'btn btn-danger',
                                     'onclick' => "return confirm('Are you sure you want to delete this item?');",
                                    ]
                                );
                                echo Html::endForm(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'is_active',
        ],
    ]) ?>

</div>
