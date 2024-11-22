<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\Services;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function login()
{
    return view('customer.login'); 
}

public function register()
{
    return view('customer.register');
}

    public function home()
    {
        return view('admin.dashboard');
    }
    public function about()
    {
        return view('customer.about');
    }
 
    public function contact()
    {
       $services= Services::all();

        return view("customer.contact",compact('services'));
    }
    public function store(StoreContactRequest $request)
    {
        //   dd($request->all());
//    $validateData= $request->validate([
//         'name'=>['required','min:5'],
//         'email'=>['required','email'],
//         'subject'=>['required','min:5'],
//         'message'=>['required','min:10'],
//     ]);


        $validateData = $request->validated();
     
        Contact::create($validateData);
        return back()->with('status', 'Your message has been sent successfully!');
    }


    /////////////////////////////////////////////////////////////////////////
    public function display(){
        $data=Contact::paginate(5);
        return view("customer.display-contacts",compact('data'));
    }


}
