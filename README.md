# php-filter

## A lightweight and easy method to filter arrays

### map a callback onto your array
```php
$data = ['a' => '   Foo '];
print_r(prepare($data)->map('trim')->getData()); // ['a' => 'Foo']
```

### or apply a specific callback to one of the elements
```php
$data = ['a' => 'foo', 'b' => 'bar'];
print_r(prepare($data)->apply(['a' => 'ucfirst'])->getData()); // ['a' => 'Foo', 'b' => 'bar']
```

### only allow particular keys
```php
$data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
print_r(prepare($data)->allowOnly(['name'])->getData()); // ['name' => '  foo ']
```

### set defaults for missing or already filtered elements
```php
$data = [];
print_r(prepare($data)->applyDefaults(['name' => 'Foo'])->getData()); // ['name' => 'Foo']
```

### filter false / null / empty
```php
$data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
print_r(prepare($data)->filter()->getData()); // ['name' => '  foo ']
```

### filter by a own callback
```php
$data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
print_r(prepare($data)->filterBy(function($v, $k) {
    return !empty($v);
})->getData()); // ['name' => '  foo ']
```

### filter by specific rules (see the rule chapter below for further informations)
```php
$rules = [
    'name' => 'string',
    'age'  => 'int(40, 100)',
    'foo'  => 'string(a+b+)',
    'bar'  => 'string(5)'
];

$data = ['name' => 'Foo', 'age' => 42, 'foo' => 'abb', 'bar' => 'quatz'];
print_r(prepare($data)->filterByRules($rules)->getData()); // ['name' => 'Foo', 'age' => 42, 'foo' => 'abb', 'bar' => 'quatz']
```

### or filter by your own pattern
```php
$pattern = [
    'name' => '#^\w+$#',
    'age'  => '#\d{2}#'
];

$data = ['name' => 'Foo', 'age' => 42];
print_r(prepare($data)->filterByPattern($pattern)->getData()); // ['name' => 'Foo', 'age' => 42]
```

----

## Rules

Rules are one of
 - `<type>(<min>, <max>)` whereby `<min>` and `<max>` are integers
 - `<type>(<limit>)` whereby `<limit>` is an integer
 - `<type>(<pattern>)` whereby `<pattern>` is a valid regex
 - or only `<type>`
 
 for `<type>` the following types are valid:
  - `numeric`
  - `int(eger)`
  - `float|double|real|decimal`
  - `bool(ean)`
  - `string`
  - `array`
  - `object|class`
