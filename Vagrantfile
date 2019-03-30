# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

NAME = "docx-template-to-pdf"
IP = "192.168.56.222"


$once = <<-SCRIPT
sudo ln -sf /usr/share/zoneinfo/Poland /etc/localtime
sudo apt update
export DEBIAN_FRONTEND=noninteractive && sudo -E apt-get install -q -y --force-yes curl php5-cli libreoffice zip unzip

cd /vagrant
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

cd /vagrant && php composer.phar install
SCRIPT

$always = <<-SCRIPT
cd /vagrant && sudo php -S 0.0.0.0:80 /vagrant/index.php &
SCRIPT


Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = "bento/debian-8"
    config.vm.hostname = NAME

    config.vm.provider "virtualbox" do |vb|
        vb.name = NAME
        vb.memory = "512"
        vb.customize ["modifyvm", :id, "--vram", "6"]
    end

    config.vm.network "private_network", ip: IP
    config.ssh.forward_agent = true
    config.vm.synced_folder ".", "/vagrant", type: "virtualbox"
    config.vm.provision "shell", inline: $once, privileged: true, run: 'once'
    config.vm.provision "shell", inline: $always, privileged: true, run: 'always'
end
