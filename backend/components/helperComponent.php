<?php

namespace backend\components;

use yii\base\Component;

class HelperComponent extends Component
{
    public function display($content = null)
    {
        if ($content != null) {
            $this->content = $content;
        }
        echo Html::encode($this->content);
    }
}
