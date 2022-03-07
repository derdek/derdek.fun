#!/usr/bin/bash

set -e -u

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

PROJECT_NAME="derdek.fun"

VERSION=$(cat version)

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

rm -Rf ${NEW_FOLDER}
rm -Rf ${GITHUB_REPOSITORY}/.git
mv ${GITHUB_REPOSITORY} ${NEW_FOLDER}
rm -Rf ${GITHUB_REPOSITORY}

cp .env ${NEW_FOLDER}/.env

echo " === install php dependencies === "

docker run \
    --name composer \
    --rm \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/app \
    -i composer \
    composer install --no-interaction --no-dev --prefer-dist

#~ echo " === install JavaScript modules === "

#~ docker run \
    #~ --name node \
    #~ --rm \
    #~ -w /app \
    #~ --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/app \
    #~ -i node:16.13.1-alpine3.14 \
    #~ sh -c "npm install && npm run prod"

echo " === migrations === "

docker run \
    --name migration_container \
    --rm \
    --network work-network \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/www/${PROJECT_NAME}/www \
    -i derdek/php-fpm-8:1 \
    php /www/${PROJECT_NAME}/www/artisan migrate --force

echo " === clear cache === "

docker run \
    --name optimizer \
    --rm \
    --network work-network \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/www/${PROJECT_NAME}/www \
    -i derdek/php-fpm-8:1 \
    php /www/${PROJECT_NAME}/www/artisan optimize

echo "optimized"

docker run \
    --name optimizer \
    --rm \
    --network work-network \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/www/${PROJECT_NAME}/www \
    -i derdek/php-fpm-8:1 \
    php /www/${PROJECT_NAME}/www/artisan config:cache

echo "config cached"

docker run \
    --name optimizer \
    --rm \
    --network work-network \
    --mount type=bind,source="$(pwd)"/${NEW_FOLDER},target=/www/${PROJECT_NAME}/www \
    -i derdek/php-fpm-8:1 \
    php /www/${PROJECT_NAME}/www/artisan route:cache

echo "route cached"

ln -sfT ${NEW_FOLDER} www

docker restart php-fpm nginx
