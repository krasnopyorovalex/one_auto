<?php
namespace frontend\widgets;

use yii\base\Widget;

class Portfolio extends Widget
{

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('/widgets/portfolio.twig', ['model' => \common\models\Portfolio::find()->with(['portfolioImages'])->orderBy('pos')->asArray()->all()]);
    }
}