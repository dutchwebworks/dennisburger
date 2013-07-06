#!/bin/sh
CURRENT_DIR=$(dirname $_)
cd $CURRENT_DIR
sass --style expanded -f --update ./:../css