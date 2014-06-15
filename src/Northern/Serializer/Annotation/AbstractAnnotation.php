<?php

namespace Northern\Serializer\Annotation;

use Doctrine\Common\Annotations\Annotation;

abstract class AbstractAnnotation extends Annotation {

	public function getValue( \ReflectionProperty $property, $object )
	{
		$property->setAccessible( true );

		return $property->getValue( $object );
	}

}
