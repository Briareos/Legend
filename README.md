# Development environment setup

## Table of Contents
1. [Vagrant machine](#vagrant-machine)
2. [Adding a new project](#adding-a-new-project)
3. [Cloning the repo from Codebase](#cloning-the-repo-from-codebase)

## Vagrant machine

### Requirements
* [Vagrant](http://vagrantup.com/downloads.html) - tested with `1.7.3`
* [Virtualbox](https://www.virtualbox.org/wiki/Downloads) - tested with `4.3.30`
* Git

### Other prerequisites
 - Enable Virtuelization in BIOS
 - You need to install the certificates listed [here](https://github.com/Briareos/Legend/tree/master/ansible/roles/legend/files/ssl), in order to use SSL on your projects.

### Setup
 - Clone the [Legend](https://github.com/briareos/Legend) repository to a local folder.

```
git clone https://github.com/briareos/Legend
```
- Create a directory `shared` on the same level as the `Legend` folder.

```
.
??? Legend
??? shared
```

3. Start the Vagrant machine while inside the `Legend` directory.

```
vagrant up
```

---

## Adding a new project

### Clone Project

- Clone the repo from Codebase (see Cloning the repo from Codebase for reference)

```
git clone git@codebasehq.com:[company-name]/[project-name]/[repo-name].git
```

###Vagrant configuration


- SSH into the Legend Vagrant machine. Password is `vagrant`.

```
ssh -p 2222 vagrant@127.0.0.1
```


- Create a new nginx site configuration

```
cd /etc/nginx/sites-available && sudo touch [project-name]
```

- Edit the `[project-name]` file in the /etc/nginx/sites-available with the editor of choice.

```
sudo nano /etc/nginx/sites-available/[project-name]
```

- Paste the following content into the `[project-name]` configuration file.

```
server {
    server_name [project-name].dev.localhost;
    root /home/vagrant/www/[project-name]/web;
    include snippets/symfony.conf;
}

server {
    listen 443;
    server_name [project-name].dev.localhost;
    root /home/vagrant/www/[project-name]/web;
    include snippets/symfony.conf;
    include snippets/dev-localhost-ssl.conf;
}
```

- Create a symbolic link of the new nginx site configuration file to the `sites-enabled` directory.

```
sudo ln -s /etc/nginx/sites-available/[project-name] /etc/nginx/sites-enabled/[project-name]
```

- Restart the nginx server

```
sudo service nginx restart
```

- Create an empty directory for the new project

```
mkdir ~/www/[project-name]
```

### Project Configuration
Open project in PHPStorm

#### Enable Symfony plugin 
- Go to: `Settings>Other Settings>Symfony2 Plugin`
- Check: Enable Plugin for this Project


#### Add Server
- Go to: `Settings>Build, Execution, Deployment>Deployment>Add`
- Configure new Deploymnet Server:
    - Name: "Vagrant - [project-name]"
    - Connection:
        - SFTP host: localhost
        - Port: 2222
    	- Root Path: /home/vagrant/www/[project-name]
    	- Username: vagrant
    	- Password: vagrant
    	- Save password: true
    	- Web Server Root URL: http://[project-name].dev.localhost
    - Mappings:
    	- Deployment path: /
    - Excluded paths:
    	- Add deployment path:
    	```
    	/var/cache/prod
    	/var/cache/test
    	/var/cache/dev/annotation
    	/var/cache/dev/doctrine
    	/var/cache/dev/profiler
    	/var/cache/dev/twig
    	/vendor
    	```
	
#### Setup Automatic Deployment 
- Go to: `Settings>Build, Execution, Deployment>Deployment>Options`
- Upload changed files automatically to the default server: Always

#### Composer install
- Upload project
- Run on local: `composer install --ignore-platform-reqs --no-autoloader --no-scripts`
- Run on vagrant: `composer install`
- (Optional) Download Project from server (for script generated files, eg. parameters.yml)

#### Setup XDebug
- Go to: `Languages & Frameworks > PHP > Servers > New`
- Configure new Server:
    - Name: [project-name]
    - Host: [project-name].dev.localhost
    - Port: 80
    - `Check` Use path mappings: 
	    - [local-path] -> /home/vagrant/www/[project-name]

#### Run project specific migration scripts
- Sky is the limit here.

---

## Cloning the repo from Codebase

### Generate SSH key

In order the clone the Codebase repository, first we need to generate the SSH key if we don't already have one.

Windows users need to execute the following commands from the Git Bash commandline.

```
ssh-keygen -t RSA
```

Press enter to accept the default values of all options and continue.

### Add the SSH key to the Codebase account

1. Copy the entire contents of the `.ssh/id_rsa.pub` relative to your home directory.
2. Paste the public key contents to the SSH Public Keys section of the My Profile tab in Codebase.

### Clone the repo!

Get the complete Git URL from the start page of the repository on Codebase.
It should look something like this `git@codebasehq.com:test-company/test-project/test-repo.git`.

Clone the repository to the directory of your choice on the host machine.

```
git clone [git-url]
```
