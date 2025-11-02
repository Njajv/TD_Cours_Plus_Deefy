<?php

namespace IUT\Spotify;

class Fibonacci
{
    private $sequence;
    private $currentIndex;

    const FIBONACCI_SESSION_NAME = 'fibonacci_sequence';
    public function __construct(int $firstValue = 0, int $secondValue = 1)
    {

        session_start();

        if (isset($_SESSION[self::FIBONACCI_SESSION_NAME])) {
            $data = $_SESSION[self::FIBONACCI_SESSION_NAME];
            $this->sequence = $data['sequence'];
            $this->currentIndex = $data['currentIndex'];
        } else {
            $this->sequence = [$firstValue, $secondValue];
            $this->currentIndex = 1;
            $_SESSION[self::FIBONACCI_SESSION_NAME] = [
                'sequence' => $this->sequence,
                'currentIndex' => $this->currentIndex,
            ];

        }
    }

    public function initialize(): void
    {

    }

    public function getCurrentValue(): int
    {
        return $this->sequence[$this->currentIndex];
    }

    public function calculateNextValue(): int
    {
        $nextValue = $this->sequence[$this->currentIndex] + $this->sequence[$this->currentIndex - 1];
        $this->sequence[] = $nextValue;
        $this->currentIndex++;

        $_SESSION[self::FIBONACCI_SESSION_NAME] = [
            'sequence' => $this->sequence,
            'currentIndex' => $this->currentIndex,
        ];

        return $nextValue;
    }

    public function getSequence(): array
    {
        return $this->sequence;
    }

    public function displayCurrentValue(): void
    {
        echo "Valeur courante : " . $this->getCurrentValue() . "\n";
    }

    public function displaySequence(): void
    {
        echo "Suite de Fibonacci : " . implode(", ", $this->getSequence()) . "\n";
    }
}
