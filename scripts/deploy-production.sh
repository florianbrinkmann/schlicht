#!/bin/bash

ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes/schlicht"
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER:$PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mv $PRODUCTION_PATH_HTML/wp-content/themes/schlicht $PRODUCTION_PATH_HTML/wp-content/themes/_old-schlicht && mv $PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht $PRODUCTION_PATH_HTML/wp-content/themes/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "rm -rf $PRODUCTION_PATH_HTML/wp-content/themes/_old-schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "cd $PRODUCTION_PATH_HTML/wp-content/themes/ && zip -r schlicht.zip schlicht/"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mv $PRODUCTION_PATH_HTML/wp-content/themes/schlicht.zip $PRODUCTION_DOWNLOADS_PATH/schlicht.zip"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mv $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht && cp -Rf $PRODUCTION_PATH_HTML/wp-content/themes/schlicht $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "rm -rf $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht"
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar --silent && chmod +x wp-cli.phar
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-function' --format=ids) --user=florian --url=florianbrinkmann.com --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-method' --format=ids) --user=florian --url=florianbrinkmann.com --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-class' --format=ids) --user=florian --url=florianbrinkmann.com --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-hook' --format=ids) --user=florian --url=florianbrinkmann.com --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet
php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=florianbrinkmann.com --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-function' --format=ids) --user=florian --url=florianbrinkmann.com/en --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-method' --format=ids) --user=florian --url=florianbrinkmann.com/en --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-class' --format=ids) --user=florian --url=florianbrinkmann.com/en --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-hook' --format=ids) --user=florian --url=florianbrinkmann.com/en --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet
php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=florianbrinkmann.com/en --allow-root --ssh=$PRODUCTION_SERVER_USER@$PRODUCTION_SERVER$PRODUCTION_PATH_HTML/ --quiet