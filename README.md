# Drupal core dev with lando

This is not a framework, rather it captures my steps to set up Drupal core development.
You're welcome to try it and offer PRs. I'm @sime in Drupal Slack #australia-nz.

## Dependencies

This project currently assumes Lando and Ahoy. I would like to add straight docker-compose
alongside Lando.

Ahoy is just a simple command runner. I would like to move this to Lando tooling
because Ahoy isn't good for Windows.

## Quick steps

```
git clone git@github.com:simesy/coredev.git
ahoy setup          # Destructive of anything that might be in ./91x directory.
lando start         # Bring up the containers.
ahoy install        # Install Drupal at https://coredev.lndo.site and get a login url.
ahoy drush status   # Should show a functioning site.
ahoy apply SOMEURL  # See notes.
```

## Some detail

Since I infrequently work on Drupal core, I find it difficult to get in the
swing of working on Drupal core issues. Working on Drupal core is not like working
on an existing website project for various reasons.

The most obvious reason is that the file structure is different. A standard site will put
Drupal core in `./vendor` and `./web/core` but when you work on core you may just have
the Drupal repository with `./core` with `./vendor` at the top level.

And normally you would add Drush in the `composer.json` of your scaffold but Drupal core
development generally doesn't use a scaffold, so where to add Drush?

My preference is to keep my Drupal clone as clean as possible with some helpful tooling.
When I start to work on an issue I don't want to remember what I was working on last
time, what I customised and why. I might want to destroy my setup completely and start again.

Core developers usually prefer docker-compose, however I want to use Lando to keep my
tooling the same across various projects. I prefer a site that I can install and reinstall
with drush that is always at `https://coredev.lndo.site` which maps to `sites/default`.

## Workflow

In this project, the `.ahoy.yml` serves as an index of helpers task. I like these reminders
if it's been months since I worked on Drupal core.

```
ahoy setup
```

Run this after the initial clone. It installs Drush at `./vendor/bin/drush` and then
(re)clones Drupal into ./91x which is excluded in `.gitignore`.

(Of course I want to work on ./90x and ./89x, etc, but I'm not sure how I want to do this.
So right now I'm just hard-coding `91x`.)

```
ahoy reset
```

This does a hard resets the Drupal clone (but doesn't touch your installed site).

```
ahoy install
```

Resets sites/default, copies in some files from ./templates, and installs Drupal.

```
ahoy drush
```

Runs a drush command against the Drupal site, setting the right app path. It also runs
drush cr because the Drupal container can get bits of Drush stuck in it.

```
ahoy apply SOMEURL
```

Apply a patch to Drupal from a URL. Usually I do git commands directly, but this is a 
nice proof that everything is working.

## Run tests

The correct SIMPLETEST environment settings should be in the container courtesy of the
`.lando.yml`. There is a separate database server `testdb` for the tests (not that
this is really needed because of database prefixing).

To run some tests:

```
lando ssh
cd 91x/core
../vendor/bin/phpunit modules/user/tests/src/Functional/UserCreateTest.php
../vendor/bin/phpunit modules/user/tests/src/FunctionalJavascript/RegistrationWithUserFieldsTest.php
```
