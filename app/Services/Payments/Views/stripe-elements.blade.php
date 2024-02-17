<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Оплата</title>
</head>

<body>
    <section>
        <div class="container">
            <div class="pt-5"></div>

            <div class="row">
                <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <form id="payment-form">
                                <div id="payment-element" class="mb-3"></div>

                                <div id="payment-message" class="d-none mb-3 text-danger small"></div>

                                <button id="submit" class="btn btn-primary">
                                    Оплатить {{ money($payment->driver_amount, $payment->driver_currency_id) }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const message = document.getElementById('payment-message');

        const stripe = Stripe("{{ config('services.stripe.public_key') }}");

        const elements = stripe.elements({
            clientSecret: "{{ $intent->client_secret }}",
            locale: "{{ config('app.locale') }}"
        });

        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        document.getElementById('payment-form')
            .addEventListener('submit', (e) => {
                e.preventDefault();

                stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: "{{ route('payments.success', ['uuid' => $payment->uuid]) }}",
                    },
                }).then(result => {
                    if (result.error) {
                        message.textContent = result.error.message;
                        message.classList.remove('d-none');
                    } else {
                        message.classList.addClass('d-none');
                        message.textContent = "";
                    }
                })
            })
    </script>
</body>

</html>
