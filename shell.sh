#!/usr/bin/env bash

# This script runs a PHP 7.0.33 CLI container with the current directory mounted as /app.

set -euo pipefail

docker build -t digitickets-jwt .

docker run --rm -it \
  -v "$(pwd):/app" \
  -w /app \
  digitickets-jwt bash
