<?php

namespace Northern\Serializer\Exception;

use Northern\Serializer\Serializer;
use Northern\Serializer\Annotation as Serialize;

class MissingAnnotationTest {

	/** @Serialize\Int */  // <- This should have a (name="[name]") attribute set on the annotation.
	public function getPublicBar()
	{
		return 1;
	}

}

class MissingAnnotationAttributeOnMethodExceptionTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @expectedException \Northern\Serializer\Exception\MissingAnnotationAttributeOnMethodException
	 */
	public function testMissingAnnotationAttributeOnMethodException()
	{
		$test = new MissingAnnotationTest();

		$serializer = new Serializer();

		$data = $serializer->toArray( $test );
	}

}
