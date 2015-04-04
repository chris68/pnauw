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

 * You want to merge changes from a *tag-from* to a *tag-to*
 * Execute `git fetch yii2-app-advanced`
 * Gather from github the commit of the *tag-from* and the commit of the *tag-to* of yii2-app-advanced/master
 * Execute `git log-pretty-abs <commit-from>..<commit-to>`
 * Copy and paste the output to a text file and edit the textfile; throw out all commits which do not change any relevant part of our application
 * Then `git cherry-pick -e -x <commit>` all the relevant commits from the textfile
 * It is likely that you get conflicts; resolve them in netbeans (quite well supported)
 * Check the results and commit them in netbeans; due to the -x the cherrypicked sha will be included; due to the -e you have the chance to review at all!
 * Check the log and see that the commits are now on master!

