Prism Library Changelog
==========================

### v1.20
* Upgraded [VueJS](https://vuejs.org/) to v2.4.1.
* Upgraded [jQuery AutoComplete](https://github.com/devbridge/jQuery-Autocomplete) to v1.4.1.
* Upgraded [jQuery File Upload](https://github.com/blueimp/jQuery-File-Upload) to v9.18.0.
* Upgraded [SweetAlert2](https://limonte.github.io/sweetalert2/) to v6.6.5.
* Upgraded [Parsley JS](http://parsleyjs.org/) to v2.7.2.
* Improved _Prism\Payment\Result_ class. Added options to skipp some events and processes during the transaction process.
* Improved _Prism\Money_ classes.
* Added _Prism\Domain_ classes that will be used for implementing domain models based on Domain Driven Design.
* Added [Ramsey/Uuid](https://github.com/ramsey/uuid).
* Added [Hashids](https://github.com/ivanakimov/hashids.php).
* Renamed folder __libs__ to __vendor__.
* The antbuilder reworked. Now, it builds Joomla! package from current source.
* Published to Packagist. The library can be installed to any framework via Composer.

### v1.19.6
* Improved Log class.
* Upgraded [WePay PHP SDK](https://github.com/devbridge/jQuery-Autocomplete) to v0.3.1.
* Upgraded [VueJS](https://vuejs.org/) to v2.2.6.
* Upgraded [SweetAlert2](https://limonte.github.io/sweetalert2/) to v6.6.1.
* Fixed the method (_notifyAdministrator_) that sends email to the administrator if payment plugin initialization filed.

### v1.19.5
* Added [Tooltipster](http://iamceege.github.io/tooltipster/).
* Added [jQuer Expander](https://github.com/kswedberg/jquery-expander).
* Added [Modaal](http://humaan.com/modaal/).
* Added [iziModal](http://izimodal.marcelodolce.com).
* Upgraded [jQuery AutoComplete](https://github.com/devbridge/jQuery-Autocomplete) to v1.3.0.
* Upgraded [Bootstrap Datetime Picker](https://github.com/Eonasdan/bootstrap-datetimepicker) to v4.17.47.
* Improved PayPal IPN Listener.

### v1.19.4
* Added [VueJS](https://vuejs.org/).
* Added Prism\Utilities\DatabaseHelper.
* Upgraded [jQuery LoadingOverlay](http://gasparesganga.com/labs/jquery-loading-overlay/) to v1.5.3.

### v1.19.3
* Upgraded [Mollie API PHP](https://github.com/mollie/mollie-api-php) to v1.9.2 library.

### v1.19.2
* Added [Sticky Kit](http://leafo.net/sticky-kit/).

### v1.19.1
* Upgraded [jQuery Cropper](https://fengyuanchen.github.io/cropper/) to v2.3.4.
* Fixed an issue with wrong image quality when save a file.
* Improved PrismUIHelper.

### v1.19
* Added [ChartJs](http://www.chartjs.org/) to UI library.
* Added [MomentJS](http://momentjs.com/) to UI library.
* Added [League\Fractal](http://fractal.thephpleague.com/) library.
* Removed [D3](https://d3js.org/) library.
* Added class Payment\Result.
* Upgraded Coinbase library to v2.5.0.

### v1.18
* Added [Remodal](http://vodkabears.github.io/remodal/) to UI library.
* Upgraded [jQuery AutoComplete](https://github.com/devbridge/jQuery-Autocomplete) to v1.2.27.
* Upgraded [jQuery SerializeJSON](https://github.com/marioizquierdo/jquery.serializeJSON) to v2.7.2.
* Upgraded [Parsley JS](http://parsleyjs.org/) to v2.6.2.
* Added new constants.
* Fixed issues in Filesystem\Helper and File\Image classes.

### v1.17.4
* Added [LoadingOverlay](http://gasparesganga.com/labs/jquery-loading-overlay/) to UI library.
* Added [Animate](https://github.com/daneden/animate.css) and [Magic Animations](https://www.minimamente.com/example/magic_animations/) to UI library.
* Added [Favico.js](http://gasparesganga.com/labs/jquery-loading-overlay/) to UI library.

### v1.17.3
* Fixed Prism\File\Image::crop().
* Improved Prism\Utilities\NetworkHelper::isValidIp().

### v1.17.2
* It was made compatible with PHP 5.5.

### v1.17.1
* Improved classes File\Image and File\File.
* Added constants for image quality.

### v1.17
* Upgraded [Bootstrap FileInput](https://github.com/kartik-v/bootstrap-fileinput) library.
* Added [SweetAlert](http://t4t5.github.io/sweetalert/).
* Improved some classes and methods.

### v1.16
* Upgraded libraries JmesPath v2.3.0, AWS SDK v3.19.12, Flysystem v1.0.27, Flysystem AWS-v3-S3 v1.0.13.
* Replaced JPATH_BASE with JPATH_ROOT in Prism\Filesystem\Helper.

### v1.15
* Added LocaleHelper, UserHelper and DateHelper.
* Removed deprecated classes.
* Upgraded libraries Blockchain v1.3, GuzzleHttp v6.2.1, Stripe v3.23.0

### v1.14
* Added [jQueryAutoComplete](https://github.com/devbridge/jQuery-Autocomplete) to Prism UI.
* Added ArrayHelper and ItemHelper.
* Added Prism\Container, Renderer and Observer classes.

### v1.13
* Added class Money and interface Currency.
* Added functions to get cURL and OpenSSL version.

### v1.12
* Added new third-party libraries - React\Promise, GuzzleHttp\Stream.
* Upgraded some third-party libraries - Coinbase and GuzzleHttp.
* Improved integration, helper and database classes.

### v1.11
* Added command buses that can be used for helper and database collections.
* Added Prism\Utilities\QueryHelper and Prism\Utilities\TagHelper.
* Added order constants.

### v1.10
* Added [Abraham\TwitterOAuth](https://github.com/abraham/twitteroauth) library.
* Added [Facebook](https://github.com/facebook/facebook-php-sdk-v4) library.
* Added [Google](https://github.com/google/google-api-php-client) library.
* Added [Monolog](https://github.com/Seldaek/monolog) library.

### v1.9
* Added [Filesystem](http://flysystem.thephpleague.com/adapter/phpcr/) library to the package.
* Added [GuzzleHttp](https://github.com/guzzle/guzzle) library.
* Added [OAuth2 Client](http://thephpleague.com/oauth2-client/) library.
* Upgraded [WePay](https://github.com/wepay/php-sdk) and [Stripe](https://github.com/stripe/stripe-php) libraries.
* Moved Mollie, Stripe, WePay, Coinbase and Blockchain folders from Payment to libs.
* Added Collection class that will replace Prism\Database\ArrayObject.
* Upgraded [Cropper](http://fengyuanchen.github.io/cropper/) to v2.2.5.
* Upgraded [Bootstrap FileInput](http://plugins.krajee.com/file-input) to v4.2.9.
* Upgraded [Bootstrap MaxLength](https://github.com/mimo84/bootstrap-maxlength) to v1.7.0.
* Added the library [Defuse\Crypto\Crypto](https://github.com/defuse/php-encryption).
* Upgraded [pNotify](https://sciactive.github.io/pnotify/) to v3.0.0.
* Improved JavaScript PrismUIHelper. Added options for icon and styling to the methods that display pNotify messages.
* Added [Carbon](http://carbon.nesbot.com/) library.

### v1.8
* Improved code quality.
* Replaced Prism\Math with Prism\Utilities\MathHelper.

### v1.7
* Upgraded jQuery File Upload Plugin.
* Upgraded File Input for Bootstrap 3.0.

### v1.6
* Added classes for integration with Community Builder.
* Added option to route or not the links to community extensions.

### v1.5
* Added class Prism\Utilities\StringHelper that will replaces current class Prism\String.

### v1.4
* Renamed the filename of default controller.

### v1.3
* Fixed integration classes.

### v1.2
* Added Bootstrap 3 layouts to PrismUI.
* Added methods getParam, setParam to Prism\Database\Table and Prism\Database\TableImmutable.
* Added method getKeys and toOptions to Prism\Database\ArrayObject.
* Added class Prism\Database\TableObservable.
* Added method addChildCData to Prism\Xml\Simple.

### v1.1
* Removed UI.bootstrap2FileStyle and bootstrap3FileStyle. Replaced with bootstrap3FileInput.
* Renamed UI.bootstrapFileUploadStyle to UI.bootstrap2FileInput
