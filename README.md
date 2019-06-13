Remote Control for Laravel
===================

Grant remote access to user account without sharing credentials.

[![Build Status](https://travis-ci.org/katsana/remote-control.svg?branch=master)](https://travis-ci.org/katsana/remote-control)
[![Latest Stable Version](https://poser.pugx.org/katsana/remote-control/v/stable)](https://packagist.org/packages/katsana/remote-control)
[![Total Downloads](https://poser.pugx.org/katsana/remote-control/downloads)](https://packagist.org/packages/katsana/remote-control)
[![Latest Unstable Version](https://poser.pugx.org/katsana/remote-control/v/unstable)](https://packagist.org/packages/katsana/remote-control)
[![License](https://poser.pugx.org/katsana/remote-control/license)](https://packagist.org/packages/katsana/remote-control)
[![Coverage Status](https://coveralls.io/repos/github/katsana/remote-control/badge.svg?branch=master)](https://coveralls.io/github/katsana/remote-control?branch=master)

* [Installation](#installation)
    - [Configuration](#configuration)
* [Usages](#usages)
    - [Routing](#routing)
    - [Creating Remote Access](#creating-remote-access)
    - [Using Generated Access Token](#using-generated-access-token)

## Installation

Remote Control can be installed via composer:

```
composer require "katsana/remote-control"
```

### Configuration

The package will automatically register a service provider.

Next, you need to publish the Remote Control configuration file:

```
php artisan vendor:publish --provider="RemoteControl\RemoteServiceProvider" --tag="config"
```

## Usages

### Routing

Before creating any remote access, we need to declare verification route:

```php
RemoteControl\Remote::verifyRoute('remote-control')->middleware('web');
```

To use signed URL you should include `signed` middleware:

```php
RemoteControl\Remote::verifyRoute('remote-control')->middleware(['signed', 'web']);
```

### Creating Remote Access

You can create a remote access by running the following code:

```php
$user = request()->user();

$recipientEmail = 'email@example.org';
$content = 'Please help me';

$accessToken = RemoteControl\Remote::create($user, $recipientEmail, $content);
```

### Using Generated Access Token

You can get the URL using the following method:

```php
$accessToken->getUrl();
```

You can also get signed URL using the following method:

```php
$accessToken->getSignedUrl();
```

You can automatically send an email to the recipient via the following `Mailable`:

```php
Mail::send(new RemoteControl\Mail\GrantRemoteAccess($user, $accessToken, $content));
```
