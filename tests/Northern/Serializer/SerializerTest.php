<?php

namespace Northern\Serializer;

class TestClass {

	/** @Annotation\String */
	protected $prop = "Hello";

}

class SerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize()
	{
		$serializer = new Serializer();

		$test = new TestClass();
		
		$data = $serializer->toArray( $test );
		print_r( $data );

	}

}
