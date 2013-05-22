<?php
/**
 * User: Zachary Tong
 * Date: 2013-02-24
 * Time: 11:57 AM
 * Auto-generated by "generate.filters.tests.php"
 */

namespace sherlock\tests;

use \Sherlock\Sherlock;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \sherlock\sherlock
     */
    protected $object;


    public function __construct()
    {
        /*
        try {
            $sherlock = new Sherlock;
            $sherlock->addNode('localhost', '9200');
            //Create the index
            $index = $sherlock->index('testfilters');
            $response = $index->create();
        } catch (\Exception $e) {}
        */
    }


    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Sherlock;
        $this->object->addNode('localhost', '9200');
    }


    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        /*
        try {
            $this->object->index('testfilters')->delete();
        } catch (\Exception $e) {

        }
        */
    }


    public function assertThrowsException($exception_name, $code)
    {
        $e = null;
        try {
            $code();
        } catch (\Exception $e) {
            // No more code, we only want to catch the exception in $e
        }

        $this->assertInstanceOf($exception_name, $e);

    }


    /**
     * @covers sherlock\Sherlock\components\filters\And::and
     * @covers sherlock\Sherlock\components\filters\And::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testAnd()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->AndFilter()->and(
            array(
                Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
                Sherlock::queryBuilder()->Term()->field("auxillary2")->term("auxillary2")
            )
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '';
        //$this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Bool::must
     * @covers sherlock\Sherlock\components\filters\Bool::must_not
     * @covers sherlock\Sherlock\components\filters\Bool::should
     * @covers sherlock\Sherlock\components\filters\Bool::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testBool()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Bool()->must(
            array(
                Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
                Sherlock::queryBuilder()->Term()->field("auxillary2")->term("auxillary2")
            )
        )
            ->must_not(
                array(
                    Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
                    Sherlock::queryBuilder()->Term()->field("auxillary2")->term("auxillary2")
                )
            )
            ->should(
                array(
                    Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
                    Sherlock::queryBuilder()->Term()->field("auxillary2")->term("auxillary2")
                )
            )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '';
        //$this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Exists::field
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testExists()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Exists()->field("testString");

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '';
        //$this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @todo construct proper test for Geo filters
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::top_left_lat
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::top_left_lon
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::bottom_right_lat
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::bottom_right_lon
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::type
     * @covers sherlock\Sherlock\components\filters\GeoBoundingBox::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testGeoBoundingBox()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->GeoBoundingBox()->top_left_lat(0.5)
            ->top_left_lon(0.5)
            ->bottom_right_lat(0.5)
            ->bottom_right_lon(0.5)
            ->type("testString")
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"geo_bounding_box":{"pin.location":{"top_left":{"lat":0.5,"lon":0.5},"bottom_right":{"lat":0.5,"lon":0.5}},"type":"testString","_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @todo construct proper test for Geo filters
     * @covers sherlock\Sherlock\components\filters\GeoDistance::distance
     * @covers sherlock\Sherlock\components\filters\GeoDistance::lat
     * @covers sherlock\Sherlock\components\filters\GeoDistance::lon
     * @covers sherlock\Sherlock\components\filters\GeoDistance::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testGeoDistance()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->GeoDistance()->distance("1km")
            ->lat(0.5)
            ->lon(0.5)
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"geo_distance":{"distance":"1km","pin.location":{"lat":0.5,"lon":0.5},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @todo construct proper test for Geo filters
     * @covers sherlock\Sherlock\components\filters\GeoDistanceRange::from
     * @covers sherlock\Sherlock\components\filters\GeoDistanceRange::lat
     * @covers sherlock\Sherlock\components\filters\GeoDistanceRange::lon
     * @covers sherlock\Sherlock\components\filters\GeoDistanceRange::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testGeoDistanceRange()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->GeoDistanceRange()->from("100km")
            ->to("200km")
            ->lat(0.5)
            ->lon(0.5)
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"geo_distance_range":{"from":"100km","to":"200km","pin.location":{"lat":0.5,"lon":0.5},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @todo construct proper test for Geo filters
     * @covers sherlock\Sherlock\components\filters\GeoPolygon::points
     * @covers sherlock\Sherlock\components\filters\GeoPolygon::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testGeoPolygon()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->GeoPolygon()->points(
            array(array("lat" => 40, "lon" => -70), array("lat" => 30, "lon" => -80))
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"geo_polygon":{"person.location":{"points":[{"lat":40,"lon":-70},{"lat":30,"lon":-80}]},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @todo construct proper test for Parent/Child filters
     * @covers sherlock\Sherlock\components\filters\HasChild::type
     * @covers sherlock\Sherlock\components\filters\HasChild::query
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testHasChild()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->HasChild()->type("testString")
            ->query(Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"));

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"has_child":{"type":"testString","query":{"term":{"auxillary":{"value":"auxillary"}}}}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @todo construct proper test for Parent/Child filters
     * @covers sherlock\Sherlock\components\filters\HasParent::parent_type
     * @covers sherlock\Sherlock\components\filters\HasParent::query
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testHasParent()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->HasParent()->parent_type("testString")
            ->query(Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"));

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"has_parent":{"parent_type":"testString","query":{"term":{"auxillary":{"value":"auxillary"}}}}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Ids::type
     * @covers sherlock\Sherlock\components\filters\Ids::values
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testIds()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Ids()->type("testString")
            ->values(array("1", "2", "3"));

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"ids":{"type":"testString","values":["1","2","3"]}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Ids()->type("testString")
            ->values("1", "2", "3");

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"ids":{"type":"testString","values":["1","2","3"]}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Limit::value
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testLimit()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Limit()->value(3);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"limit":{"value":3}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testMatchAll()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->MatchAll();

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"match_all":[]}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Missing::field
     * @covers sherlock\Sherlock\components\filters\Missing::existence
     * @covers sherlock\Sherlock\components\filters\Missing::null_value
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testMissing()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Missing()->field("testString")
            ->existence(true)
            ->null_value(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"missing":{"field":"testString","existence":true,"null_value":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @todo construct proper test for Nested types
     * @covers sherlock\Sherlock\components\filters\Nested::path
     * @covers sherlock\Sherlock\components\filters\Nested::query
     * @covers sherlock\Sherlock\components\filters\Nested::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testNested()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Nested()->path("testString")
            ->query(Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"))
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"nested":{"path":"testString","query":{},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Not::not
     * @covers sherlock\Sherlock\components\filters\Not::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testNot()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Not()->not(
            Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"not":{"term":{"auxillary":{"value":"auxillary"}}},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Not()->not(
            Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"not":{"filter":{"term":{"auxillary":"auxillary","_cache":true}}},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @todo build proper test for NumericRange - requires a mapping in place
     * @covers sherlock\Sherlock\components\filters\NumericRange::field
     * @covers sherlock\Sherlock\components\filters\NumericRange::from
     * @covers sherlock\Sherlock\components\filters\NumericRange::to
     * @covers sherlock\Sherlock\components\filters\NumericRange::include_lower
     * @covers sherlock\Sherlock\components\filters\NumericRange::include_upper
     * @covers sherlock\Sherlock\components\filters\NumericRange::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testNumericRange()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->NumericRange()->field("testString")
            ->from(3)
            ->to(3)
            ->include_lower(true)
            ->include_upper(true)
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"numeric_range":{"testString":{"from":3,"to":3,"include_lower":true,"include_upper":true},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        //$resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Or::or
     * @covers sherlock\Sherlock\components\filters\Or::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testOr()
    {
        //Try the queries first

        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":[{"term":{"auxillary":{"value":"auxillary"}}}],"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        //queries, parameter declaration
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
            Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":[{"term":{"auxillary":{"value":"auxillary"}}},{"term":{"auxillary":{"value":"auxillary"}}}],"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        //queries, array declaration
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            array(
                Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary"),
                Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary")
            )
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":[{"term":{"auxillary":{"value":"auxillary"}}},{"term":{"auxillary":{"value":"auxillary"}}}],"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        //Filters now

        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":{"filters":[{"term":{"auxillary":"auxillary","_cache":true}}]},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        //filters, parameter declaration
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary"),
            Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":{"filters":[{"term":{"auxillary":"auxillary","_cache":true}},{"term":{"auxillary":"auxillary","_cache":true}}]},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        //filters, array declaration
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->OrFilter()->queries(
            array(
                Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary"),
                Sherlock::filterBuilder()->Term()->field("auxillary")->term("auxillary")
            )
        )
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"or":{"filters":[{"term":{"auxillary":"auxillary","_cache":true}},{"term":{"auxillary":"auxillary","_cache":true}}]},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Prefix::field
     * @covers sherlock\Sherlock\components\filters\Prefix::prefix
     * @covers sherlock\Sherlock\components\filters\Prefix::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testPrefix()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Prefix()->field("testString")
            ->prefix("testString")
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"prefix":{"testString":"testString","_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Query::query
     * @covers sherlock\Sherlock\components\filters\Query::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testQuery()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Query()->query(
            Sherlock::queryBuilder()->Term()->field("auxillary")->term("auxillary")
        )
            ->_cache(true);
        $query  = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"query":{"term":{"auxillary":{"value":"auxillary"}}},"_cache":true}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Range::field
     * @covers sherlock\Sherlock\components\filters\Range::from
     * @covers sherlock\Sherlock\components\filters\Range::to
     * @covers sherlock\Sherlock\components\filters\Range::include_lower
     * @covers sherlock\Sherlock\components\filters\Range::include_upper
     * @covers sherlock\Sherlock\components\filters\Range::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testRange()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Range()->field("testString")
            ->from("testString")
            ->to("testString")
            ->include_lower(true)
            ->include_upper(true)
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"range":{"testString":{"from":"testString","to":"testString","include_lower":true,"include_upper":true},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Script::script
     * @covers sherlock\Sherlock\components\filters\Script::params
     * @covers sherlock\Sherlock\components\filters\Script::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testScript()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Script()->script("_score")
            ->params(array("id" => 1))
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"script":{"script":"_score","params":{"id":1},"_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Term::field
     * @covers sherlock\Sherlock\components\filters\Term::term
     * @covers sherlock\Sherlock\components\filters\Term::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testTerm()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Term()->field("testString")
            ->term("testString")
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"term":{"testString":"testString","_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Terms::field
     * @covers sherlock\Sherlock\components\filters\Terms::terms
     * @covers sherlock\Sherlock\components\filters\Terms::execution
     * @covers sherlock\Sherlock\components\filters\Terms::_cache
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testTerms()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Terms()->field("testString")
            ->terms('term1', 'term2')
            ->execution("plain")
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"terms":{"testString":["term1","term2"],"execution":"plain","_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Terms()->field("testString")
            ->terms(array('term1', 'term2'))
            ->execution("plain")
            ->_cache(true);

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"terms":{"testString":["term1","term2"],"execution":"plain","_cache":true}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }


    /**
     * @covers sherlock\Sherlock\components\filters\Type::value
     * @covers sherlock\Sherlock\requests\SearchRequest::query
     * @covers sherlock\Sherlock\requests\SearchRequest::toJSON
     */
    public function testType()
    {
        $req = $this->object->search();
        $req->index("testfilters")->type("test");
        $filter = Sherlock::filterBuilder()->Type()->value("testString");

        $query = Sherlock::queryBuilder()->MatchAll();

        \Analog\Analog::log($filter->toJSON(), \Analog\Analog::DEBUG);

        $req->query($query);
        $req->filter($filter);

        $data         = $req->toJSON();
        $expectedData = '{"query":{"match_all":{"boost":1}},"filter":{"type":{"value":"testString"}}}';
        $this->assertEquals($expectedData, $data);

        $resp = $req->execute();

    }

}
