<?php

namespace Northern\Serializer\Annotation;

/** @Annotation */
class Bool extends AbstractAnnotation implements AnnotationInterface {

	public function getPropertyValue( \ReflectionProperty $property, $object )
	{
		$property->setAccessible( true );

		return (bool)$property->getValue( $object );
	}

	public function getMethodValue( \ReflectionMethod $method, $object )
	{
		$method->setAccessible( true );

		return (bool)$method->invoke( $object );
	}

}
