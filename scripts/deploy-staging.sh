#!/bin/bash

ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_STABLE/wp-content/themes/schlicht"
ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_TRUNK/wp-content/themes/schlicht"
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_TRUNK/wp-content/themes/schlicht
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_STABLE/wp-content/themes/schlicht
rsync -ravq -e ssh --exclude-from='.rsync-exclude' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_HTML/wp-content/themes/schlicht
