#!/usr/bin/env bash

composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

(trap 'kill 0' SIGINT; composer run phpmd:github & composer run phpstan:github & wait)
