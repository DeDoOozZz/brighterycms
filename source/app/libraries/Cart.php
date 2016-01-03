<?php

class Cart {

    private $session_id;

    function __construct() {
        $this->session_id = session_id();
    }

    public function add($product_id, $qty = 1) {
        if ($cart = Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->where('commerce_product_id', $product_id)->get('commerce_cart')->row()) {
            Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->where('commerce_product_id', $product_id)->update('commerce_cart', [
                'commerce_product_id' => $product_id,
                'qty' => ($qty + $cart->qty),
            ]);
        }
        else
            Brightery::SuperInstance()->Database->insert('commerce_cart', [
                'commerce_product_id' => $product_id,
                'qty' => $qty,
                'session_id' => $this->session_id,
            ]);
    }

    public function update($cart_id, $qty = 1) {
        Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->where('commerce_cart_id', $cart_id)->update('commerce_cart', [
            'qty' => $qty,
        ]);
    }

    public function purge() {
        Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->delete('commerce_cart');
    }

    public function remove($cart_id) {
        Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->where('commerce_cart_id', $cart_id)->delete('commerce_cart');
    }

    public function getProductId($cart_id) {
        return Brightery::SuperInstance()->Database->where('session_id', $this->session_id)->where('commerce_cart_id', $cart_id)->get('commerce_cart')->row()->commerce_product_id;
    }

    public function get() {
        return Brightery::SuperInstance()->Database
                        ->where('session_id', $this->session_id)
                        ->join('commerce_products', 'commerce_cart.commerce_product_id = commerce_products.commerce_product_id', 'inner')
                        ->get('commerce_cart')->result();
    }

    public function discount($price, $discount = 0) {
        return $price - ($price * $discount / 100);
    }

    public function total() {
        $subtotal = 0;
        foreach ($this->get() as $item){
            $subtotal += $this->discount($item->price, $item->discount)*$item->qty;
        }
        return $subtotal;
    }

    public function getItemsCount() {
        return Brightery::SuperInstance()->Database
            ->select('count(*) as count')
            ->where('session_id', $this->session_id)
            ->join('commerce_products', 'commerce_cart.commerce_product_id = commerce_products.commerce_product_id', 'inner')
            ->get('commerce_cart')->row()->count;
    }

}
