@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">إتمام الدفع</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                    @csrf

                    <!-- Payment Amount -->
                    <div class="mb-3">
                        <label for="amount" class="form-label">المبلغ بالدولار:</label>
                        <input type="number" readonly name="amount" class="form-control" required min="1" value="{{$total}}"> 
                    </div>

                    <!-- Address Section -->
                    <h5 class="mt-4">معلومات العنوان</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="street_name" class="form-label">اسم الشارع:</label>
                            <input type="text" name="street_name" class="form-control" placeholder="مثال: شارع الملك فهد">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="building_number" class="form-label">رقم المبنى:</label>
                            <input type="text" name="building_number" class="form-control" placeholder="مثال: 12A">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="floor_number" class="form-label">رقم الطابق:</label>
                            <input type="text" name="floor_number" class="form-control" placeholder="مثال: 5">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="appartment_number" class="form-label">رقم الشقة:</label>
                            <input type="text" name="appartment_number" class="form-control" placeholder="مثال: 501">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone_number" class="form-label">رقم الهاتف:</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="مثال: 0567891234">
                        </div>
                    </div>

                    <!-- Payment Section -->
                    <h5 class="mt-4">معلومات الدفع</h5>
                    <div class="mb-3">
                        <label class="form-label">معلومات البطاقة:</label>
                        <div id="card-element" class="form-control p-2"></div>
                        <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                    </div>

                    <input type="hidden" id="stripeToken" name="stripeToken">

                    <!-- Submit Button -->
                    <button id="payButton" class="btn btn-primary w-100">إتمام الدفع</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}'); 
    const elements = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#fa755a',
            },
        },
    });

    cardElement.mount('#card-element');

    const payButton = document.getElementById('payButton');
    const form = document.getElementById('payment-form');

    payButton.addEventListener('click', async (e) => {
        e.preventDefault();
        payButton.disabled = true;
        payButton.innerText = "جارٍ المعالجة...";

        const { token, error } = await stripe.createToken(cardElement);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            payButton.disabled = false;
            payButton.innerText = "إتمام الدفع";
        } else {
            document.getElementById('stripeToken').value = token.id;
            form.submit();
        }
    });
</script>

@endpush
