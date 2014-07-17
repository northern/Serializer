<?php

namespace Northern\Serializer;

use Northern\Serializer\Serializer;
use Northern\Serializer\Annotation as Serialize;

class PropertyVisibilityTestClass {

	/** @Serialize\Int */
	public $publicFoo = 1;

	/** @Serialize\Int */
	protected $protectedFoo = 2;

	/** @Serialize\Int */
	private $privateFoo = 3;

	/** @Serialize\Int(name="publicBar") */
	public function getPublicBar()
	{
		return 1;
	}

	/** @Serialize\Int(name="protectedBar") */
	public function getProtectedBar()
	{
		return 2;
	}

	/** @Serialize\Int(name="privateBar") */
	public function getPrivateBar()
	{
		return 3;
	}

}

class PropertyVisibilityTest extends \PHPUnit_Framework_TestCase {

	public function testPropertyVisiblity()
	{
		$test = new PropertyVisibilityTestClass();

		$serializer = new Serializer();

		$data = $serializer->toArray( $test );

		$this->assertEquals( $data['publicFoo'], 1 );
		$this->assertEquals( $data['protectedFoo'], 2 );
		$this->assertEquals( $data['privateFoo'], 3 );

		$this->assertEquals( $data['publicBar'], 1 );
		$this->assertEquals( $data['protectedBar'], 2 );
		$this->assertEquals( $data['privateBar'], 3 );
	}

}
