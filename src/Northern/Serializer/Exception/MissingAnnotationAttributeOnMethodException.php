<?php

namespace Northern\Serializer\Exception;

use Northern\Serializer\Error;

class MissingAnnotationAttributeOnMethodException extends SerializerException {
	
	public function __construct( $attribute, $method, \Exception $previous = NULL )
	{
		parent::__construct("Missing attribute '{$attribute}' in annotation on method '{$method}'.", Error::MISSING, $previous);
	}

}
