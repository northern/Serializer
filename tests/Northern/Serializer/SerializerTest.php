<?php

namespace Northern\Serializer;

use Northern\Serializer\Serializer;
use Northern\Serializer\Annotation as Serialize;

class FooClass {

	/** @Serialize\String */
	protected $stringProp = "abc";

	/** @Serialize\Int */
	protected $intProp = 123;

	/** @Serialize\Integer */
	protected $integerProp = 456;

	/** @Serialize\Bool(name="myBoolProp") */
	protected $boolProp = true;

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

}

class SerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize()
	{
		$test = new FooClass();
		
		$serializer = new Serializer();

		$data = $serializer->toArray( $test );
		//print_r( $data );

		$this->assertEquals( $data['stringProp'], "abc" );
		$this->assertEquals( $data['intProp'], 123 );
		$this->assertEquals( $data['integerProp'], 456 );

		$this->assertEquals( $data['stringValue'], 'xyz' );
		$this->assertEquals( $data['intValue'], 123 );
		$this->assertEquals( $data['integerValue'], 456 );

		$json = $serializer->toJson( $test );
		//print_r( $json );
	}

}
