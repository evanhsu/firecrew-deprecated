#!/bin/bash
#
# Deployment Script

ssh $ssh_user@$deploy_host 'mkdir -p ~/deploy'
echo ${TRAVIS_BUILD_DIR}
rsync -a --quiet --delete-after --exclude .git* $TRAVIS_BUILD_DIR/ $ssh_user@$deploy_host:~/deploy

ssh $ssh_user@$deploy_host 'sudo cp -a ~/deploy/. $deploy_path/ && sudo chown -R $site_owner:$site_owner $deploy_path/'
