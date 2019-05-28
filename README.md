Remote Control for Laravel
===================

Grant remote access to user account without sharing credentials.

[![Build Status](https://travis-ci.org/katsana/remote-control.svg?branch=master)](https://travis-ci.org/katsana/remote-control)
[![Latest Stable Version](https://poser.pugx.org/katsana/remote-control/v/stable)](https://packagist.org/packages/katsana/remote-control)
[![Total Downloads](https://poser.pugx.org/katsana/remote-control/downloads)](https://packagist.org/packages/katsana/remote-control)
[![Latest Unstable Version](https://poser.pugx.org/katsana/remote-control/v/unstable)](https://packagist.org/packages/katsana/remote-control)
[![License](https://poser.pugx.org/katsana/remote-control/license)](https://packagist.org/packages/katsana/remote-control)
[![Coverage Status](https://coveralls.io/repos/github/katsana/remote-control/badge.svg?branch=master)](https://coveralls.io/github/katsana/remote-control?branch=master)

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

