<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Events\OrderStatusChanged;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function getOrders()
    {

        return DB::table('orders')->get();
 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $topping = implode(",",$request['topping']);
        

        $order = Order::create([
            'customerName' => $request['customer_name'],
            'customer_id' =>  $request['customer_id'],
            'size' => $request['size'],
            'address' => $request['address'],
            'topping' => $topping         
        ]);
        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = DB::table('orders')
                ->where('orderid', $id)
                ->update(['status' => $request['status']]);
        $status = $request['status'];
        $orderid = $request['orderid'];
        $key = $request['key'];
        $orderS = array(
            $key,
            $orderid,
            $status
        );
        event(new OrderStatusChanged($orderS));
        // return $order;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
