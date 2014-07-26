<?php

namespace Northern\Serializer\Annotation;

/** @Annotation */
class Int extends AbstractAnnotation implements AnnotationInterface {

	public function getPropertyValue( \ReflectionProperty $property, $object )
	{
		$property->setAccessible( true );

		return (int)$property->getValue( $object );
	}

	public function getMethodValue( \ReflectionMethod $method, $object )
	{
		$method->setAccessible( true );

		return (int)$method->invoke( $object );
	}

}
