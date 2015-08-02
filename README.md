Fluid Powered TYPO3: LLL File Writer
====================================

[![Build Status](https://img.shields.io/travis/FluidTYPO3/flll.svg?style=flat-square&label=package)](https://travis-ci.org/FluidTYPO3/flll) [![Coverage Status](https://img.shields.io/coveralls/FluidTYPO3/flll/development.svg?style=flat-square)](https://coveralls.io/r/FluidTYPO3/flll)

A development-only tool to automatically create and update `locallang.xml` and `locallang.xlf` to add any missing labels.
Every method of translation is covered - in Extbase, Fluid, TCA, FlexForms, TypoScript; litterally every method. When used, for
example `f:translate` can be used without the need for a language file. `FLLL` then creates the file and starts adding all your
labels with default values.

## WARNING! Not for use in production!

This extension updates extension files on-the-fly and as such it should **never, ever be installed in production sites**. Ignore
this advise at your own peril - remember: broken language files can break entire TYPO3 sites and it is never completely risk-free
to use automation tools such as this one.

## What does it do?

`FLLL` makes it extremely easy to work with translatable labels in TCA, Fluid, Extbase, TypoScript, FlexForms etc.

`FLLL` creates and updates TYPO3 translation files in `xml` or `xliff` format, adding any label that you attempt to use but which
does not exist. Simply put, it automatically generates default translation file values on-the-fly which you can later translate.

It triggers on every type of translation that TYPO3 can perform, from the oldest ways all the way to the very latest such as the
`f:translate` ViewHelper. This means that, for example, you can create Fluid templates which use translated labels without caring
about the contents of the translation file. When you're ready to start translating, the file will be ready for you - filled with
default label values.

> Note: because the writing happens immediately after you attempt to use a missing label, `FLLL` cannot sort out if you make a
> typo or misspell a label name. If this happens, and you already translated the label, you must fix it manually - just like you
> would do if `FLLL` was not installed: edit the file(s), rename label in every language, save.

## How does it work?

Technically: `FLLL` replaces the original TYPO3 `LocalizationFactory` class special and instead of arrays, this new class returns
proxy-type object (implementing ArrayAccess) which will always return TRUE from `offsetExists` and when reading a non-existing
label, adds this label with a default value. On request termination each proxy object then writes any new labels to language files
which are created if missing.

`FLLL` also adds new language nodes and translation files for every (active) language on your site. And naturally it preserves all
existing labels from being overwritten - it will only add labels which are truly missing.

`FLLL` does not write LLL labels for **system extensions** but it does write labels for **globally installed extensions**. If you
need to exclude a globally installed extension, use the white- and blacklisting feature.

> Note: `FLLL` will also alphabetically sort the labels it adds - this fits very well with the `prefix.labelName` syntax that
> Extbase encourages, to logically group your labels.

> Note: Translation files are **cached** in TYPO3 - you will need to clear caches to actually see the added labels. However,
> `FLLL` will not write duplicates to your files so you do not need to continually clear caches. Once in a while will suffice.

> Note: `FLLL` only triggers when your language files have been cached initially; this is done to prevent problems when rebuilding
> the language cache contents.

## How do I use it?

Simply install it - and if you wish, through Extension Manager configure `FLLL` to white- or blacklist LLL writing for individual
extension keys. `FLLL` then immediately starts updating your language files whenever TYPO3 tries to render a translated label
which does not exist in files.
