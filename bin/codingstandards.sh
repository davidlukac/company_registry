#!/usr/bin/env bash

echo "Codesniffer:" &&
bin/phpcs --standard=PSR2 web src &&
echo "Mess Detector:" &&
bin/phpmd src/,web/ text cleancode, codesize, controversial, design, naming, unusedcode
