#!/usr/bin/env bash

composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

composer run tests
