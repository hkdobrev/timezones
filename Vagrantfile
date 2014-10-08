# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

PROJECT_NAME = "timezones"
PROVISION_SCRIPT_PATH = "provision/provision.sh"
PRIVATE_NETWORK_IP = "192.168.99.10"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "ubuntu/precise64"

  # The hostname the machine should have. Defaults to nil.
  # If nil, Vagrant won't manage the hostname.
  # If set to a string, the hostname will be set on boot.
  config.vm.hostname = PROJECT_NAME

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: PRIVATE_NETWORK_IP

  # If true, then any SSH connections made will enable agent forwarding.
  # Default value: false
  config.ssh.forward_agent = true

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder Dir.pwd, "/vagrant", type: "nfs"

  # Cache some dependencies on the host to reduce waiting time
  # http://fgrehm.viewdocs.io/vagrant-cachier
  if Vagrant.has_plugin?("vagrant-cachier")
    config.cache.scope = :box
    config.cache.auto_detect = false

    # Enable buckets
    config.cache.enable :apt
    config.cache.enable :apt_lists
    config.cache.enable :composer

    config.cache.synced_folder_opts = {
      type: :nfs,
      mount_options: ['rw', 'vers=3', 'tcp', 'nolock']
    }
  end

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
    # Use VBoxManage to customize the VM. For example to change memory:
    vb.customize [
      "modifyvm", :id,
      "--memory", "1024",
      "--name", PROJECT_NAME.capitalize,
      "--natdnshostresolver1", "on"
    ]
  end
  #
  # View the documentation for the provider you're using for more
  # information on available options.

  # The shell provisioner allows you to upload and
  # execute a script within the guest machine.
  config.vm.provision "shell", path: PROVISION_SCRIPT_PATH, privileged: false, args: PROJECT_NAME

end
