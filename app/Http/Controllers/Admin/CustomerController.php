<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.customers')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('customer.index');

        $customers  =   Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('customer.create');

        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $this->authorize('customer.create');

        
        $data   =   $request->all();
        $data['password']   =   Hash::make($request->get('password'));
        $customer = Customer::create($data);

        $file_name = uniqid().'.jpg';
        if($request->hasFile('image')){

            $request->file('image')->storeAs('customer', $file_name, 'uploads');

            $customer->image = $file_name;
            $customer->update();

        }else{

            Storage::disk('uploads')->copy('customer/default.jpg', 'customer/'.$file_name);

            $customer->image = $file_name;
            $customer->update();
        }

        return redirect()->route('customers.index')->with('success', __('messages.customer_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $id)
    {
        $this->authorize('customer.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $this->authorize('customer.edit');


        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->authorize('customer.edit');


        $data = $request->only(['name', 'email']);

        if(!empty($request->get('password'))){
            $data['password']   =   Hash::make($request->get('password'));
        }

        if($request->hasFile('image')){
            $file_name = uniqid().'.png';
            
            if($customer->image!='default.png')
                Storage::disk('uploads')->delete( 'customer/'.$customer->image );

            $request->file('image')->storeAs('customer', $file_name, 'uploads');
            $data['image'] = $file_name;
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', __('messages.customer_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('customer.delete');

        Storage::disk('uploads')->delete( 'customer/'.$customer->image );
        $customer->delete();
        return redirect()->route('customers.index')->with('success', __('messages.customer_deleted'));
    }
}
