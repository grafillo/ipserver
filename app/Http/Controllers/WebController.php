<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWebRequest;
use App\Models\Web;

class WebController  extends Controller
{

    public function getWebs () {

        return Web::all();

    }

    public function addWeb (AddWebRequest $request) {

        $request = $request->validated();
        $request = Web::create($request);

        return $request;

    }

    public function delWeb(Web $web){

        $web->delete();

        return response([],200);

    }



}
