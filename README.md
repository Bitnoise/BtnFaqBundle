BtnFaqBundle
============

Faq bundle for symfony2

=============

### Step 1: Add BtnFaqBundle in your composer.json (private repo)

```js
{
    "require": {
        "bitnoise/faq-bundle": "dev-master",
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@github.com:Bitnoise/BtnFaqBundle.git"
        }
    ],
}
```

### Step 2: Enable the bundle

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Btn\FaqBundle\BtnFaqBundle(),
    );
}
```

### Step 3: Add routing

``` yml
# app/config/config/routing.yml
# ...
btn_faq:
    resource: "@BtnFaqBundle/Controller/"
    type:     annotation
    prefix:   /

```

### Step 4: Update your database schema

``` bash
$ php app/console doctrine:schema:update --force
```
