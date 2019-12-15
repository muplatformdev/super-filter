<?php

use Codeception\Stub;
use Codeception\Test\Unit;
use craft\elements\Entry;
use craft\helpers\Json;
use pdaleramirez\superfilter\elements\SetupSearch;
use pdaleramirez\superfilter\searchtypes\EntrySearchType;
use pdaleramirez\superfilter\SuperFilter;

class SearchTypeTest extends Unit
{
    public function testSearchByRef()
    {
        $type = SuperFilter::$app->searchTypes->getSearchTypeByRef('entry');

        $expected = EntrySearchType::class;

        $this->assertEquals($expected, get_class($type));
    }

    public function testSearchTypeOptions()
    {
        $searchType = Stub::make(EntrySearchType::class,
            [
                'getElement' => Entry::class, 'getContainer' => ['shows' => 'Shows', 'movies' => 'Movies'],
                'getSorts' => ['selected' => null, 'options' => ['description', 'rating']],
                'getFields' => ['selected' => null, 'options' => ['description', 'rating']],
            ]
        );

        $items = SuperFilter::$app->searchTypes->getSearchTypeOptions($searchType);

        $expected = [
            'label' => 'Entry',
            'handle' => 'entry',
            'container' => [
                'items' => ['shows' => 'Shows', 'movies' => 'Movies'],
                'selected' => null
            ],
            'sorts' => ['selected' => null, 'options' => ['description', 'rating']],
            'items' => ['selected' => null, 'options' => ['description', 'rating']]
        ];

        $this->assertEquals($expected, $items);
    }

    public function testSetItemSelected()
    {
        $items = '{"elements": {"selected": "entry", "items": {"entry": {"label": "Entry", "handle": "entry", "container": {"items": {"news": "News", "superFilterShows": "Shows"}, "selected": "superFilterShows"}, "sorts": {"news": {"label": "News", "selected": [], "options": [{"name": "Title", "attribute": "title", "orderBy": "title"}, {"name": "Slug", "attribute": "slug", "orderBy": "slug"}, {"name": "URI", "attribute": "uri", "orderBy": "uri"}, {"name": "Post Date", "attribute": "postDate", "orderBy": "postDate"}, {"name": "Expiry Date", "attribute": "expiryDate", "orderBy": "expiryDate"}, {"name": "Date Created", "attribute": "dateCreated", "orderBy": "elements.dateCreated"}, {"name": "Date Updated", "attribute": "dateUpdated", "orderBy": "elements.dateUpdated"}, {"name": "Example Dropdown", "id": "sproutExampleDropdown"}]}, "superFilterShows": {"label": "Shows", "selected": [{"name": "Title", "attribute": "title", "orderBy": "title"}, {"name": "Date Created", "attribute": "dateCreated", "orderBy": "elements.dateCreated"}, {"name": "Imdb Rating", "id": "superFilterImdbRating"}], "options": [{"name": "Slug", "attribute": "slug", "orderBy": "slug"}, {"name": "URI", "attribute": "uri", "orderBy": "uri"}, {"name": "Post Date", "attribute": "postDate", "orderBy": "postDate"}, {"name": "Expiry Date", "attribute": "expiryDate", "orderBy": "expiryDate"}, {"name": "Release Dates", "id": "superFilterReleaseDates"}, {"name": "Date Updated", "attribute": "dateUpdated", "orderBy": "elements.dateUpdated"}, {"name": "Show Types", "id": "superFilterShowTypes"}]}}, "items": {"news": {"label": "News", "selected": [], "options": [{"name": "Example Dropdown", "id": "8"}]}, "superFilterShows": {"label": "Shows", "selected": [{"name": "Imdb Rating", "id": "105"}, {"name": "Genre", "id": "100"}], "options": [{"name": "Description", "id": "99"}, {"name": "Show Tags", "id": "101"}, {"name": "Show Types", "id": "102"}, {"name": "Release Dates", "id": "110"}, {"name": "Guides", "id": "104"}]}}}, "category": {"label": "Category", "handle": "category", "container": {"items": {"funny": "Funny", "superFilterGenre": "Genre"}, "selected": "superFilterShows"}, "sorts": {"funny": {"label": "Funny", "selected": [], "options": [{"name": "Description", "id": "99"}, {"name": "Example Assets", "id": "3"}]}, "superFilterGenre": {"label": "Genre", "selected": []}, "superFilterShows": {"label": "Shows", "selected": [{"name": "Title", "attribute": "title", "orderBy": "title"}, {"name": "Date Created", "attribute": "dateCreated", "orderBy": "elements.dateCreated"}, {"name": "Imdb Rating", "id": "superFilterImdbRating"}], "options": [{"name": "Slug", "attribute": "slug", "orderBy": "slug"}, {"name": "URI", "attribute": "uri", "orderBy": "uri"}, {"name": "Post Date", "attribute": "postDate", "orderBy": "postDate"}, {"name": "Expiry Date", "attribute": "expiryDate", "orderBy": "expiryDate"}, {"name": "Release Dates", "id": "superFilterReleaseDates"}, {"name": "Date Updated", "attribute": "dateUpdated", "orderBy": "elements.dateUpdated"}, {"name": "Show Types", "id": "superFilterShowTypes"}]}}, "items": {"funny": {"label": "Funny", "selected": [], "options": [{"name": "Description", "id": "99"}, {"name": "Example Assets", "id": "3"}]}, "superFilterGenre": {"label": "Genre", "selected": []}, "superFilterShows": {"label": "Shows", "selected": [{"name": "Imdb Rating", "id": "105"}, {"name": "Genre", "id": "100"}], "options": [{"name": "Description", "id": "99"}, {"name": "Show Tags", "id": "101"}, {"name": "Show Types", "id": "102"}, {"name": "Release Dates", "id": "110"}, {"name": "Guides", "id": "104"}]}}}}}}';

        $selected = SuperFilter::$app->searchTypes->setSelectedItems($items);

        $expected = '{"container": "superFilterShows", "sorts": {"label": "Shows", "selected": [{"name": "Title", "attribute": "title", "orderBy": "title"}, {"name": "Date Created", "attribute": "dateCreated", "orderBy": "elements.dateCreated"}, {"name": "Imdb Rating", "id": "superFilterImdbRating"}], "options": [{"name": "Slug", "attribute": "slug", "orderBy": "slug"}, {"name": "URI", "attribute": "uri", "orderBy": "uri"}, {"name": "Post Date", "attribute": "postDate", "orderBy": "postDate"}, {"name": "Expiry Date", "attribute": "expiryDate", "orderBy": "expiryDate"}, {"name": "Release Dates", "id": "superFilterReleaseDates"}, {"name": "Date Updated", "attribute": "dateUpdated", "orderBy": "elements.dateUpdated"}, {"name": "Show Types", "id": "superFilterShowTypes"}]}, "items": {"label": "Shows", "selected": [{"name": "Imdb Rating", "id": "105"}, {"name": "Genre", "id": "100"}], "options": [{"name": "Description", "id": "99"}, {"name": "Show Tags", "id": "101"}, {"name": "Show Types", "id": "102"}, {"name": "Release Dates", "id": "110"}, {"name": "Guides", "id": "104"}]}}';

        $expected = Json::decode($expected);

        $this->assertEquals($expected, $selected);

        $setup = $this->make(SetupSearch::class);
        $setup->items = $expected;

        $itemFormat = SuperFilter::$app->searchTypes->getItemFormat($setup);

        $this->assertEquals(Json::decode($items), $itemFormat);
    }
}
