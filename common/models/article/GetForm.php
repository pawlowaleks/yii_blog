<?php

namespace common\models\article;

use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.06.18
 * Time: 1:24
 */

class GetForm extends Model
{
    public $limit = 20;
    public $offset = 0;

    private $_article;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['limit', 'offset'], 'numerical']
        ];
    }

    public function Get()
    {

    }

}