#!/bin/bash
#
# Deployment Script

ssh ${ssh_user}@${deploy_host} 'mkdir -p ~/deploy'

rsync -a --quiet --delete-after --exclude .git* ${TRAVIS_BUILD_DIR}/ ${ssh_user}@${deploy_host}:~/deploy

echo ${deploy_path}

ssh ${ssh_user}@${deploy_host} 'sudo cp -a ~/deploy/. ${deploy_path}/'
ssh ${ssh_user}@${deploy_host} 'sudo chown -vRP --preserve-root ${site_owner}:${site_owner} ${deploy_path}'
