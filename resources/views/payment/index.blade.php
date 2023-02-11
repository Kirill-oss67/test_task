<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Create</title>
</head>

<body>
    <div>
        <form action="{{ route('payment.create') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount">
                @error('amount')
                <p class='text-danger'> {{$message}}
                </p>
                @enderror

            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <select class="form-control" name="currency" id="currency">

                    <option value="RUB">rubles
                    </option>
                    <option value="USD">dollars
                    </option>
                    <option value="EUR">euro
                    </option>

                </select>
            </div>
            <div class="form-group">
                <label for="payment_system">Payment system</label>
                <input name="payment_system" type="text" class="form-control" id="payment_system" placeholder="Payment system">
            </div>
            <div class="form-group">
                <label for="card_number">Сard number</label>
                <input name="card_number" class="form-control" id="card_number" placeholder="Сard number">
                @error('card_number')
                <p class='text-danger'> {{$message}}
                </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="valid_until">Valid until</label>
                <input name="valid_until" class="form-control" id="valid_until" placeholder="Valid until">
                @error('valid_until')
                <p class='text-danger'> {{$message}}
                </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="CVV/CVC">CVV/CVC</label>
                <input name="CVV/CVC" class="form-control" id="CVV/CVC" placeholder="CVV/CVC">
                @error('CVV/CVC')
                <p class='text-danger'> {{$message}}
                </p>
                @enderror
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input name="surname" type="text" class="form-control" id="surname" placeholder="Surname">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="Name">
            </div>

            <div class="form-group">
                <label for="phone_number">Phone number</label>
                <input name="phone_number" type="text" class="form-control" id="phone_number" placeholder="Phone number">
                @error('phone_number')
                <p class='text-danger'> {{$message}}
                </p>
                @enderror

            </div>

            <div class="form-group">
                <label for="note">Note</label>
                <textarea name="note" class="form-control" id="note" placeholder="Note"></textarea>

            </div>






            <button type="submit" class="btn btn-primary">Create payment</button>
        </form>
    </div>
</body>

</html>