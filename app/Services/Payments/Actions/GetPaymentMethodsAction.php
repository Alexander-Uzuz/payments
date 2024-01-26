<?php

namespace App\Services\Payments\Actions;

use App\Services\Payments\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class GetPaymentMethodsAction
{
    private ?bool $active = null;
    private ?int $id = null;

    public function active(bool $active = true): static
    {
        $this->active = $active;

        return $this;
    }

    public function run(): Collection
    {
        $query = PaymentMethod::query();

        if (!is_null($this->active)) {
            $query->where('active', $this->active);
        }

        return $query->get();
    }

    public function id(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    private function query(): Builder
    {
        $query = PaymentMethod::query();

        if (!is_null($this->active)) {
            $query->where('active', $this->active);
        }

        if (!is_null($this->id)) {
            $query->where('id', $this->id);
        }

        return $query;
    }

    public function first(): ?PaymentMethod
    {
        return $this->query()->first();
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }
}
