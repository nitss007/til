# Multi-Project with Gradle

Gradle supports including other projects as dependencies. A good example for this can be found [here](https://github.com/pkainulainen/gradle-examples/tree/master/multi-project-build) as explained in the [blog post](http://www.petrikainulainen.net/programming/gradle/getting-started-with-gradle-creating-a-multi-project-build/).

The author summarises the three msot important things as:

 > - A multi-project build must have the settings.gradle file in the root directory of the root project because it specifies the projects that are included in the multi-project build.
 > - If we have to add common configuration or behavior to all projects of our multi-project build, we should add this configuration (use allprojects) to the build.gradle file of our root project.
 > - If we have to add common configuration or behavior to the subprojects of our root project, we should add this configuration (use subprojects) to the build.gradle file of our root project.

I ended up using this approach for a game I'm developing. The core module is one project and all the frontends are other projects.
