<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Http\Request;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class ValidatorTest extends TestCase
{
    #[Test]
    #[DataProvider('valid_values')]
    public function accepts_valid_values_for_in_rule(string $value): void
    {
        $this->hive->set('POST', ['name' => $value]);

        $request = new class($this->hive) extends Request {
            public function rules(): array
            {
                return ['name' => ['validate' => 'in:abs,1,2']];
            }
            protected function on_failure(): void {}
        };


        $result = $request->validate();
        $this->assertTrue($result);
    }

    #[Test]
    public function rejects_invalid_values_for_in_rule(): void
    {
        $this->hive->set('POST', ['name' => 'invalid']);

        $request = new class($this->hive) extends Request {
            public function rules(): array
            {
                return ['name' => ['validate' => 'in:abs,1,2']];
            }
            protected function on_failure(): void {}
        };


        $result = $request->validate();
        $this->assertFalse($result);
    }


    public static function valid_values(): array
    {
        return [
            ['abs'],
            ['1'],
            ['2'],
        ];
    }
}
