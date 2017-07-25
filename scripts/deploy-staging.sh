#!/bin/bash

ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_STABLE/wp-content/themes/schlicht"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_TRUNK/wp-content/themes/schlicht"
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_TRUNK/wp-content/themes/schlicht
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_STABLE/wp-content/themes/schlicht
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_HTML/wp-content/themes/schlicht
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mv $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht && cp -Rf $STAGING_PATH_HTML/wp-content/themes/schlicht $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "rm -rf $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht"
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar --silent && chmod +x wp-cli.phar
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-function' --format=ids) --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-method' --format=ids) --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-class' --format=ids) --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-hook' --format=ids) --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-function' --format=ids) --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-method' --format=ids) --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/  --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-class' --format=ids) --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
php wp-cli.phar post delete $(php wp-cli.phar post list --post_type='wp-parser-hook' --format=ids) --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet
