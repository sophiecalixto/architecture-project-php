<?php

namespace SophieCalixto\App;

class Phone
{
    private string $country_number;
    private string $ddd;
    private string $number;

    /**
     * @param string $country_number
     * @param string $ddd
     * @param string $number
     */
    public function __construct(string $country_number, string $ddd, string $number)
    {
        $this>$this->setPhone($country_number, $ddd, $number);
    }

    private function setPhone(string $country_number, string $ddd, string $number): void
    {
        $options = [
            "options" => [
                "regexp" => "/^\+\d{2}\s\(\d{2}\)\s\d{9}$/"
            ]
        ];

        $phone = "$country_number ($ddd) $number";

        if(!filter_var($phone, FILTER_VALIDATE_REGEXP, $options)) {
            throw new \InvalidArgumentException("Invalid Phone!");
        }

        $this->country_number = $country_number;
        $this->ddd = $ddd;
        $this->number = $number;

    }

    public function __toString(): string
    {
        return "$this->country_number ($this->ddd) $this->number";
    }


}