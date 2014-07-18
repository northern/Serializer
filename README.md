# Serializer

Serializer is a small PHP library that allows you to annotate your POPO's and serialize them into a plain array.

To run the tests:

    vendor/bin/phpunit

To generate code coverage reports:

    vendor/bin/phpunit --coverage-html ./reports

Find Northern\Serializer on [Packagist](http://www.packagist.com/[todo])

## Installation

Install through Composer.

    todo

## How to use

To use Northern\Serializer you need to import it:

```PHP
use Northern\Serializer\Serializer;
```

You can now instantiate and run the serializer on any object:

    $serializer = new Serializer();

    $array = $serializer->toArray( $someObject );

However, without having annotated `$someObject`'s class, nothing will be serialized. Let's annotate the class of which `$someObject` is an instance:

```PHP
    use Northern\Serializer\Annotation as Serialize;

    class SomeClass {

      /** @Serialize\Int */
      protected $myProperty = 123;

    }
```

We have now annotated our class and indicated that the `$myProperty` attribute must be serialized as an integer. When we now serialize `$someObject` (which is assumed to be an instance of `SomeClass`) the `$array` variable will contain the serialized data:

    Array(
      [myProperty] => 123
    )

Easy as.

With Northern\Serializer you can also serialize methods. Usually a serialized method is a getter of some sort. Let's look at an example:

    use Northern\Serializer\Annotation as Serialize;

    class SomeClass {

      /** @Serialize\Int(name="myValue") */
      public function getMyValue()
      {
      	return 123;
      }

    }

As the above demonstrates, by simply adding the correct annotation to the method, the output of the method will be serialized as the key set by the annotation `name` parameter, which is `myValue` in our example:

    Array(
      [myValue] => 123
    )

If the `name` attribute is not specified on the annotation then the name of the method will be used as the serialization key, e.g:

    class SomeClass {

      /** @Serialize\Bool */
      public function isValid()
      {
      	return true;
      }

    }

Which will produce:

    Array(
      [isValid] => 1
    )

