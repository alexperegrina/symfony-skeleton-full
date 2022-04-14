Vagrant.configure("2") do |config|
    config.vm.box_download_insecure = true
    config.vm.box = "ubuntu/focal64"
    config.vm.hostname = "skeleton.local"

    config.vm.synced_folder ".", "/var/www/skeleton", type: "nfs"

    config.vm.network "private_network", ip: "192.168.56.20", hostname: true

    if Vagrant.has_plugin?("vagrant-vbguest") then
        config.vbguest.auto_update = false
    end

    config.vm.define "skeleton.local" do |radar|
        radar.vm.provision "ansible" do |ansible|
            ansible.inventory_path = "ansible-vagrant/inventories/local/hosts"
            ansible.verbose = 'vvv'
            ansible.playbook = "ansible-vagrant/playbook.yml"
            ansible.limit = "all"
        end

        config.vm.provider "virtualbox" do |v|
            v.memory = 4096
            v.name = "skeleton.local"
        end
    end
end
