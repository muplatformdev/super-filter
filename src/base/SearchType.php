<?php

namespace pdaleramirez\superfilter\base;

use craft\base\Component;
use craft\elements\db\ElementQuery;
use craft\elements\Entry;
use pdaleramirez\superfilter\contracts\SearchTypeInterface;
use pdaleramirez\superfilter\elements\SetupSearch;
use pdaleramirez\superfilter\SuperFilter;

abstract class SearchType extends Component implements SearchTypeInterface
{
    /**
     * @var SetupSearch
     */
    protected $element = null;
    protected $options = null;
    protected $items = null;
    protected $sorts = null;
    protected $sortParam = null;
    protected $params = null;
    /**
     * @var $query ElementQuery
     */
    protected $query;

    public function setElement(SetupSearch $setupSearch)
    {
        $this->element = $setupSearch;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setSorts(array $sorts)
    {
        $this->sorts = $sorts;
    }

    public function setParams($params)
    {
        $this->params = $params;

        $sort = $params['sort'] ?? null;

        if ($sort) {
            $sort = explode('-', $sort);

            $this->sortParam['attribute'] = $sort[0];
            $this->sortParam['sort'] = $sort[1] === 'desc' ? SORT_DESC : SORT_ASC;
        }

    }

    public function getContainer()
    {
        return null;
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function getSorts()
    {
        $element = $this->getElement();
        $entryOptions = SuperFilter::$app->searchTypes->getSortOptions($element::sortOptions());

        $fields = [];

        $fieldObjects = $this->_getFields ?? $this->getFieldObjects();

        foreach ($fieldObjects as $sectionHandle => $item) {
            //$fields[$sectionHandle] = $entryOptions['defaultSortOptions'];
            $fields[$sectionHandle]['label']    = $item['label'];
            $fields[$sectionHandle]['selected'] = [];
            $itemObjects = $item['fieldObjects'];

            $sortFields = [];
            if (count($itemObjects) > 0) {
                foreach ($itemObjects as $key => $fieldObject) {
                    if (in_array($fieldObject->handle, $entryOptions['sortOptions'])) {
                        $sortFields[$key]['name'] = $fieldObject->name;
                        $sortFields[$key]['orderBy'] = $fieldObject->handle;
                    }
                }
            }

            $fields[$sectionHandle]['options'] = array_merge($entryOptions['defaultSortOptions'],
                $sortFields);
        }

        return $fields;
    }
}
