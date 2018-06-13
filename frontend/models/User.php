<?php

namespace frontend\models;

use common\models\db\BaseUser;
use Yii;

//TODO: move all models to common/db
//TODO: create class BaseUser and extends from it. Base User auto generate
//TODO: generate all Base models via gii from console
//php yii gii/model --tableName=user --ns="common\models\db" --modelClass=BaseUser --overwrite=1
class User extends BaseUser
{
    const STATUS_ACTIVE = 10;

}
