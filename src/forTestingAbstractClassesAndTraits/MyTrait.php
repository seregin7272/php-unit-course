<?php
declare(strict_types=1);

namespace forTestingAbstractClassesAndTraits;

trait MyTrait {

    public function traitMethod($number): int
    {
        return $number + 10;
    }
}