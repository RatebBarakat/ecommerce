<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // public function index(Request $request)
    // {
    //     // return view('front.envoice',[
    //     //     'cards' => Cart::getContent()
    //     // ]);
    //     // $filename = Str::random(20)."_envoice".rand(1,100).".pdf";
    //     // //   $pdf = PDF::loadView('envoice.blade', $data);
    //     // //   Storage::put('public/envoices/'.$filename, $pdf->output());
        
    //     // $cards = Cart::getContent();
    //     // $pdf = PDF::loadView('front.envoice', compact('cards'));
    //     // Storage::put('public/envoices/'.$filename, $pdf->output());
    //     // return redirect('/');
    // }
}
