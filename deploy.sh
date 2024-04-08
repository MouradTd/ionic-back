#!/bin/bash

FRONT_END_REPO="git@gitlab.com:neweracom/frontend_erp.git"
BACK_END_REPO="git@gitlab.com:neweracom/erp_backend.git"


#deploy frontend
FRONT_END_DIR="/opt/scripts/erp/frontend_erp"
BACK_END_DIR="/opt/scripts/erp/erp_backend"

APACHE_BACK_END_DIR="/var/www/html/apis/erp"
ENV_DIR="/opt/scripts/env"

# remove the dir erp if exits
if [ -d "erp" ]; then
  rm -rf erp
fi

# remove the old production dir if exits
if [ -d "$APACHE_BACK_END_DIR" ]; then
  rm -rf "$APACHE_BACK_END_DIR"
fi


echo "Cloning the the code source from git repository"

git clone --branch main "$FRONT_END_REPO" "$FRONT_END_DIR"
git clone --branch main "$BACK_END_REPO" "$BACK_END_DIR"

echo "start deploying the back-end"

cd "$BACK_END_DIR"

cp "$ENV_DIR"/.env.backend .

mv .env.backend .env

cp -rf . "$APACHE_BACK_END_DIR"

#change the owner of the dir to www-data
chown -R www-data:www-data "$APACHE_BACK_END_DIR"

cd "$APACHE_BACK_END_DIR"

echo "installing composer dependencies"

composer install --no-interaction --optimize-autoloader --no-dev

php artisan passport:install 

php artisan key:generate

systemctl restart apache2

echo "back-end deployed successfully"

#deploy front-end
echo "start deploying the front-end"
cd "$FRONT_END_DIR"

#remove the old container if exist add the if condition
docker rm -f $(docker ps -a -q --filter ancestor=erp-front-end --format="{{.ID}}")
docker build -t erp-front-end .
docker run -d -p 80:80 erp-front-end

echo "front-end deployed successfully"