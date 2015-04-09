The Software Sustainability Institute / Seme4 Consultancy
=========================================================

A collaboration between [The Software Sustainability Institute](http://www.software.ac.uk) and [Seme4](http://www.seme4.com) looking at [sameAs Lite](https://github.com/seme4/sameas-lite).

The aims of the collaboration are as follows.

**Open source project review**: A report with recommendations on:

* How openness and community engagement can be supported.
* Licencing options e.g. MIT licence or GPL, Apache or BSD, dual licencing etc.

**Deployer and developer requirements**: A short summary of what resources are needed to review sameAs Lite from a deployer and a developer perspective (e.g. installation instructions)

**Deployer experience review**: A report on experiences of downloading and deploying sameAs Lite with recommendations as to how deployment can be improved.

**Developer experience review**: A report on experiences of setting up a local development/build/test environment for working on sameAs Lite with recommendations on:

* How the developer experience of sameAs Lite can be improved.
* How best to host the core and application functionality - in a single repository, as at present, or in two repositories.
* How to ensure developers do not degrade the performance of the core library.
* The importance of unit tests for third-party developers.

**Database-agnostic core library design**: A report on how the sameAs Lite core library could be refactored to be database agnostic, supporting both MySQL and SQLite, without degrading performance.

For more information, please see the Institute's "[who do we work with - Seme4](http://www.software.ac.uk/who-do-we-work/seme4)" page.

Reports:

* [Open source project review](./open-source/OpenSourceProjectReview.md)
* [Deployer and Developer Review](./DeployerDeveloperReview.md)

Sample documentation:

* [sameAs Lite concepts](./Concepts.md) - sameAs Lite concepts and database schema.
* [Deployer's Guide](./DeployersGuide.md)
* [Set up development environment](SetupDevelopment.md)
* [Day-to-day development](./DayToDayDevelopment.md)
* [Deployer and Developer Reference](./Reference.md) - useful operating system-specific information for both deployers and developers.
* [REST API examples](./RESTAPIexamples.md) - examples of invocations of sameAs Lite REST endpoints, and examples of what they return, which can be useful for deployers and developers.
