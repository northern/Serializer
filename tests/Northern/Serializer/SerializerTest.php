<?php

namespace Northern\Serializer;

use Northern\Serializer\Serializer;
use Northern\Serializer\Annotation as Serialize;

class BazClass {

	/** @Serialize\Int */
	protected $bazNum = 1234321;

}

class BarClass {

	/** @Serialize\String */
	protected $barString = "xyz";

	/** @Serialize\Object */
	protected $baz;

	public function __construct()
	{
		$this->baz = new BazClass();
	}

}

class FooClass {

	/** @Serialize\Object */
	protected $bar;

	/** @Serialize\Collection */
	protected $barArray;

	/** @Serialize\String */
	protected $stringProp = "abc";

	/** @Serialize\Int */
	protected $intProp = 123;

	/** @Serialize\Integer */
	protected $integerProp = 456;

	/** @Serialize\Bool(name="myBoolProp") */
	protected $boolProp = true;

	/** @Serialize\Collection */
	protected $myCollection = array(1,2,3);

	protected $noneSerialize;

	public function __construct()
	{
		$this->bar = new BarClass();

		$this->barArray = array(
			new BarClass(),
			new BarClass(),
			new BarClass(),
		);
	}

	/** @Serialize\String(name="stringValue") */
	public function getStringValue()
	{
		return "xyz";
	}

	/** @Serialize\Int(name="intValue") */
	public function getSomeIntValue()
	{
		return 123;
	}

	/** @Serialize\Integer(name="integerValue") */
	public function getSomeIntegerValue()
	{
		return 456;
	}

	/** @Serialize\Bool(name="boolValue") */
	public function getBoolValue()
	{
		return true;
	}

	/** @Serialize\Bool */
	public function isBoolValue()
	{
		return true;
	}

}

class SerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize()
	{
		$test = new FooClass();
		
		$serializer = new Serializer();

		$data = $serializer->toArray( $test );

		$this->assertEquals( $data['stringProp'], "abc" );
		$this->assertEquals( $data['intProp'], 123 );
		$this->assertEquals( $data['integerProp'], 456 );

		$this->assertEquals( $data['stringValue'], 'xyz' );
		$this->assertEquals( $data['intValue'], 123 );
		$this->assertEquals( $data['integerValue'], 456 );

		//$json = $serializer->toJson( $test );
	}

}
