<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Governorate;
use App\Events\NewLogCreated;
use App\Http\Requests\CityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class CityController
 * @package App\Http\Controllers\Admin
 */
class GovernorateController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cities($id)
    {
        if (!is_null($id)) {
            $governorate = Governorate::find($id);

            if (!is_null($governorate)) {
                return $governorate->city()->orderBy('name')->get();
            } else {
                return response()->json([
                    'message' => 'الرجاء التاكد من الرابط المطلوب'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'الرجاء التاكد من الرابط المطلوب'
            ], 401);
         }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */


}
