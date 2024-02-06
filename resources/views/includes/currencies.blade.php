@php($currencies = App\Services\Currencies\Models\Currency::getCached())

<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        {{ currency() }}
    </a>

    <ul class="dropdown-menu">
        @foreach ($currencies as $currency)
            <li>
                <a href="{{ route('currency', $currency) }}" class="dropdown-item">
                    {{ $currency->id }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
