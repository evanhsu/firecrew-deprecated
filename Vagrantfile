# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  server = Hash.new
  server["username"] = "firecrew"
  server["hostname"] = "firecrew.us.dev"
  server["box"] =  "bento/ubuntu-16.04"
  server["cpus"] = 1
  server["memory"] = 1024

  if Vagrant.has_plugin?("vagrant-hostmanager")
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.ignore_private_ip = false
    config.hostmanager.include_offline = false
  end

  config.ssh.forward_agent = true

  config.vm.define server['hostname'] do |srv|

       # General Setings
       srv.vm.box = server['box']

       # Network Settings
       srv.vm.hostname = server['hostname']
       srv.hostmanager.enabled = true
       srv.hostmanager.manage_host = true
       srv.hostmanager.ignore_private_ip = false
       srv.hostmanager.include_offline = false
       srv.vm.network "private_network", :ip => "0.0.0.0", :auto_network => true
       # srv.hostmanager.aliases = %w(config['aliases'])

       # VirtualBox settings
       srv.vm.provider :virtualbox do |vb|
         vb.name = server["hostname"]
         vb.customize ["modifyvm", :id, "--cpus", server['cpus']]
         vb.customize ["modifyvm", :id, "--memory", server['memory']]
         vb.customize ["guestproperty", "set", :id, "/VirtualBox/GuestAdd/VBoxService/--timesync-set-threshold", 60000]
         vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
         vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
       end

       # Mount local folders to VM and grant ownership to the site-user
       config.vm.synced_folder ".", "/home/#{server["username"]}/sites/#{server["hostname"]}",
         owner: server["username"],
         group: server["username"]

       # Run the Ansible playbook to provision the box
       config.vm.provision "ansible-playbook", type: "ansible" do |ansible|
         ansible.extra_vars = server
         ansible.sudo = true
         ansible.playbook = "./ansible/sharedhost.yml"
         ansible.groups = {
            "core"              => [server['hostname']],
            "http"              => [server['hostname']],
            "sql"               => [server['hostname']],
            "dev"               => [server['hostname']],
            "vagrant:children"  => ["core", "http", "sql", "dev"]
         }
       end
  end

end
