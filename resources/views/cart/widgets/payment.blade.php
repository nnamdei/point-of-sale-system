<form action="{{route('cart.checkout')}}" method="POST">
    @csrf
    <div class="">
            <div class="d-flex justify-content-center">
                <select name="payment_method" id="" class="form-control mb-2" style="border-radius: 3px 0px 0px 3px" required>
                    <option value="Cash">Cash</option>
                    <option value="POS">POS</option>
                    <option value="Transfer">Transfer</option>
                </select>
                <button class="btn theme-btn mb-2" type="submit" style="border-radius: 0px 3px 3px 0px">Complete</button>
            </div>
    </div>
</form>