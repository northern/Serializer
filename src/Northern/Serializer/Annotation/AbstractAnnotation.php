<?php

namespace Northern\Serializer\Annotation;

use Doctrine\Common\Annotations\Annotation;

abstract class AbstractAnnotation extends Annotation {

	/**
	 * @var string
	 */
	public $name;
	
	public function getPropertyValue( \ReflectionProperty $property, $object )
	{
		$property->setAccessible( true );

		return $property->getValue( $object );
	}

	public function getMethodValue( \ReflectionMethod $method, $object )
	{
		$method->setAccessible( true );

		return $method->invoke( $object );
	}

}
