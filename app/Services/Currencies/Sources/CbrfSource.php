<?php

namespace App\Services\Currencies\Sources;

use App\Services\Currencies\Sources\SourceEnum;
use App\Support\Values\AmountValue;
use Illuminate\Database\Eloquent\Collection;

class CbrfSource extends Source
{
    public function enum(): SourceEnum
    {
        return SourceEnum::cbrf;
    }

    public function getPrices(): Collection
    {
        $response = file_get_contents('https://cbr.ru/scripts/XML_daily.asp');
        $response = simplexml_load_string($response);
        $response = json_encode($response);
        $response = json_decode($response);

        $prices = new Collection([]);

        foreach ($response->Valute as $data) {
            $value = str_replace(',', '.', $data->VunitRate);

            $prices->push(new SourcePrice(
                currency: $data->CharCode,
                value: new AmountValue($value),
            ));
        }

        return $prices;
    }
}
