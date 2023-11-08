# OrangeMoneyBundle

The OrangeMoneyBundle makes integration easy
of the Orange Money payment API on an app
Symfony

## Installation and configuration
### Pretty simple with [composer](https://packegist.org), run
```sh
composer require tm/orange-money-bundle
```
###  Add OrangeMoneyBundle to your application kernel

If you don't use flex (you should), you need to manually enable bundle:

```php
// app/AppKernel.php
public function registerBundles()
{
    return [
        // ...
        new Tm\OrangeMoneyBundle\OrangeMoneyBundle(),
        // ...
    ];
}
```

### Configuration example

You can configure default application

#### YAML:
````yaml
# config/packages/orange_money.yaml
orange_money:
  client_id: '%env(OM_CLIENT_ID)%'
  client_secret: '%env(OM_CLIENT_SECRET)%'
  environment: sandbox
````

### How it use

