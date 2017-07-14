# Monkey money
Simple cash managment for minimarkets

## Features
* Manage cash drawing closings.
* Record cash inputs and outups.
* Multiple cashiers.
* Reports via email.
* Settings of desired level of bills/coins of each value.
* User managment. Roles administrator and operator.


## Installation
* Clone this repository or [Download](https://github.com/wnasich/monkey_money/archive/master.zip)
* Execute `$ composer install`
* Edit `config/app_local.php` according
* Execute:
  ```
  $ bin/cake migrations migrate
  $ bin/cake migrations seed
  ```


## Quick test
* Execute `$ bin/cake server`
* Open `http://localhost:8765/users/login` login as admin /admin
* Add new movement types
* Add / edit users
* Logout and login using user buttons


## How add support for my country bills?

Example for add CAD bills:

* Create folder `webroot/img/closing_bills/cad`
* Add images of bills and coins into created folder
* Edit file `config/app.php` and chage the config value `currencyCode` to `cad`
* Clone the file `config/bills_ars.php` as `config/bills_cad.php` and edit it using the proper values


### Donations
```
Bitcoin : 187w4iNVHX44y2PC96AuhP286aUKNjcrXV
Litecoin: LVutsPn9jaoC6SScdxsGMM2uAMvPbjNZXq
PIVX    : D81ZZt8jAvWQFaLhtx3f4ntstUCCYBcdne
```
