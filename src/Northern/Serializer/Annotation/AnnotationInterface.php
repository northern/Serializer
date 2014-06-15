<?php

namespace Northern\Serializer\Annotation;

interface AnnotationInterface {

	public function getValue( \ReflectionProperty $property, $object );

}
