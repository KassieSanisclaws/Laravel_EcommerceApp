@extends('layouts.app')

@section('content')
<style>
    .StripeElement {
    box-sizing: border-box;
  
    height: 40px;
  
    padding: 10px 12px;
  
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
  
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }
  
  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }
  
  .StripeElement--invalid {
    border-color: #fa755a;
  }
  
  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
  </style>

    <div class="container">

        <div class="row">
            <div class="col-md-6">
    
               <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">Product</th>
          <th scope="col">Price</th>
          <th scope="col">Qty</th>
    
        </tr>
      </thead>
      <tbody>
    
        @if($cart)
      @php $i=1 @endphp
    
    @foreach($cart->items as $product)
        <tr>
          <th scope="row">{{$i++}}</th>
          
          <td><img src="{{Storage::url($product['image'])}}" width="100"></td>
          <td>{{$product['name']}}</td>
          <td>${{$product['price']}}</td>
          <td>
            {{$product['qty']}}
        </td>
          <td>
        
          </td>
        </tr>
       @endforeach
       @endif
    
    
    
      </tbody>
    </table>
    <hr>
    Total Price:${{$cart->totalPrice}}
    </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Checkout</div>
                <div class="card-body">

        <form action="{{route('cart.charge')}}" method="POST" id="payment-form">@csrf
<!---------------------------------Below-Form-Group-Start--------------------------------------------->           
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" required=""  value="{{auth()->user()->name}}" readonly="">
            </div>
<!---------------------------------Below-Form-Group-Start--------------------------------------------->
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control" required="">
            </div>
<!---------------------------------Below-Form-Group-Start--------------------------------------------->
                 <div class="form-group">
                     <label>City</label>
                     <input type="text" name="city" id="city" class="form-control" required="">
                 </div>
<!---------------------------------Below-Form-Group-Start--------------------------------------------->
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" id="state" class="form-control" required="">
            </div>
<!---------------------------------Below-Form-Group-Start--------------------------------------------->
            <div class="form-group">
                <label>Postal Code</label>
                <input type="text" name="postalcode" id="postalcode" class="form-control" required="">
            </div>
<!----------------------------------------------------------------------------------------------------->
            <div class="">
            <input type="hidden" name="amount" value="{{$amount}}">
<!---------------------------------Below-Form-Row-Start--------------------------------------------->
                 <div class="">
                 <label for="card-element">Credit or Debit Card</label>
                 <div id="card-element">
 <!--------------------------A-Stripe-Element-Will-Be-Inserted-Here------------------------->
                 </div>
 <!---------------------------Used-To-Display-Form-Errors------------------------------------>
                 <div id="card-errors" role="alert"></div>
                 </div>
                 <button class="btn btn-primary mt-4" type="submit">Submit Payment</button>
            </form>
         </div>
    </div>
</div>
</div>
    </div>
    

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
window.onload=function(){
// Create a Stripe Client. //
var stripe = Stripe('pk_test_51J0uldCiNZvKubU117di3LxAuth7Bf4HF5xO13KLzyDhSyDRs5C2xQ6ycqha7jtV8zi4Pj83dPtaraAdPZTMNbDq00CjARQpfH');
// create an instance of Elements. //
var elements = stripe.elements();
// Custom styling can be passed to potions when creating an Element. (Note that this demo uses wider set of styles than the guide below). //
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
// Create an instance of the card Element. //
var card = elements.create('card', {style: style});

// Add an instance of the card element into the 'card-element' <div>. //
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
       }
    });

// Handle from Submission. //
var form = document.getElementById('payment-form');
   form.addEventListener('submit', function(event) {
    event.preventDefault();

var options={
  name:document.getElementById('name').value,
  address_line1:document.getElementById('address').value,
  address_city:document.getElementById('city').value,
  address_state:documanet.getElementById('state').value,
  address_zip:document.getElementbyId('postalcode').value
}

 stripe.createToken(card, options).then(function(result) {
     if (result.error) {
  // Inform the user if there was an error. //
var errorElement = document.getElementById('card-errors');
    errorElement.textContent = result.error.message;
     } else {
 // Send the token to your user. //
    stripeTokenHandler(result.token);
     }
  });
});
// Submit the form with the token ID. //
  function stripeTokenHandler(token) {
// Insert the token Id into the  form so it gets submitted to the server. //
  var form = document.getElementById('payment-form');
  var hippenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

// Submit the form. //
  form.submit();
  }
  }
</script>
@endsection