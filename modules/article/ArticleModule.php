<?php
namespace yii\easyii\modules\article;

class ArticleModule extends \yii\easyii\components\Module
{
    public $settings = [
        'categoryThumb' => true,
        'articleThumb' => true,

        'enableShort' => true,
        'shortMaxLength' => 255,
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Articles',
            'ru' => 'Статьи',
        ],
        'icon' => 'pencil',
        'order_num' => 65,
    ];
}