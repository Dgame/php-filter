<?php

require_once '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use function Dgame\Filter\prepare;

class TestFilter extends TestCase
{
    public function testMap()
    {
        $data = ['a' => '   Foo '];
        $this->assertEquals(prepare($data)->map('trim')->getData(), ['a' => 'Foo']);
    }

    public function testApply()
    {
        $data = ['a' => 'foo', 'b' => 'bar'];
        $this->assertEquals(prepare($data)->apply(['a' => 'ucfirst'])->getData(), ['a' => 'Foo', 'b' => 'bar']);
    }

    public function testAllowOnly()
    {
        $data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
        $this->assertEquals(prepare($data)->allowOnly(['name'])->getData(), ['name' => '  foo ']);
    }

    public function testApplyDefaults()
    {
        $data = [];
        $this->assertEquals(prepare($data)->applyDefaults(['name' => 'Foo'])->getData(), ['name' => 'Foo']);
    }

    public function testFiltered()
    {
        $data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
        $this->assertEquals(prepare($data)->filter()->getData(), ['name' => '  foo ']);
    }

    public function testFilteredBy()
    {
        $data = ['name' => '  foo ', 'age' => null, 'test' => false, 'quatz' => null];
        $this->assertEquals(prepare($data)->filterBy(function($v, $k) {
            return !empty($v);
        })->getData(), ['name' => '  foo ']);
    }

    public function testValidRules()
    {
        $rules = [
            'name' => 'string',
            'age'  => 'int(40, 100)',
            'foo'  => 'string(a+b+)',
            'bar'  => 'string(5)'
        ];

        $data = ['name' => 'Foo', 'age' => 42, 'foo' => 'abb', 'bar' => 'quatz'];
        $this->assertEquals(prepare($data)->filterByRules($rules)->getData(), $data);
    }

    public function testInvalidRules()
    {
        $rules = [
            'name' => 'string',
            'age'  => 'int(1, 10)',
            'foo'  => 'string(a+b+)',
            'bar'  => 'string(3)'
        ];

        $data = ['name' => 'Foo', 'age' => 42, 'foo' => 'abb', 'bar' => 'quatz'];
        $this->assertEquals(prepare($data)->filterByRules($rules)->getData(), ['name' => 'Foo', 'foo' => 'abb']);
    }

    public function testValidPattern()
    {
        $pattern = [
            'name' => '#^\w+$#',
            'age'  => '#\d{2}#'
        ];

        $data = ['name' => 'Foo', 'age' => 42];
        $this->assertEquals(prepare($data)->filterByPattern($pattern)->getData(), ['name' => 'Foo', 'age' => 42]);
    }

    public function testInvalidPattern()
    {
        $pattern = [
            'name' => '#\d+#',
            'age'  => '#^\d{1}$#'
        ];

        $data = ['name' => 'Foo', 'age' => 42];
        $this->assertEmpty(prepare($data)->filterByPattern($pattern)->getData());
    }
}