<?php

namespace Northern\Serializer\Annotation;

/** @Annotation */
final class String extends AbstractAnnotation implements AnnotationInterface {

	/**
	* @var string
	*/
	public $name;

	/*public function getValue( \ReflectionProperty $property, $object )
	{
		return parent::getValue();
	}*/

}
