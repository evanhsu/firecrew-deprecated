ssh evan@smirksoftware.com 'mkdir -p ~/deploy'

rsync -av --progress --delete-after $TRAVIS_BUILD_DIR $ssh_user@$deploy_host:~/deploy

ssh evan@smirksoftware.com 'sudo cp -a ~/deploy/. /home/firecrew/sites/firecrew.smirksoftware.com/ && sudo chown -R firecrew:firecrew /home/firecrew/sites/firecrew.smirksoftware.com/'
