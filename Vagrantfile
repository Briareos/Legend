Vagrant.configure(2) do |config|
  # The box will be downloaded from the ooficial repo.
  config.vm.box = 'ubuntu/vivid64'
  config.vm.box_check_update = false
  # The directory must be created manually.
  config.vm.synced_folder '../shared', '/home/vagrant/shared'
  # Forwarded ports; the 'name' parameter is currently ignored, but leave it there for documentation's sake.
  config.vm.network :forwarded_port, guest: 21, host: 21, name: 'FTP'
  config.vm.network :forwarded_port, guest: 80, host: 80, name: 'HTTP'
  config.vm.network :forwarded_port, guest: 443, host: 443, name: 'HTTPS'
  # config.vm.network :forwarded_port, guest: 80, host: 8080, name: 'HTTP' # OS X Ports
  # config.vm.network :forwarded_port, guest: 443, host: 4443, name: 'HTTPS' # OS X Ports
  config.vm.network :forwarded_port, guest: 3306, host: 3306, name: 'MySQL'
  config.vm.network :forwarded_port, guest: 6379, host: 6379, name: 'Redis'
  config.vm.network :forwarded_port, guest: 27017, host: 27017, name: 'MongoDB'
  config.vm.network :forwarded_port, guest: 48261, host: 48261, name: 'PureFTPd #1'
  config.vm.network :forwarded_port, guest: 48262, host: 48262, name: 'PureFTPd #2'
  config.vm.network :forwarded_port, guest: 48263, host: 48263, name: 'Gulp'

  # Install before uncommenting: "vagrant plugin install vagrant-triggers"
  
  # Uncomment for port forwarding for OS X (tested on Yosemite).
  # Port forwarding for OS X
  # config.trigger.after [:provision, :up, :reload] do
  #     system('echo "
  #       rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 80 -> 127.0.0.1 port 8080  
  #       rdr pass on lo0 inet proto tcp from any to 127.0.0.1 port 443 -> 127.0.0.1 port 4443
  # " | sudo pfctl -ef - > /dev/null 2>&1; echo "==> Fowarding Ports: 80 -> 8080, 443 -> 4443 & Enabling pf"')  
  # end

  # config.trigger.after [:halt, :destroy] do
  #   system("sudo pfctl -df /etc/pf.conf > /dev/null 2>&1; echo '==> Removing Port Forwarding & Disabling pf'")
  # end

  # End port forwarding for OS X

  # Configure VirtualBox.
  config.vm.provider 'virtualbox' do |vb|
    # The machine name will appear like this in VirtualBox Manager.
    vb.name = 'Legend'
    vb.memory = 4096
    vb.cpus = 4
    #vb.gui = true
  end
  # Don't regenerate the SSH key, use the default one (insecure_private_key).
  config.ssh.insert_key = false
  # Fixes "stdin: is not a tty" error.
  # https://github.com/mitchellh/vagrant/issues/1673#issuecomment-28817675
  # https://www.virtualbox.org/manual/ch09.html
  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
  # Start provisioning.
  config.vm.provision 'shell', inline: <<-SHELL
    # Skips interactive configuration steps; eg. in apt-get.
    export DEBIAN_FRONTEND=noninteractive
    # http://stackoverflow.com/a/677212
    if ! hash ansible 2>/dev/null; then
      echo "Installing ansible..."
      apt-add-repository ppa:ansible/ansible > /dev/null 2&>1
      apt-get update > /dev/null
      apt-get install -y -o Dpkg::Options::="--force-confdef" -o Dpkg::Options::="--force-confnew" ansible > /dev/null 2&>1
      echo "Complete."
    fi
    echo -e '[default]\nlocalhost ansible_connection=local' > /etc/ansible/hosts
    # Enables live output of ansible-playbook
    # http://stackoverflow.com/a/19020742
    export PYTHONUNBUFFERED=1
    ansible-playbook /vagrant/ansible/playbook.yml
  SHELL
end
