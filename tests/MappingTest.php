<?php
namespace sherlock;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-07 at 03:12:53.
 */
class MappingTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Sherlock
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Sherlock;
		$this->object->addNode('loopback.com', '9200');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		try{
			$this->object->index('test123')->delete();
		}
		catch(\Exception $e)
		{

		}
	}

	function assertThrowsException($exception_name, $code) {
		$e = null;
		try{
			$code();
		}catch (\Exception $e) {
			// No more code, we only want to catch the exception in $e
		}

		$this->assertInstanceOf($exception_name, $e);
	}




	public function testStringMapping()
	{
		$sherlock = $this->object;

		//Set the index
		$index = $sherlock->index('test123');

		//no field, expect error
		$mapping = sherlock::mappingProperty()->String();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, but no field, expect error
		$mapping = sherlock::mappingProperty('testField')->String();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//no type, field
		$mapping = sherlock::mappingProperty()->String()->field('testField');
		$data = $mapping->toJSON();
		$expected = '{"testField":{"type":"string"}}';
		$this->assertEquals($expected, $data);

		//type, field
		$mapping = sherlock::mappingProperty('testType')->String()->field('testField');
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testField":{"type":"string"}}}}';
		$this->assertEquals($expected, $data);

		//no type, hashmap of properties
		$hash = array("field"=>'testField');
		$mapping = sherlock::mappingProperty()->String($hash);
		$data = $mapping->toJSON();
		$expected = '{"testField":{"type":"string"}}';
		$this->assertEquals($expected, $data);

		//type, hashmap of properties
		$hash = array("field"=>'testField');
		$mapping = sherlock::mappingProperty('testType')->String($hash);
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testField":{"type":"string"}}}}';
		$this->assertEquals($expected, $data);

		//type, hashmap of properties, but override the hashmap with a new value
		$hash = array("field"=>'testField');
		$mapping = sherlock::mappingProperty('testType')->String($hash)->field("testFieldNew");
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testFieldNew":{"type":"string"}}}}';
		$this->assertEquals($expected, $data);

		//type, hashmap of properties, but override the hashmap with a new value, add a boost
		$hash = array("field"=>'testField');
		$mapping = sherlock::mappingProperty('testType')->String($hash)->field("testFieldNew")->boost(0.2);
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testFieldNew":{"type":"string","boost":0.2}}}}';
		$this->assertEquals($expected, $data);


	}

	public function testNumberMapping()
	{
		$sherlock = $this->object;

		//Set the index
		$index = $sherlock->index('test123');

		//no field, expect error
		$mapping = sherlock::mappingProperty()->Number();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, but no field, expect error
		$mapping = sherlock::mappingProperty('testType')->Number();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, field, but no number-type, expect error
		$mapping = sherlock::mappingProperty('testType')->Number()->field("testField");
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, field, number-type
		$mapping = sherlock::mappingProperty('testType')->Number()->field('testField')->type("float");
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testField":{"type":"float"}}}}';
		$this->assertEquals($expected, $data);

	}

	public function testDateMapping()
	{
		$sherlock = $this->object;

		//Set the index
		$index = $sherlock->index('test123');

		//no field, expect error
		$mapping = sherlock::mappingProperty()->Date();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, but no field, expect error
		$mapping = sherlock::mappingProperty('testType')->Date();
		$this->assertThrowsException('\sherlock\common\exceptions\RuntimeException', function () use ($mapping) {
			$data = $mapping->toJSON();
		});

		//type, field, format
		$mapping = sherlock::mappingProperty('testType')->Date()->field('testField')->format("YYYY-MM-dd");
		$data = $mapping->toJSON();
		$expected = '{"testType":{"properties":{"testField":{"type":"date","format":"YYYY-MM-dd"}}}}';
		$this->assertEquals($expected, $data);

		//field, format
		$mapping = sherlock::mappingProperty()->Date()->field('testField')->format("YYYY-MM-dd");
		$data = $mapping->toJSON();
		$expected = '{"testField":{"type":"date","format":"YYYY-MM-dd"}}';
		$this->assertEquals($expected, $data);

	}

	public function testMultiMapping()
	{
		$sherlock = $this->object;

		//Set the index
		$index = $sherlock->index('test123');

		$mapping1 = sherlock::mappingProperty('testType')->Date()->field('testField')->format("YYYY-MM-dd");
		$mapping2 = sherlock::mappingProperty('testType2')->String()->field('testField2');

		//add both mappings and create the index
		$index->mappings($mapping1, $mapping2);
		$response = $index->create();
		$this->assertEquals(true, $response->ok);

		//try to update the index
		$index->mappings($mapping1)->type("testType");
		$response = $index->updateMapping();
		$this->assertEquals(true, $response->ok);

		$response = $index->delete();
		$this->assertEquals(true, $response->ok);

	}

	public function testObjectMapping()
	{
		$sherlock = $this->object;

		//Set the index
		$index = $sherlock->index('test123');

		$mapping1 = sherlock::mappingProperty('testType')->Date()->field('testField')->format("YYYY-MM-dd");
		$mapping2 = sherlock::mappingProperty('testType2')->Object()->field("testField2")->object(($mapping1));

		$data = $mapping2->toJSON();
		$expected = '{"testType2":{"properties":{"testField2":{"properties":{"testType":{"properties":{"testField":{"type":"date","format":"YYYY-MM-dd"}}}},"type":"object"}}}}';
		$this->assertEquals($expected, $data);

		$mapping2->dynamic(true);
		$data = $mapping2->toJSON();
		$expected = '{"testType2":{"properties":{"testField2":{"properties":{"testType":{"properties":{"testField":{"type":"date","format":"YYYY-MM-dd"}}}},"type":"object","dynamic":true}}}}';
		$this->assertEquals($expected, $data);


	}

}
