<?php

namespace Northern\Serializer;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

use Northern\Serializer\Annotation;

class Serializer {

	protected static $initialized;

	protected static $annotationReader;

	public function __construct()
	{
		$this->registerNamespace();
	}

	/**
	 * This method registers the required namespace with the Doctrine annotation library.
	 */
	public function registerNamespace()
	{
		if( empty( static::$initialized ) )
		{
			AnnotationRegistry::registerAutoloadNamespace( __NAMESPACE__.'\Annotation', realpath(__DIR__."/../..") );
		}
	}

	/**
	 * This method returns a serialized PHP array of a given object.
	 *
	 * @param mixed $object
	 * @return array
	 */
	public function toArray( $object )
	{
		$values = array();

		if( empty( static::$annotationReader ) )
		{
			static::$annotationReader = new AnnotationReader();
		}

		$reader = static::$annotationReader;

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
			// Get the annotation for this property.
			$annotations = $reader->getPropertyAnnotations( $property );

			if( empty( $annotations ) )
			{
				continue;
			}

			foreach( $annotations as $annotation )
			{
				// Check if the annotation is parseble, if not, get the next one.
				if( ! $annotation instanceof Annotation\AnnotationInterface )
				{
					continue;
				}

				// If the annotation has a 'name' attribute then use that, otherwise
				// use the property name (class member) as the value key.
				$name = $annotation->name;

				if( empty( $name ) )
				{
					$name = $property->name;
				}

				// Get the value of the property.
				$value = $annotation->getPropertyValue( $property, $object );

				if( $annotation instanceof Annotation\Object )
				{
					// If $value is an object then recurse into it.
					$values[ $name ] = $this->toArray( $value );
				}
				else
				if( $annotation instanceof Annotation\Collection )
				{
					// $value is a collection, iterate through it.
					foreach( $value as $item )
					{
						if( is_object( $item ) )
						{
							// If the item is an object then we want to recurse into it.
							$values[ $name ][] = $this->toArray( $item );
						}
						else
						{
							// Other wise just add the $item value.
							$values[ $name ][] = $item;
						}
					}
				}
				else
				{
					// $value is just a simple value.
					$values[ $name ] = $value;
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
			// Get the annotations for this method.
			$annotations = $reader->getMethodAnnotations( $method );

			if( empty( $annotations ) )
			{
				continue;
			}

			foreach( $annotations as $annotation )
			{
				// Check if the annotation is parseble, if not, get the next one.
				if( ! $annotation instanceof Annotation\AnnotationInterface )
				{
					continue;
				}

				// If the annotation has a 'name' attribute then use that, otherwise
				// use the class method name as the value key.
				$name = $annotation->name;

				if( empty( $name ) )
				{
					$name = $method->name;
				}

				// Get the value of the property.
				$values[ $name ] = $annotation->getMethodValue( $method, $object );
			}
		}

		return $values;
	}

}
