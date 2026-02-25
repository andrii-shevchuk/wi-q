# Default PHP service name
PHP_SERVICE=php

# -----------------------------
# Run interactive PHP CLI
# -----------------------------
cli:
	docker-compose run --rm $(PHP_SERVICE) bash

# -----------------------------
# Run a PHP script
# Usage: make run SCRIPT=run.php
# -----------------------------
run:
	@echo "Running script $(SCRIPT)..."
	docker-compose run --rm $(PHP_SERVICE) php $(SCRIPT)

# -----------------------------
# Run PHP server
# -----------------------------
up:
	@echo "Starting PHP server on http://localhost:8080 ..."
	docker-compose up $(PHP_SERVICE)

# -----------------------------
# Run PHP server in background (detached)
# -----------------------------
up-bg:
	@echo "Starting server in background on http://localhost:8080 ..."
	docker-compose up -d $(PHP_SERVICE)

# -----------------------------
# Stop PHP mock server
# -----------------------------
server-stop:
	docker-compose stop $(PHP_SERVICE)

# -----------------------------
# Install Composer dependencies
# -----------------------------
composer-install:
	docker-compose run --rm $(PHP_SERVICE) composer install

# -----------------------------
# Update Composer dependencies
# -----------------------------
composer-update:
	docker-compose run --rm $(PHP_SERVICE) composer update

# -----------------------------
# Run PHPUnit tests
# -----------------------------
.PHONY: test

test:
	docker-compose run --rm $(PHP_SERVICE) ./vendor/bin/phpunit test

# -----------------------------
# Build the Docker image
# -----------------------------
build:
	docker-compose build

# -----------------------------
# Clean Composer cache (optional)
# -----------------------------
composer-clean:
	docker-compose run --rm $(PHP_SERVICE) composer clear-cache

# -----------------------------
# Fix PHP code style
# -----------------------------
fix:
	docker-compose run --rm php ./vendor/bin/php-cs-fixer fix
