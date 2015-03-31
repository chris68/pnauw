General Structure
=================

Remotes
-------

###Origin

The github repository where the project is hosted

 * origin	https://github.com/chris68/pnauw (fetch)
 * origin	https://github.com/chris68/pnauw (push)

###yii2-app-advanced

The gibhub repository where the yii2-app-advanced template is hosted; this is needed to merge in changes via cherry pick

 * yii2-app-advanced	https://github.com/yiisoft/yii2-app-advanced (fetch)
 * yii2-app-advanced	https://github.com/yiisoft/yii2-app-advanced (push)

Add this remote via:
```
git remote add yii2-app-advanced https://github.com/yiisoft/yii2-app-advanced
git config remote.yii2-app-advanced.tagopt --no-tags
```
The no-tags option is necessary so that the tags defined in the Yii framework are not fetched to our local repo
Branches
--------

###master
The standard master branch

###support_for_i18n
Special branch to track the changes on top of the rather clean yii2-app-advanced template to support i18n
Eventually became a pull request for yii2-app-advanced

Handling
========

Merge in changes from yii2-app-advanced
---------------------------------------

 * Check and write down as *CommitOld* (via `git log` or `git log-pretty-abs`) the **current** top-most commit of yii2-app-advanced/master
 * Execute `git fetch -t yii2-app-advanced`
 * Check and write down as *CommitNew* the **now** top-most commit of yii2-app-advanced/master
 * Then `git cherry-pick -e -x` all the commits which are new; do this best copy and past directly from github
 * It is likely that you get conflicts; resolve them
 * Check the results and commit them; due to the -x the cherrypicked sha will be included; due to the -e you have the chance to review at all!
 * Check the log and see that the commits are now on master!

Alternative way:

 * Goto to the checkout yii2-app-advanced
 * Execute `git fetch -t`
 * Excecute `git diff tag_from tag_to -- > the-patch.diff` (tag_from / tag_to are the revision tags, e.g. 2.0.2
 * Check via `git log-pretty-abs` the changes; take especial care for moved files!
 * Install the patch via netbeans
 * Check to output window/tab to see whether all patches are executed!
 * Check the results and commit them
