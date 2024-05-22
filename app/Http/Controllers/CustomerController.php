<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function addCustomer(Request $request)
    {

        $validate = $request->validate([
            "name" => "required",
            "phone" => "required|numeric",
            'email' => "email|required"
        ]);

        Customer::create($validate);

        return redirect("/")->with("success", "Customer Success Add");
    }
}
