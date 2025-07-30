# Ustawienia
PHP = php
COMPOSER = composer
DOCKER = docker compose
PHPSTAN = vendor/bin/phpstan
PHPUNIT = vendor/bin/phpunit

all: help

up:
	$(DOCKER) up -d

stop:
	$(DOCKER) stop

down:
	$(DOCKER) down

bash:
	$(DOCKER) exec php bash

install:
	$(COMPOSER) install

phpstan:
	$(PHPSTAN) analyse -c phpstan.neon --autoload-file=vendor/autoload.php --memory-limit=1G

test:
	$(PHPUNIT)

cs-fix:
	vendor/bin/php-cs-fixer fix --allow-risky yes

clean:
	rm -rf var/cache/*
	$(PHPSTAN) clear-result-cache || true

help:
	@echo "Dostępne komendy:"
	@echo "  make install     – Instalacja zależności przez Composer"
	@echo "  make phpstan     – Uruchomienie PHPStan"
	@echo "  make test        – Uruchomienie testów PHPUnit"
	@echo "  make cs-fix      – Formatowanie kodu (PHP-CS-Fixer)"
	@echo "  make clean       – Czyszczenie cache"