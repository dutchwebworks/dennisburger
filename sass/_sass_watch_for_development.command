#!/bin/sh
CURRENT_DIR=$(dirname $_)
cd $CURRENT_DIR
sass --style expanded --debug-info --watch ./:../css