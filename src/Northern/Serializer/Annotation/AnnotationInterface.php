<?php

namespace Northern\Serializer\Annotation;

interface AnnotationInterface {

	public function getPropertyValue( \ReflectionProperty $property, $object );
	public function getMethodValue( \ReflectionMethod $method, $object );

}
