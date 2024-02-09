<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Income;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = User::all();
        return view('dashboard.user.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cartes = Cart::all();
        return view('welcome', compact('cartes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::where('code', $request->code)->first();
        if (isset($product) && $product->amount != 0) {
            $cartCeheck = Cart::where('product_id', $product->id)->first();
            if (isset($cartCeheck)) {
                if ($cartCeheck->amount < $product->amount && $cartCeheck->amount != $product->amount) {
                    $cart = Cart::where('product_id', $product->id)->first();
                    $cart->amount += 1;
                    $cart->save();
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'over' => "This product not exist warehouse "
                        ],
                        200
                    );
                }
            } else {
                $cart = new Cart();
                $cart->user_id = 1;
                $cart->product_id = $product->id;
                $cart->amount = 1;
                $cart->save();
            }
            $total = 0;
            $cartes = Cart::all();
            foreach ($cartes as $value) {
                $total += $value->amount * $value->product->price;
            }
            $html = view('yields.cart', compact('cartes'))->render();
            return response()->json(
                [
                    'status' => true,
                    'total' => $total,
                    'html' => $html,
                    'message' => "success new product in the cart"
                ],
                200
            );
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Data not found'
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $deitm)
    {
        Cart::where('product_id', $deitm)->delete();
        $total = 0;
        $cartes = Cart::all();
        foreach ($cartes as $value) {
            $total += $value->amount * $value->product->price;
        }
        $html = view('yields.cart', compact('cartes'))->render();
        return response()->json(
            [
                'status' => true,
                'total' => $total,
                'html' => $html,
                'message' => "success deleted product in the cart"
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function pmfromcart($id, $signal)
    {
        $product = Product::where('id', $id)->first();
        if ($signal == 'plus') {
            $cart = Cart::where('product_id', $id)->first();
            if ($product->amount != $cart->amount) {
                $cart->amount += 1;
                $cart->save();
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Data not plus'
                ], 200);
            }
        } else {
            $cart = Cart::where('product_id', $id)->first();
            if ($cart->amount > 1) {
                $cart->amount -= 1;
                $cart->save();
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Data not minus'
                ], 200);
            }
        }
        $total = 0;
        $cartes = Cart::all();
        foreach ($cartes as $value) {
            $total += $value->amount * $value->product->price;
        }
        $html = view('yields.cart', compact('cartes'))->render();
        return response()->json(
            [
                'status' => true,
                'total' => $total,
                'html' => $html,
                'message' => "success work sucessfully"
            ],
            200
        );
    }

    /**
     * Remove the resource  cart.
     */
    public function cleancart($clean)
    {
        $cartes = Cart::all();
        $html = view('yields.cart', compact('cartes'))->render();
        if (isset($cartes)) {
            Cart::query()->truncate();
            return response()->json(
                [
                    'status' => true,
                    'html' => $html,
                    'message' => "success work sucessfully"
                ],
                200
            );
        }
    }

    /**
     * Save the cart in the Income
     */

    public function savecart($save)
    {

        if ($save == 'save') {
            $cartes = Cart::all();
            foreach ($cartes as $ses) {
                $product = Product::where('id', $ses['product_id'])->first();
                $product->amount = $product->amount - $ses['amount'];
                $product->save();
            }
            foreach ($cartes as $value) {
                $income = new Income();
                $income->User_id = Auth::user()->id;
                $income->product_id = $value['product_id'];
                $income->price = $value->product->price * $value['amount'];
                $income->amount = $value['amount'];
                $income->save();
            }
            Cart::query()->truncate();
            $cartes = Cart::all();
            $html = view('yields.cart', compact('cartes'))->render();
            return response()->json(
                [
                    'status' => true,
                    'html' => $html,
                    'message' => "success work sucessfully"
                ],
                200
            );
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Data not found'
            ], 200);
        }
    }
}
