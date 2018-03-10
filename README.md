[![Build Status](https://scrutinizer-ci.com/g/gplcart/omnipay_library/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gplcart/omnipay_library/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gplcart/omnipay_library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gplcart/omnipay_library/?branch=master)

Omnipay Library is a helper module for [GPL Cart](https://github.com/gplcart/gplcart) shopping cart. The main purpose of this module is to integrate [Omnipay library](https://github.com/thephpleague/omnipay). It has no UI and intended for those who develop GPL Cart payment modules

**Installation**

This module requires 3-d party library which should be downloaded separately. You have to use [Composer](https://getcomposer.org) to download all the dependencies.

1. From your web root directory: `composer require gplcart/omnipay_library`. If the module was downloaded and placed into `system/modules` manually, run `composer update` to make sure that all 3-d party files are presented in the `vendor` directory.
2. Go to `admin/module/list` end enable the module