<?php
namespace pdaleramirez\superfilter\controllers;

use craft\db\Paginator;
use craft\elements\Entry;
use craft\helpers\Json;
use craft\web\Controller;
use Craft;
use pdaleramirez\superfilter\SuperFilter;

class ElementsController extends Controller
{
      protected $allowAnonymous = ['get-elements'];

    public function actionGetElements()
    {
        $params = [
            'handle' => 'entry',
            'currentPage' => Craft::$app->getRequest()->getBodyParam('currentPage') ?? 1,
            'categoryId'  => Craft::$app->getRequest()->getBodyParam('category'),
            'limit'       => Craft::$app->getRequest()->getBodyParam('limit')
        ];

        $items = SuperFilter::$app->config($params)->items();

        return Json::encode($items);
    }
}