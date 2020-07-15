# Drupal core dev with lando

This is not a framework, rather it captures my steps to set up Drupal core development.
You're welcome to try it and offer PRs. I'm @sime in Drupal Slack #australia-nz.

## Quick steps

```
git clone
ahoy setup          # Destructive of anything that might be in ./drupal-91x.
ahoy install        # Should get a login url.
ahoy drush status   # Should show a functioning site.
ahoy patch SOMEURL  # See notes.
```

## Some detail

Since I infrequently work on Drupal core, I find it difficult to get in the
swing of working on Drupal core issues. Working on Drupal core is not like working
on an existing website project for various reasons.

The most obvious reason is that the file structure is different. A standard site will put
Drupal core in `./vendor` and `./web/core` but when you work on core you may just have
the Drupal repository with `./core` with `./vendor` at the top level.

Normally you would add Drush via `composer.json` of your composer scaffold. Drupal core
development generally doesn't use a scaffold because you want to keep it as stand-alone
as possible. So if you added Drush via core's  `composer.json` you start to dirty up your
git clone and you introduce a lot of dependencies (and possible composer conflicts).

Core developers seem to have their own tricks, but my preference is to keep my Drupal clone
as clean as possible in a sandbox (this repo) with some helpful tooling. When I start to work on an
issue I don't want to remember what I was working on last time, what I customised and why.
I might want to destroy my setup completely and start again.

While some devs like to use sqlite and other tools, I prefer to let Lando handle local
dev stacks. This keeps my tooling the same across various projects. I prefer a site that I
can install and reinstall with drush that is always at `https://coredev.lndo.site` and
maps to `sites/default`.

## Key tasks

I put the main convenience commands in `.ahoy.yml` but I don't alway use them. These helpers
double as documentation for how to achieve certain outcomes - I need these reminders
if it's been months since I worked on Drupal core.

```
ahoy setup
```

Destructive. Installs Drush at `./vendor/bin/drush` and then (re)clones Drupal. I am just
cloning Drupal core into `drupal-91x` which is excluded in `.gitignore`. There is a symlink
from `_` to this directory. All the other `ahoy` commands point to symlink. This is a bit
messy but fine for now.

```
ahoy reset
```

This basically hard resets the Drupal clone and cleans up the sites directory. You are likely
to lose work running this command if you're used to leaving patches lying around in your
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

Get a URL to a patch (say from Drupal.org) and apply it. This is the way I usually work
applying patches.

## Run tests

The correct SIMPLETEST environment settings should be in the container courtesy of the `.lando.yml`
There is a separate database server `testdb` for the tests - not that this is really
needed because of database prefixing - so tests should "just work".

So to run some tests:

```
lando ssh
cd _/core
../vendor/bin/phpunit modules/user/tests/src/Functional/UserCreateTest.php
../vendor/bin/phpunit modules/user/tests/src/FunctionalJavascript/RegistrationWithUserFieldsTest.php
```
