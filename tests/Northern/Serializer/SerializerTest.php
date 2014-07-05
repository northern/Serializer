<?php

namespace Northern\Serializer;

class TestClass {

	/** @Annotation\String */
	protected $stringProp = "abc";

	/** @Annotation\Int */
	protected $intProp = 123;

	/** @Annotation\Integer */
	protected $integerProp = 456;

	/** @Annotation\Bool */
	protected $boolProp = true;

	/** @Annotation\String(name="stringValue") */
	public function getStringValue()
	{
		return "xyz";
	}

	/** @Annotation\Int(name="intValue") */
	public function getSomeIntValue()
	{
		return 123;
	}

	/** @Annotation\Integer(name="integerValue") */
	public function getSomeIntegerValue()
	{
		return 456;
	}

	/** @Annotation\Bool(name="boolValue") */
	public function getBoolValue()
	{
		return true;
	}

}

class SerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize()
	{
		$serializer = new Serializer();

		$test = new TestClass();
		
		$data = $serializer->toArray( $test );
		//print_r( $data );

		$this->assertEquals( $data['stringProp'], "abc" );
		$this->assertEquals( $data['intProp'], 123 );
		$this->assertEquals( $data['integerProp'], 456 );

		$this->assertEquals( $data['stringValue'], 'xyz' );
		$this->assertEquals( $data['intValue'], 123 );
		$this->assertEquals( $data['integerValue'], 456 );

		$json = $serializer->toJson( $test );
		print_r( $json );
	}

}
