<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function (Request $request) {
    //return view('index');
    $grantcode = $request->get('code');
    $response = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'client_id'=>'3ktjc0bl3m6epbphr05bvm7e49',
        'Authorization'=>'Basic M2t0amMwYmwzbTZlcGJwaHIwNWJ2bTdlNDk6cGxkc21iZTAwamljdjhuMmFub3E0Z2Uyc3VsMmFlZmduYzQ5M2pybmU0bGl0ZjUwdnI2'
    ])->post('https://lampserver.auth.ap-south-1.amazoncognito.com/oauth2/token',[
        'grant_type'=>'authorization_code',
        'code'=>$grantcode,
        'redirect_uri'=>'http://localhost:8000'
    ]);

    $decodedResponse = json_decode($response);
    $accessToken = $decodedResponse->access_token;
    $userInfoResponse = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Bearer' .$accessToken
    ])->get('https://lampserver.auth.ap-south-1.amazoncognito.com/oauth2/userInfo');
    $data = json_decode($userInfoResponse);
    
    return view('index',['data'=>$data]); 

});