<?php

namespace Northern\Serializer;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

use Northern\Serializer\Annotation;

class Serializer {

	public function __construct()
	{
		$this->registerNamespace();
	}

	public function registerNamespace()
	{
		AnnotationRegistry::registerAutoloadNamespace('Northern\Serializer\Annotation', realpath(__DIR__."/../..") );
	}

	public function toArray( $object )
	{
		$values = array();

		$reader = new AnnotationReader();

		$reflectionClass = new \ReflectionClass( $object );

		$properties = $reflectionClass->getProperties();
		$values = $values + $this->processObjectProperties( $reader, $object, $properties );

		$methods = $reflectionClass->getMethods();
		$values = $values + $this->processObjectMethods( $reader, $object, $methods );

		return $values;
	}

	public function toJson( $object )
	{
		return json_encode( $this->toArray( $object ) );
	}

	protected function processObjectProperties( AnnotationReader $reader, $object, array $properties )
	{
		$values = array();

		foreach( $properties as $property )
		{
			$annotations = $reader->getPropertyAnnotations( $property );

			if( empty( $annotations ) )
			{
				continue;
			}

			foreach( $annotations as $annotation )
			{
				if( $annotation instanceof Annotation\AnnotationInterface )
				{
					$name = $annotation->name;

					if( empty( $name ) )
					{
						$name = $property->name;
					}

					$values[ $name ] = $annotation->getPropertyValue( $property, $object );
					break;
				}
			}
		}

		return $values;
	}

	protected function processObjectMethods( AnnotationReader $reader, $object, array $methods )
	{
		$values = array();

		foreach( $methods as $method )
		{
			$annotations = $reader->getMethodAnnotations( $method );

			if( empty( $annotations ) )
			{
				continue;
			}

			foreach( $annotations as $annotation )
			{
				if( $annotation instanceof Annotation\AnnotationInterface )
				{
					$name = $annotation->name;

					if( empty( $name ) )
					{
						throw new \Exception("Annotation on method requires 'name' attribute.");
					}

					$values[ $name ] = $annotation->getMethodValue( $method, $object );
					break;
				}
			}
		}

		return $values;
	}

}
