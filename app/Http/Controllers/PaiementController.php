<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $baseUrl='http://localhost:5173/';
        //configuration de paydunya
        \Paydunya\Setup::setMasterKey(env('P_MasterKey'));
        \Paydunya\Setup::setPublicKey(env('P_PublicKey_T'));
        \Paydunya\Setup::setPrivateKey(env('P_PrivateKey_T'));
        \Paydunya\Setup::setToken(env('P_Token_T'));
        \Paydunya\Setup::setMode(env('P_Mode')); // Optionnel en mode test. Utilisez cette option pour les paiements tests.


        //Configuration des informations de votre service/entreprise
        \Paydunya\Checkout\Store::setName("vente de ladoum"); // Seul le nom est requis
        \Paydunya\Checkout\Store::setTagline("L'élégance n'a pas de prix");
        \Paydunya\Checkout\Store::setPhoneNumber("770290773");
        \Paydunya\Checkout\Store::setPostalAddress("Dakar Senegal");
        \Paydunya\Checkout\Store::setWebsiteUrl("http://www.chez-sandra.sn");
        \Paydunya\Checkout\Store::setLogoUrl("http://www.chez-sandra.sn/logo.png");

        
       \Paydunya\Checkout\Store::setCallbackUrl($baseUrl."api/paydunya/callback");

        $invoice = new \Paydunya\Checkout\CheckoutInvoice();

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
        //
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
