@extends('layouts.common')

@section('title', '決済')

@section('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
        <h2>決済</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" id="amount" name="amount" value="1000">
            <div class="form-group">
                <label for="card-number">カード番号</label>
                <div id="card-number" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="card-expiry">有効期限</label>
                <div id="card-expiry" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="card-cvc">セキュリティコード</label>
                <div id="card-cvc" class="form-control"></div>
            </div>
            <div id="card-errors" role="alert"></div>
            <input type="hidden" name="payment_method" id="payment-method">
            <button type="submit" class="btn btn-primary">支払いを送信</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var stripe = Stripe('{{ env("STRIPE_KEY") }}');
            var elements = stripe.elements();

            var style = {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            var cardNumberElement = elements.create('cardNumber', { style: style });
            var cardExpiryElement = elements.create('cardExpiry', { style: style });
            var cardCvcElement = elements.create('cardCvc', { style: style });

            cardNumberElement.mount('#card-number');
            cardExpiryElement.mount('#card-expiry');
            cardCvcElement.mount('#card-cvc');

            var form = document.getElementById('payment-form');

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                const name = "{{ $user->name }}";

                const { paymentMethod, error } = await stripe.createPaymentMethod(
                    'card', cardNumberElement, {
                        billing_details: { name: name }
                    }
                );

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    document.getElementById('payment-method').value = paymentMethod.id;

                    const response = await fetch("{{ route('payment.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            amount: document.getElementById('amount').value,
                            payment_method: paymentMethod.id
                        })
                    });

                    const paymentIntent = await response.json();

                    if (paymentIntent.error) {
                        document.getElementById('card-errors').textContent = paymentIntent.error;
                    } else {
                        const result = await stripe.confirmCardPayment(paymentIntent.client_secret);

                        if (result.error) {
                            document.getElementById('card-errors').textContent = result.error.message;
                        } else {
                            if (result.paymentIntent.status === 'succeeded') {
                                window.location.href = "{{ route('done') }}";
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
