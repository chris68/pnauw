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
 * Execute `git fetch yii2-app-advanced`
 * Check and write down as *CommitNew* the **now** top-most commit of yii2-app-advanced/master
 * Then `git cherry-pick -e -x` all the commits which are new; do this best copy and past directly from github
 * It is likely that you get conflicts; resolve them
 * Check the results and commit them; due to the -x the cherrypicked sha will be included; due to the -e you have the chance to review at all!
 * Check the log and see that the commits are now on master!

