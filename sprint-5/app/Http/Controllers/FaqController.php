<?php

namespace App\Http\Controllers;
use App\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function create(){
        return view('faq');
    }

    public function store(){
        request()->validate([
            'email'=> 'email|required',
            'mensaje'=> 'string|required'
        ]);
    
        $faq = Faq::create([
            'email'=> request()->email,
            'mensaje'=> request()->mensaje
        ]);

        return redirect()->route('faq.create')->with(['status'=>'Se envió correctamente el formulario']);
    }
}
