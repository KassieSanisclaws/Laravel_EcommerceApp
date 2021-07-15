<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;

use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CartController extends Controller
{
    public function addToCart(Product $product, Request $request)
    {

        if(session()->has('cart')){
    		$cart = new Cart(session()->get('cart'));
    	}else{
    		$cart = new Cart();
    	}
    	$cart->add($product);


    	session()->put('cart',$cart);
        return redirect()->back()->with('message', 'Item Added To Cart Successfully!.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCart()
    {
        if(session()->has('cart')){
    		$cart = new Cart(session()->get('cart'));
    	}else{
    		$cart = null;
    	}
    	return view('cart',compact('cart'));
    }

    public function removeCart(Product $product)
    {
    	$cart = new Cart(session()->get('cart'));
    	$cart->remove($product->id);
    	if($cart->totalQty<=0){
    		session()->forget('cart');
    	}else{
    		session()->put('cart',$cart);
    		

    	}
            return redirect()->back()->with('message', 'Product Removed Successfully!.');
    }

    public function checkout($amount){
        if(session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        }else{
            $cart = null;
        }  
        return view('checkout',compact('amount','cart'));
    }

    public function charge(Request $request){
        $charge = Stripe::charges()->create([
            'currency'=>"CAN",
            'source'=>$request->stripeToken,
            'amount'=>$request->amount,
            'description'=>'Test'
        ]);

        $chargeId = $charge['id'];
        if(session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        }else{
            $cart = null;
        } 
        \Mail::to(auth()->user()->email)->send(new Sendmail($cart));

      

        if($chargeId){
            auth()->user()->orders()->create([

                'cart'=>serialize(session()->get('cart'))
            ]);

            session()->forget('cart');
            notify()->success(' Transaction completed!');
            return redirect()->to('/')->with('message', 'Transaction Completed Successfully!.');

        }else{
            return redirect()->back();
        }

    }
    //for loggedin user
    public function order(){
        $orders = auth()->user()->orders;
        $carts =$orders->transform(function($cart,$key){
            return unserialize($cart->cart);

        });
        return view('order',compact('carts'));

    }

    //for admin
    public function userOrder(){
        $orders = Order::latest()->get();
        return view('admin.order.index',compact('orders'));
    }
    public function viewUserOrder($userid,$orderid){
        $user = User::find($userid);
        $orders = $user->orders->where('id',$orderid);
        $carts =$orders->transform(function($cart,$key){
            return unserialize($cart->cart);

        });
        return view('admin.order.show',compact('carts'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCart(Request $request, Product $product)
    {
        $request->validate([
    		'qty'=>'required|numeric|min:1'
    	]);

    	$cart  = new Cart(session()->get('cart'));
    	$cart->updateQty($product->id,$request->qty);
    	session()->put('cart',$cart);
    	//notify()->success(' Cart updated!');
        return redirect()->back();
    }

}
