# CRON-PHP ⏳

This project has been made having in mind the structure
of backend with high scalability and maintainability.
Some things to have in mind:
- The project is made using pure php without framework, becuase we don't need anything specially from them.
- The folder structure is made in a fake scenario with only one context as we have. In case of more contexts in the application, they must be between `src/` and layers folders.

## Dependencies 📚
- `leage/tactician`: command/query buses (CQRS implementation).
- `pimple/pimple`: service provider.
- `vlucas/phpdotenv`: getting vars from .env file.
- `phpunit/phpunit`: unit tests for application/domain layer.


## Installation and execution 🏗

Just run `make install` for installing dependencies. You can change anything from  generated `.env`.
Run executing the entry file `cron.php` located in the root folder of the project.


The program only expects one parameter or none. Execute the program with `-e` parameter and it will open 
the config file with the configured editor in the `.env` file. Without any parameter it will be runed as 
a normal executable file. 

In a real world sceneario it should be configured with a "daemon manager" like systemd or runit.

## Tests 🧪
For running unit tests:
```bash
make test
```
