# Drupal core dev with lando

Since I infrequently work on Drupal core, I find it difficult to get in the
swing of working on Drupal core issues. Working on Drupal core is not like working
on an existing website project for various reason.

The most obvious reason is that the file structure is different. A standard site will put
Drupal core in `./vendor` and `./web/core` but when you work on core you may just have
the Drupal repository with `./core` with `./vendor` containing a subset of typical tools.

So for example, when working on a site you can add Drush via `composer.json` of your
composer scaffold. Drupal core development generally doesn't use a scaffold and
if you add Drush via core's  `composer.json` you start to dirty up your git clone.
Core developers have various strategies and preferences, as I have discovered, and there
are a few variations in how they work.

My preference is to keep my Drupal core clone as clean as possible in a sandbox that has 
convenience commands. When I start to work on an issue I don't want to remember what
I was working on last time, what I customised and why. I might want to destory my git clone
completely and start again.

I also prefer to let Lando handle local dev stacks. This keeps my tooling the same across
various projects. Some core developers might suggest using pure php/sqllite (no docker), or
to install with `core/scripts/test-site.php` script that creates new `sites/simpletest/*`
installations. I prefer a site that I can install and reinstall with drush that is always
at `https://coredev.lndo.site` and maps to `sites/default`.

## Key tasks

I put the main convenience commands in `.ahoy.yml`. Even if I don't run commands via `ahoy`,
these helpers double as documentation for how to achieve certain outcomes - I need these
reminders if it's been months since I worked on Drupal core.

```
ahoy setup
```

Installs Drush at `./vendor/bin/drush` and then clones Drupal. I am just cloning Drupal core
into `drupal-91x` which is excluded in `.gitignore`. There is a symlink from `_` to this
directory. All the other `ahoy` commands point to symlink. So yeah, if you're working on
Drupal 10.7 then probably I'm not yet.

```
ahoy reset
```

This goes into the the Drupal clone and hard resets it. You are likely to lose work
running this command if you're used to leaving patches lying around in your
repo clone. It also wipes the `sites/default` directory.

```
ahoy install
```

Copies the settings.php file from the root of this repo and installs Drupal. 🥂 
Gives a login link. 

```
ahoy drush
```

Runs a drush command against the Drupal site. Basically it just runs `lando drush`
passing in the root location and uri.

```
ahoy patch SOMEURL
```

Get a URL to a patch (say from Drupal.org) and apply it.


