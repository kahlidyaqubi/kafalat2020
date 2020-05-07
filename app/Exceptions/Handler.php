<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return redirect('/admin/noAccess');
        }
        if ($exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException)//منع تحميل ملف كبير جداً
        {
            return redirect()->back();
        }
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)//منع ظهور ايرور للراوت غير المعرفة
        {
            return response(view('admin.home.noAccess'), 404);;
        }
        //
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)//منع ظهور ايرور للراوت غير المعرفة
        {
            return redirect('/admin/home');
        }
        /*if ($exception instanceof \symfony\Component\debug\Exception\FatalErrorException)//الخطأ الفادح مثل الميمرورة
        {
            return redirect('/admin/expenses/invalidators?oka=5');
        }*/
        if ($exception instanceof \Illuminate\Session\TokenMismatchException)//منع ظهور ايرور للراوت غير المعرفة
        {
            // dd($exception);
            return redirect('/admin/home');
        }
        return parent::render($request, $exception);
    }
}
