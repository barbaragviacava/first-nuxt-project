#!/bin/sh

cd /app

if [ ! -d "/app/node_modules" ] 
then
    yarn install
fi

yarn dev