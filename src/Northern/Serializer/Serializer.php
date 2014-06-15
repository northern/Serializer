<?php

namespace Northern\Serializer;

use Doctrine\Common\Annotations;

class Serializer {

	public function __construct()
	{
		$this->registerNamespace();
	}

	public function registerNamespace()
	{
		Annotations\AnnotationRegistry::registerAutoloadNamespace('Northern\Serializer\Annotation', realpath(__DIR__."/../..") );
	}

	public function toArray( $object )
	{
		$values = array();

		$reflectionClass = new \ReflectionClass( $object );

		$properties = $reflectionClass->getProperties();
		//print_r( $properties );

		//$methods = $reflectionClass->getMethods();
		//print_r( $methods );

		$reader = new Annotations\AnnotationReader();

		foreach( $properties as $property )
		{
			$annotations = $reader->getPropertyAnnotations( $property );

			if( empty( $annotations ) )
			{
				continue;
			}

			foreach( $annotations as $annotation )
			{
				if( $annotation instanceof \Northern\Serializer\Annotation\AnnotationInterface )
				{
					$index = $annotation->name;

					if( empty( $index ) )
					{
						$index = $property->name;
					}

					$values[ $index ] = $annotation->getValue( $property, $object );
					break;
				}
			}
		}

		return $values;
	}

}
