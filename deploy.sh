#!/usr/bin/bash

#
# example project folder
# /var/site
#       .env
#       deploy.sh
#       www -> www0
#       www0
#       www1
#
#  need copy deploy.sh to ../../ ( from /var/site/derdek.fun/docker-config/ to /var/site )
#

VERSION=`cat version`
FOLDER="www${VERSION}"

GITHUB_USER=derdek
GITHUB_REPOSITORY=derdek.fun

if [[ "$VERSION" == "0" ]]; then
  VERSION="1"
else
  VERSION="0"
fi

NEW_FOLDER="www${VERSION}"

echo "${VERSION}" > version

git clone git@github.com:${GITHUB_USER}/${GITHUB_REPOSITORY}.git

rm -Rf ${NEW_FOLDER}/*
rm -Rf ${GITHUB_REPOSITORY}/.git
mv ${GITHUB_REPOSITORY}/* ${NEW_FOLDER}
rm -Rf ${GITHUB_REPOSITORY}

cp .env ${NEW_FOLDER}/.env

docker run \
    --name composer \
    --rm \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/app \
    -d composer \
    composer install --no-interaction --no-dev --prefer-dist

docker run \
    --name composer \
    --rm \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/app \
    -d composer \
    php artisan migrate --force

docker run \
    --name composer \
    --rm \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/app \
    -d composer \
    php artisan optimize 

rm www && ln -s ${NEW_FOLDER} www
