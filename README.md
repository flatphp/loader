# Loader
Loader Libs.

# Installation
```php
composer require "flatphp/loader"
```

# Autoloader
```
use Flatphp\Loader\Autoloader;
Autoloader::addDirs(array(
    __DIR__ .'/mylib', __DIR__.'/lib2'
));
```

