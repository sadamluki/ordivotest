<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;

class ProductController extends Controller
{
    /**
     * Create a new product.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->save();

        return response()->json(
            [
                'message' => 'Product created successfully',
                'data' => $product,
            ],
            201
        );
        // return response()->json($product, 201);
    }

    /**
     * Show the details of a product.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);

            return response()->json(['data' => $product], 200);
        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    /**
     * List all products.
     *
     * @return Response
     */
    public function list()
    {
        $products = Product::all();
        return response()->json(
            ['total' => count($products), 'data' => $products],
            200
        );
    }

    /**
     * Add a product to the cart.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $product = Product::find($request->product_id);
        if ($product->quantity < $request->quantity) {
            return response()->json(
                [
                    'message' => 'Not enough stock for the product',
                ],
                400
            );
        }

        $cart_id = Cart::where('status', null)->first();

        if ($cart_id === null) {
            $new_cart = new Cart();
            $new_cart->status = null;
            $new_cart->save();

            $cart_id = $new_cart->id;
        }

        $cart = new Cart();
        $cartId = $cart->addProductToCart(
            $request->product_id,
            $request->quantity
        );

        return response()->json([
            'message' => 'Product added to cart successfully',
            'cart_id' => $cartId,
        ]);
    }

    /**
     * Checkout from the cart.
     *
     * @param  Request  $request
     * @return Response
     */
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $is_checkout = Cart::where([
            ['status', 'checkout'],
            ['id', $request->cart_id],
        ])->first();

        if ($is_checkout !== null) {
            return response()->json(
                ['errors' => 'Already checkout, try another cart'],
                400
            );
        }

        $cart = new Cart();

        $cartId = $cart->checkout($request->cart_id);
        if (!$cartId) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json(
            ['message' => 'Checkout success', 'Cart ID' => $cartId],
            200
        );
    }

    /**
     * List all orders.
     *
     * @return Response
     */
    public function listOrders()
    {
        $orders = Cart::with('cartProducts.product')
            ->where('status', 'checkout')
            ->get();

        return response()->json(
            ['total' => count($orders), 'data' => $orders],
            200
        );
    }

    /**
     * Show a summary of products and orders.
     *
     * @return Response
     */
    public function summary()
    {
        $products = Product::all();
        $orders = Cart::with('cartProducts.product')
            ->where('status', 'checkout')
            ->get();
        return response()->json(['products' => $products, 'orders' => $orders]);
    }
}
