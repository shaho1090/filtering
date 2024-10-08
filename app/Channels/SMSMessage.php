<?php

namespace App\Channels;

class SMSMessage
{
    protected array $lines = [];
    protected string $from;
    protected string $to;

    public function __construct($lines = [])
    {
        $this->lines = $lines;

        return $this;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param string $to
     * @return $this
     */
    public function to(string $to): static
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param string $line
     * @return $this
     */
    public function line(string $line = ''): static
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @return void
     */
    public function send(): void
    {
        // TODO implement real sms provider
       info('This message: '.implode(' ',$this->lines).' was sent from '
           .$this->from. ' to '.$this->to
       );
    }
}
