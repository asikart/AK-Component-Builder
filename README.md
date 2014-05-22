# Asikart Extension Builder

A Rapid Application Framework & code generator(scaffolding) for Joomla!2.5, 3.x. develpoed by Asika.

## Repository Deprecated

Please see: https://github.com/ventoviro/windwalker-joomla-rad


# Getting Started

1. Download packages and copy `builder.php` and `akbuilder` dir to Joomla `cli` dir.

2. keying this command:

``` bash
$ php cli/builder.php -e com_flower -n "sakura.sakuras" -c administrator
```

will create a component named `com_flower` and two controller named `sakura`, `sakuras` in admin.

# Guide

Usage:  

```
        php builder.php <commands> [-e <extension name>] [-c <client>]
        [-n <controller name>] [-g <plugin group>] [--help]
```

## Support commands:

`project init`          Init a new extension project. It will copy extension
                        scaffold to your Joomla! site. You need to init each
                        site and administrator once.

`add subsystem`         When project already init. You can use this command
                        add two more controllers with item and list.
                        (Only for component.)

`convert template`      If you want to convert a existing extension to be
                        new scaffold, please copy all files
                        to folder: `tmpl/[extension]/init.[client]`, then use
                        this command to convert files.
        
## Params description:

    -e  is to detect extension name and type. You have to type extension prefix.
        Example: [-e com_example], [-e mod_example] , [-e plg_example].
        Then will use "xxx_" to detect extension type.
                       
    -n  this may create two controllers in item and list. You can type [-n category]
        or [-n "category.categories"] to set item and list controllers name.
                       
    -c  is to set client. Only support "site", "admin" or "administrator".
        Plugin does not need this param.
                       
    -g  is for plugin group, only plugin need this.  


## Examples:

``` bash
$ php builder.php project init -e com_bird -n wing -c administrator (or admin)
``` 

Init a component project, then add wing and wings controllers.

``` bash
    $ php builder.php add subsystem -e com_bird -n "fly.flies" -c administrator
``` 

Add fly and flies controllers to com_bird.

``` bash    
    $ php builder.php project init -e mod_fish -c site
``` 

Init a module project in site client.

``` bash    
    $ php builder.php project init -e plg_cat -g system
``` 

Init a plugin project in group system.

``` bash        
    $ php builder.php convert template -e com_flower -n sakura [-c site] [-g system]
``` 
Convert a extising component named com_flower to be new scaffold.
