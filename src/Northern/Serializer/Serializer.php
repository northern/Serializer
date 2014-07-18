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

					$value = $annotation->getPropertyValue( $property, $object );

					if( $annotation instanceof Annotation\Object )
					{
						$values[ $name ] = $this->toArray( $value );
					}
					else
					if( $annotation instanceof Annotation\Collection )
					{
						$collection = $value;

						foreach( $collection as $item )
						{
							if( is_object( $item ) )
							{
								$values[ $name ][] = $this->toArray( $item );
							}
							else
							{
								$values[ $name ][] = $item;
							}
						}
					}
					else
					{
						$values[ $name ] = $value;
					}

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
						$name = $method->name;
					}

					$value = $annotation->getMethodValue( $method, $object );

					$values[ $name ] = $value;
					break;
				}
			}
		}

		return $values;
	}

}
