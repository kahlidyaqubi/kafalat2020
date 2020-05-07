<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

/**
 * Class CheckPermission
 * @package App\Http\Middleware
 */
class CheckPermission
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (!$user)
            return redirect('/');

        if ($user != NULL) {
            //to delete prameter from route
            function delete_all_between($beginning, $end, $string)
            {
                $beginningPos = strpos($string, $beginning);
                $endPos = strpos($string, $end);
                if ($beginningPos === false || $endPos === false) {
                    return $string;
                }

                $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

                return delete_all_between($beginning, $end, str_replace($textToDelete, '', $string)); // recursion to ensure all occurrences are replaced
            }

            /*********************************/
            $currentPath = Route::getFacadeRoot()->current()->uri();
            $url = "/" . delete_all_between('/{', '}', $currentPath);

            $link = \DB::table("permissions")->where('link', $url)->first();
            //dd($link);
            //معناة انة الرابط علية صلاحيات
            if ($link != NULL) {
                $haveAdminThisLink = $user->hasPermissionTo($link->name);
                if (!$haveAdminThisLink && $link->name!='list tasks') {
                    return redirect('/admin/noAccess');
                }
            }
        }

        return $next($request);;
    }
}
