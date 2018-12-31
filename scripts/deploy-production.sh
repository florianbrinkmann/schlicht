#!/bin/bash

ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes/schlicht"
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER:$PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht
rsync -avq -e ssh ./schlicht.zip $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER:$PRODUCTION_DOWNLOADS_PATH
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mv $PRODUCTION_PATH_HTML/wp-content/themes/schlicht $PRODUCTION_PATH_HTML/wp-content/themes/_old-schlicht && mv $PRODUCTION_PATH_HTML/wp-content/themes/_tmp-schlicht $PRODUCTION_PATH_HTML/wp-content/themes/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "rm -rf $PRODUCTION_PATH_HTML/wp-content/themes/_old-schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mkdir -p $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "mv $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht && cp -Rf $PRODUCTION_PATH_HTML/wp-content/themes/schlicht $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht"
ssh -p22 $PRODUCTION_SERVER_USER@$PRODUCTION_SERVER "rm -rf $PRODUCTION_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht"
