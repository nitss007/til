# forceCoversAnnotation in PHPUnit

Up until now I've always been using the `beStrictAboutCovers` in the `phpunit.xml` configuration file. Today I learned about the `forceCoversAnnotation` annotation.

The effect is similar: only the code specified by `@covers` will count towards the total code coverage. With `forceCoversAnnotation` however the `@uses` annotation is not required. I like `@uses` but if often clogs up a test class when using lots of small value objects.
