<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    /**
     * The products that belong to the cart.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Add a product to the cart.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function addProduct(Product $product, $quantity = 1)
    {
        $this->products()->attach($product, [
            'quantity' => $quantity,
        ]);
    }

    /**
     * Remove a product from the cart.
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products()->detach($product);
    }

    /**
     * Get the total price of the cart.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->price * $product->pivot->quantity;
        }
        return $total;
    }

    public function addProductToCart($productId, $quantity)
    {
        $cartId = $this->where('status', null)
            ->orderBy('id', 'desc')
            ->first()->id;

        if ($cartId === null) {
            $cartId = $this->create(['status' => null])->id;
        }

        // insert data into cart_product table
        DB::table('cart_product')->insert([
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return $cartId;
    }

    public function checkout($cart_id)
    {
        $cart = $this->find($cart_id);
        if (!$cart) {
            return false;
        }

        $cart_products = $cart->cartProducts;
        foreach ($cart_products as $cart_product) {
            $product = Product::find($cart_product->product_id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            if ($product->quantity < $cart_product->quantity) {
                return response()->json(
                    ['error' => 'Product quantity is not enough'],
                    400
                );
            }
            $product->decrement('quantity', $cart_product->quantity);
        }

        $this->where('id', $cart_id)->update(['status' => 'checkout']);

        return $cart_id;
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
}
