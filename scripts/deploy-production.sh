#!/bin/bash
# @link https://gist.github.com/domenic/ec8b0fc8ab45f39403dd
set -e # Exit with nonzero exit code if anything fails

TARGET_BRANCH="production"

# Pull requests and commits to other branches shouldn't try to deploy, just build to verify
if [ "$TRAVIS_PULL_REQUEST" != "false" -o "$TRAVIS_BRANCH" != "$SOURCE_BRANCH" ]; then
    echo "Skipping deploy; just doing a build."
    doCompile
    exit 0
fi

# Save some useful information
REPO=`git config remote.origin.url`
SSH_REPO=${REPO/https:\/\/github.com\//git@github.com:}
SHA=`git rev-parse --verify HEAD`

ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_STABLE/wp-content/themes/schlicht" && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_TRUNK/wp-content/themes/schlicht" && rsync -ravq -e ssh --exclude='.git/' --exclude='.dpl/' --exclude=node_modules/ --exclude=gulpfile.js --exclude=.gitignore --exclude=deploy_rsa.enc --exclude='scripts/' --exclude=package.json --exclude='.travis.yml' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_TRUNK/wp-content/themes/schlicht && rsync -ravq -e ssh --exclude='.git/' --exclude='.dpl/' --exclude=node_modules/ --exclude=gulpfile.js --exclude=.gitignore --exclude=deploy_rsa.enc --exclude='scripts/' --exclude=package.json --exclude='.travis.yml' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_STABLE/wp-content/themes/schlicht && rsync -ravq -e ssh --exclude='.git/' --exclude='.dpl/' --exclude=node_modules/ --exclude=gulpfile.js --exclude=.gitignore --exclude=deploy_rsa.enc --exclude='scripts/' --exclude=package.json --exclude='.travis.yml' --delete-excluded ./ $STAGING_SERVER_USER@$STAGING_SERVER:$STAGING_PATH_HTML/wp-content/themes/schlicht && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser" && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp" && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mkdir -p $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht" && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "mv $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht && cp -Rf $STAGING_PATH_HTML/wp-content/themes/schlicht $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser/schlicht" && ssh -p22 $STAGING_SERVER_USER@$STAGING_SERVER "rm -rf $STAGING_PATH_HTML/wp-content/themes-for-docblock-parser-tmp/_old-schlicht" && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar --silent && chmod +x wp-cli.phar && php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=dev.florianbrinkmann.de --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet && php wp-cli.phar parser create wp-content/themes-for-docblock-parser/ --user=florian --url=dev.florianbrinkmann.de/en --allow-root --ssh=$STAGING_SERVER_USER@$STAGING_SERVER$STAGING_PATH_HTML/ --quiet


# Now let's go have some fun with the cloned repo
git config user.name "Travis CI"
git config user.email "$COMMIT_AUTHOR_EMAIL"

# If there are no changes to the compiled out (e.g. this is a README update) then just bail.
if git diff --quiet; then
    echo "No changes to the output on this push; exiting."
    exit 0
fi

# Commit the "changes", i.e. the new version.
# The delta will show diffs between new and old versions.
git add .

# remove scripts folder and .travis.yml from commit
git reset -- scripts/*
git reset -- node_modules/*
git reset -- .travis.yml
git reset -- .gitignore
git reset -- deploy_rsa.enc
git reset -- gulpfile.js
git reset -- package.json

git commit -m "Deploy to production branch: ${SHA}"

# Now that we're all set up, we can push.
git push $SSH_REPO $TARGET_BRANCH
