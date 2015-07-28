# Requirement
* PHP 5.5

# Installation
Composer:
```
"require": {
    "byte/storage": "dev-master"
}
```

# Usage
Upload File: (Whith Public Link)
```
$storage = new \Byte\Storage\Storage("API-KEY");
$res = $storage->upload(__DIR__."/img.png", 1);
```
Result
```
array(3) {
  ["id"]=>
  string(1) "3"
  ["md5"]=>
  string(32) "cc5b39ccc9685362f2cdc3ad02716bdb"
  ["link"]=>
  string(66) "http://storage.byte.gs/file/3?md5=cc5b39ccc9685362f2cdc3ad02716bdb"
}
```

Upload File:
```
$storage = new \Byte\Storage\Storage("API-KEY");
$res = $storage->upload(__DIR__."/img.png");
```
Result
```
array(3) {
  ["id"]=>
  string(1) "4"
  ["md5"]=>
  string(32) "cc5b39ccc9685362f2cdc3ad02716bdb"
}
```

Get File:
```
$storage = new \Byte\Storage\Storage("API-KEY");
$res = $storage->get(4);
```
$res contains the Source of the File.

Delite File:
```
$storage = new \Byte\Storage\Storage("API-KEY");
$res = $storage->delete(4);
```
