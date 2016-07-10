Prism Library Changelog
==========================

###v1.14
* Added [jQueryAutoComplete](https://github.com/devbridge/jQuery-Autocomplete) to Prism UI.
* Added ArrayHelper and ItemHelper.
* Added Prism\Container, Renderer and Observer classes.

###v1.13
* Added class Money and interface Currency.
* Added functions to get cURL and OpenSSL version.

###v1.12
* Added new third-party libraries - React\Promise, GuzzleHttp\Stream.
* Upgraded some third-party libraries - Coinbase and GuzzleHttp.
* Improved integration, helper and database classes.

###v1.11
* Added command buses that can be used for helper and database collections.
* Added Prism\Utilities\QueryHelper and Prism\Utilities\TagHelper.
* Added order constants.

###v1.10
* Added [Abraham\TwitterOAuth] (https://github.com/abraham/twitteroauth) library.
* Added [Facebook] (https://github.com/facebook/facebook-php-sdk-v4) library.
* Added [Google] (https://github.com/google/google-api-php-client) library.
* Added [Monolog] (https://github.com/Seldaek/monolog) library.

###v1.9
* Added [Filesystem] (http://flysystem.thephpleague.com/adapter/phpcr/) library to the package.
* Added [GuzzleHttp] (https://github.com/guzzle/guzzle) library.
* Added [OAuth2 Client] (http://thephpleague.com/oauth2-client/) library.
* Upgraded [WePay] (https://github.com/wepay/php-sdk) and [Stripe] (https://github.com/stripe/stripe-php) libraries.
* Moved Mollie, Stripe, WePay, Coinbase and Blockchain folders from Payment to libs.
* Added Collection class that will replace Prism\Database\ArrayObject.
* Upgraded [Cropper] (http://fengyuanchen.github.io/cropper/) to v2.2.5.
* Upgraded [Bootstrap FileInput] (http://plugins.krajee.com/file-input) to v4.2.9.
* Upgraded [Bootstrap MaxLength] (https://github.com/mimo84/bootstrap-maxlength) to v1.7.0.
* Added the library [Defuse\Crypto\Crypto] (https://github.com/defuse/php-encryption).
* Upgraded [pNotify] (https://sciactive.github.io/pnotify/) to v3.0.0.
* Improved JavaScript PrismUIHelper. Added options for icon and styling to the methods that display pNotify messages.
* Added [Carbon] (http://carbon.nesbot.com/) library.

###v1.8
* Improved code quality.
* Replaced Prism\Math with Prism\Utilities\MathHelper.

###v1.7
* Upgraded jQuery File Upload Plugin.
* Upgraded File Input for Bootstrap 3.0.

###v1.6
* Added classes for integration with Community Builder.
* Added option to route or not the links to community extensions.

###v1.5
* Added class Prism\Utilities\StringHelper that will replaces current class Prism\String.

###v1.4
* Renamed the filename of default controller.

###v1.3
* Fixed integration classes.

###v1.2
* Added Bootstrap 3 layouts to PrismUI.
* Added methods getParam, setParam to Prism\Database\Table and Prism\Database\TableImmutable.
* Added method getKeys and toOptions to Prism\Database\ArrayObject.
* Added class Prism\Database\TableObservable.
* Added method addChildCData to Prism\Xml\Simple.

###v1.1
* Removed UI.bootstrap2FileStyle and bootstrap3FileStyle. Replaced with bootstrap3FileInput.
* Renamed UI.bootstrapFileUploadStyle to UI.bootstrap2FileInput
