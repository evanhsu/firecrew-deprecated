# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "bento/ubuntu-16.04"

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.manage_guest = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true

  config.vm.define 'firecrew.us.local' do |node|
    node.vm.hostname = 'firecrew.us.local'
    node.vm.network :private_network, ip: '192.168.33.10'
    # node.hostmanager.aliases = %w(example-box.localdomain example-box-alias)

    # Share a folder to the guest VM. The first argument is
    # the path on the host to the actual folder. The second argument is
    # the path on the guest to mount the folder. And the optional third
    # argument is a set of non-required options.
    # Open up the permissions on the shared folder so ANYONE can write
    # because permissions can't be changed after provisioning (no chown/chmod)
    node.vm.synced_folder ".", 
    "/home/firecrew/sites/firecrew.us.local",
    mount_options: ["dmode=777", "fmode=666"]
  end

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  
  config.vm.provider "virtualbox" do |vb|
    # Display the VirtualBox GUI when booting the machine
    vb.gui = false
  
    # Customize the amount of memory on the VM:
    vb.memory = "2048"
  end
  

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "ansible/sharedhost.yml"
    ansible.inventory_path = "ansible/inventory/vagrant"
    ansible.limit = "all"
  end

end
