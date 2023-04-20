#!/usr/bin/env bash

vendor/bin/php-cs-fixer fix
vendor/bin/phpstan analyse -l 9 src
