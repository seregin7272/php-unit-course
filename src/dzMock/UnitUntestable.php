<?php
declare(strict_types=1);

namespace dzMock;

use phpDocumentor\Reflection\Types\This;

/**
 * This is the class that you should refactor so that the entire internal logic is fully covered by unit test. You must
 * not change the class functionality. It must work 100% the same.
 */
class UnitUntestable
{
    private DataSource $dataSource;

    private int $random;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getRandomQoute(): string
    {
        $body = 'Today the quote from ';

        if ($this->getRandom() === 0) {
            $body .= 'one the famous physicist ' . $person = 'Albert Einstein';
        } elseif ($this->getRandom() === 1) {
            $body .= 'head of the Catholic Church and sovereign of the Vatican City ' . $person = 'Pope John Paul II';
        } else {
            $body .= 'the co-founder of Microsoft Corporation ' . $person = 'Bill Gates';
        }

        $quote = $this->dataSource->fetchQuote($person);

        return $body . ': ' . $quote;
    }

    /**
     * @param int $random
     *
     * @return \dzMock\UnitUntestable
     */
    public function setRandom(int $random): self
    {
        $this->random = $random;

        return $this;
    }

    /**
     * @return int
     */
    public function getRandom(): int
    {
        return $this->random ?? mt_rand(0, 2);
    }

}