<?php
declare(strict_types=1);

namespace dzMock;

/**
 * Do not change this class. This is only for simulating the enviromnent.
 */
class DataSource
{
    public $data = [

        'Albert Einstein' => [
            '"Insanity: doing the same thing over and over again and expecting different results."',
            '"Imagination is more important than knowledge."',
            '"Two things are infinite: the universe and human stupidity; and I\'m not sure about the universe."'
        ],

        'Pope John Paul II' => [
            '"Do not abandon yourselves to despair. We are the Easter people and hallelujah is our song."',
            '"The future starts today, not tomorrow."',
            '"As the family goes, so goes the nation and so goes the whole world in which we live."'
        ],

        'Bill Gates' => [
            '"Success is a lousy teacher. It seduces smart people into thinking they can\'t lose."',
            '"Your most unhappy customers are your greatest source of learning."',
            '"It\'s fine to celebrate success but it is more important to heed the lessons of failure."'
        ]
    ];

    public function fetchQuote($person): string
    {
        $random = mt_rand(0,2);
        return $this->data[$person][$random];
    }
}