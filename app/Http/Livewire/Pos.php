<?php

namespace App\Http\Livewire;

use Darryldecode\Cart\Facades\CartFacade as Cart;

use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use JeroenNoten\LaravelAdminLte\Components\Widget\Card;
use Livewire\Component;

class Pos extends Component
{
    public $total, $itemsQuantity, $efectivo, $change;

    protected $listeners = ['scan-code' => 'scanCode', 'removeItem' => 'removeItem', 'clearCart' => 'clearCart', 'saveSale' => 'saveSale'];


    public function mount() {
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
    }

    public function render()
    {
        $denominations = Denomination::orderBy('value', 'desc')->get();
        $cart = Cart::getContent()->sortBy('name');


        return view('livewire.pos.pos', compact('denominations', 'cart'))
                ->extends('layouts.theme.app')
                ->section('content');
    }

    public function ACash($value) {
        
        if($value == 0) {
            $this->efectivo = 0;
        }

        $this->efectivo += ($value == 0 ? $this->total : $value);

        $this->change = ($this->efectivo - $this->total);

    }

    public function scanCode($barcode, $cant = 1) {

        
        $product = Product::where('barcode', $barcode)->first();
        
        if($product == null ){#|| empty($empty)){
            $this->emit('scan-notfound', 'Producto no Registrado');
        } else {

            if($this->InCart($product->id)){
                $this->increaseQty($product->id);
                return;
            }
            if($product->stock < 1) {
                $this->emit('no-stock', 'Productos insuficientes');
                return;
            }


            Cart::add($product->id, $product->name, $product->price, $cant, $product->imagen);

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('scan-ok', 'Producto agregado');
        }
    }


    public function InCart($productId) {
        $exist = Cart::get($productId);

        if($exist) {
            return true;
        } else {
            return false;
        }
    }

    public function updateQty($productId, $cant = 1) {
        $title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if($exist) {
            $title = 'Cantidad actualizada';
        }
        else {
            $title = 'Producto agregado';
        }

        if($exist) {
            if($product->stock < $cant) {
                $this->emit('no-stock', 'Productos insuficientes');
                return;
            }
        }

        $this->removeItem($productId);

        if($cant > 0) {
            Cart::add($product->id, $product->name, $product->price, $cant, $product->imagen);

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();

            $this->emit('scan-ok', $title);
        }
    }

    public function removeItem($productId) {

        Cart::remove($productId);

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto Eliminado');
    }

    public function increaseQty($productId, $cant = 1) {
        $title = '';

        $product = Product::find($productId);

        $exist = Cart::get($productId);

        if($exist) {
            $title = 'Cantidad Actualizada';
        } else {
            $title = 'Producto Agregado';
        }

        if($exist) {
            if($product->stock < ($cant + $exist->quantity)) {
                $this->emit('no-stock', 'Cantidad Insuficiente');
                return;
            }
        }

        Cart::add($product->id, $product->name, $product->price, $cant, $product->imagen);

        $this->total = Cart::getTotal();

        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', $title);
    }

    


    public function decreaseQty($productId) {

        $item = Cart::get($productId);

        Cart::remove($productId);

        $newQty = ($item->quantity) - 1;

        if($newQty > 0) {
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

        }

        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('scan-ok', 'Producto Actualizado');
    }

    public function clearCart() {
        Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;


        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
     
        $this->emit('scan-ok', 'Venta Eliminada');
    }

    public function saveSale() {

        if($this->total <= 0) {
            $this->emit('sale-error', 'AGREGA PRODUCTOS A LA VENTA');
            return;
        }

        if($this->efectivo <= 0) {
            $this->emit('sale-error', 'INGRESE EL EFECTIVO');
            return;
        }

        if($this->total > $this->efectivo) {
            $this->emit('sale-error', 'EFECTIVO DEBE SER MAYOR O IGUAL A LA VENTA');
            return;
        }

        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'total' => $this->total,
                'items' => $this->itemsQuantity,
                'cash' => $this->efectivo,
                'change' => $this->change,
                'user_id' => Auth::user()->id,
            ]);

            

            if($sale) {
                $items = Cart::getContent();

                foreach ($items as $item) {
                    SaleDetails::create([
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'product_id' => $item->id,
                        'sale_id' => $sale->id,
                    ]);

                    //Actualizar stock
                    $product = Product::find($item->id);

                    $product->stock = $product->stock - $item->quantity;

                    $product->save();
                }
            }

            DB::commit();

            Cart::clear();
            $this->efectivo = 0;
            $this->change = 0;

            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
     
            $this->emit('save-ok', 'VENTA REGISTRADA CON EXITO');
            $this->emit('print-ticker', $sale->id);


        } catch (Exception $e) {
            DB::rollBack();

            $this->emit('sale-error', $e->getMessage());
        }
    }

    public function printTicket($sale) {
        return Redirect::to("print://$sale->id");
    }

    public function updated() {
        
        if ($this->efectivo == '') {
            $this->efectivo = 0;
        }

        if($this->efectivo != 0) {
            $this->change = ($this->efectivo - $this->total);
        }
    }
}
