* Ensure presence of directory `../shared` (until Vagrant 1.7.3 that creates it automatically).
* Ensure presence of HOME environmental variable.
* ConEmu shortcut:

        ssh vagrant@localhost -p2222 -i~/Workspace/legend/vagrant/insecure_private_key -new_console:C:"C:/Users/Gray/Workspace/legend/vagrant/admin/favicon.ico"

* If using [Powerline]() install fonts from https://github.com/powerline/fonts

## Project setup guides

### Symfony setup guide

1. Install PHP and Composer on your host machine and add them to the PATH.
1. Create/clone your project in any directory on your host machine.
1. Add a deployment machine in PhpStorm.
1. Exclude the following paths from deployment:

        /var/cache/prod
        /var/cache/test
        /var/cache/dev/annotation
        /var/cache/dev/doctrine
        /var/cache/dev/profiler
        /var/cache/dev/twig
        /vendor
1. Deploy (upload) the project.
1. Turn on automatic synchronization.
1. On host machine run `composer install --ignore-platform-reqs --no-autoloader --no-scripts`
1. On guest machine run `composer install`
