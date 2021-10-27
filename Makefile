install:
	cp .env.example .env && composer install
test:
	./vendor/bin/phpunit ./tests