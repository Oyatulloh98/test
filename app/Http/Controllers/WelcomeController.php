<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Models\Income;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function PHPSTORM_META\type;
use function Psy\debug;

class WelcomeController extends Controller
{
    public function index()
    {
       
    }



    public function store($code)
    {
        $product = Product::where('code', $code)->first();
        if (isset($product)) {
            $cart = session()->get('cart', []);
            if (isset($cart[$code])) {
                $cart[$code]['quantity']++;
            } else {
                $cart[$code] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "code" => $product->code,
                ];
            }
            session()->put('cart', $cart);
            return response()->json(
                [
                    'cart' => $cart
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'error' => 'This product no'
                ]
            );
        }
    }


    public function reset()
    {
        Session::forget('cart');
        Alert::success('Congrats', 'Successfully cleaned Cart');
        return redirect(route('welcome.index'));
    }


    public function delete($forcedelete)
    {
        return response()->json(
            [
                'succes' => "true"
            ],
        );
        // $sesions = Session::get('cart');
        // dd($sesions);
        // $last = null;
        // for ($i = 0; $i < count($sesions); $i++) {
        //     if ($sesions[$i]['product_id'] == $forcedelete) {
        //         $last = $i;
        //         break;
        //     }
        // }
        // // dd($last);
        // $valueIndexToDelete = $last; // Replace 0 with the index you want to delete
        // session()->forget('cart.' . $valueIndexToDelete);
        // Alert::success('Successfully', 'This product put in the Cart');
        // return redirect(route('welcome.index'));
    }

    /*
   *
   *  Bu yerda productni sonidan ayirdim
   * 
   *  */

    public function minusfromcart($id)
    {
        $product = Product::where('id', $id)->first();
        // dd($product);
        $sesion_items = Session::get('cart');
        $checkCart = null;
        for ($i = 0; $i < count($sesion_items); $i++) {
            if ($sesion_items[$i]['product_id'] == $id) {
                $checkCart = $i;
                break;
            }
        }
        if ($checkCart === null) {
            Alert::error('Error', 'Not true command');
            return redirect(route('welcome.index'));
        } else {
            if ($sesion_items[$checkCart]['amount'] != 0) {
                $sesion_items[$checkCart]['amount'] -= 1;
                $sum = $sesion_items[$checkCart]['price'] - $product->price;
                $sesion_items[$checkCart]['price'] = $sum;
            } else {
                $checkCart = null;
                for ($i = 0; $i < count($sesion_items); $i++) {
                    if ($sesion_items[$i]['product_id'] == $id) {
                        $checkCart = $i;
                        break;
                    }
                }
                $valueIndexToDelete = $checkCart; // Replace 0 with the index you want to delete
                session()->forget('cart.' . $valueIndexToDelete);
                Alert::success('Successfully', 'This product deleted in the Cart');
                return redirect(route('welcome.index'));
            }
        }
        Session::put('cart', $sesion_items);
        return redirect(route('welcome.index'));
    }
    public function minus(Product $product)
    {
        $session = Session::get('cart');
        foreach ($session as $ses) {
            $product = Product::where('id', $ses['product_id'])->first();
            $product->amount = $product->amount - $ses['amount'];
            $product->save();
        }
        foreach ($session as $value) {
            $income = new Income();
            $income->User_id = Auth::user()->id;
            $income->product_id = $value['product_id'];
            $income->price = $value['price'];
            $income->amount = $value['amount'];
            $income->save();
        }
        Session::forget('cart');
        Alert::success('Congrats', 'Successfully cleaned Cart');
        return redirect(route('product.index'));
    }

    public function sold()
    {
        $incomes = Income::all();
        return view('dashboard.product.index', compact([
            'incomes',
        ]));
    }
}
