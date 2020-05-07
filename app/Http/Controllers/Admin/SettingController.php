<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewLogCreated;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

/**
 * Class SettingController
 * @package App\Http\Controllers\Admin
 */
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();

        $name = $settings->where('key', 'name')->first();
        $number_one = $settings->where('key', 'number_one')->first();
        $number_two = $settings->where('key', 'number_two')->first();
        $logo = $settings->where('key', 'logo')->first();
        $address = $settings->where('key', 'address')->first();
        $fax = $settings->where('key', 'fax')->first();
        $phone = $settings->where('key', 'phone')->first();
        $email = $settings->where('key', 'email')->first();
        $facebook = $settings->where('key', 'facebook')->first();
        $site = $settings->where('key', 'site')->first();
        $twitter = $settings->where('key', 'twitter')->first();
        $youtube = $settings->where('key', 'youtube')->first();
        $footer = $settings->where('key', 'footer')->first();
        $welcomeBackground = $settings->where('key', 'welcomeBackground')->first();
        $welcomeMainText = $settings->where('key', 'welcomeMainText')->first();
        $welcomeSubText = $settings->where('key', 'welcomeSubText')->first();
        $welcomeReadMoreLink = $settings->where('key', 'welcomeReadMoreLink')->first();
        $welcomeReadMoreText = $settings->where('key', 'welcomeReadMoreText')->first();
        $sessionEnd = $settings->where('key', 'sessionEnd')->first();

        return view('admin.setting.update', compact('name', 'sessionEnd', 'footer', 'number_one', 'number_two', 'logo', 'address', 'facebook', 'fax', 'phone', 'email', 'site', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {

        $settings = Setting::whereIn('key', ['sessionEnd', 'footer', 'name', 'number_one', 'number_two', 'logo', 'address', 'fax', 'phone', 'email', 'facebook', 'twitter', 'youtube', 'welcomeBackground', 'welcomeMainText', 'welcomeSubText', 'welcomeReadMoreLink', 'welcomeReadMoreText'])->get();

        $name = $settings->where('key', 'name')->first();
        $number_one = $settings->where('key', 'number_one')->first();
        $number_two = $settings->where('key', 'number_two')->first();
        $logo = $settings->where('key', 'logo')->first();
        $address = $settings->where('key', 'address')->first();
        $fax = $settings->where('key', 'fax')->first();
        $phone = $settings->where('key', 'phone')->first();
        $email = $settings->where('key', 'email')->first();
        $facebook = $settings->where('key', 'facebook')->first();
        $twitter = $settings->where('key', 'twitter')->first();
        $youtube = $settings->where('key', 'youtube')->first();
        $footer = $settings->where('key', 'footer')->first();
        $welcomeBackground = $settings->where('key', 'welcomeBackground')->first();
        $welcomeMainText = $settings->where('key', 'welcomeMainText')->first();
        $welcomeSubText = $settings->where('key', 'welcomeSubText')->first();
        $welcomeReadMoreLink = $settings->where('key', 'welcomeReadMoreLink')->first();
        $welcomeReadMoreText = $settings->where('key', 'welcomeReadMoreText')->first();
        $sessionEnd = $settings->where('key', 'sessionEnd')->first();

        if ($request->hasFile('logo')) {

            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $filename = time() . '.' . $request['logo']->getClientOriginalExtension();
            $path = 'uploads/logo/site/';
            if (!file_exists(public_path($path))) {
                Storage::disk('real_public')->makeDirectory($path);
            }
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            Image::make($request['logo']->getRealPath())->resize(140, 23)->save($path . $filename);
            $logo->value = $path . $filename;
            $logo->save();
        }

        if ($request->hasFile('welcomeBackground')) {

            $request->validate([
                'welcomeBackground' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $filename = time() . '.' . $request['welcomeBackground']->getClientOriginalExtension();
            $path = 'uploads/bg/site/';
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            Image::make($request['welcomeBackground']->getRealPath())->resize(380, 100)->save($path . $filename);
            $welcomeBackground->value = $path . $filename;
            $welcomeBackground->save();

        }

        if ($name->update(['value' => $request['name']]) &&
            $number_one->update(['value' => $request['number_one']]) &&
            $number_two->update(['value' => $request['number_two']]) &&
            $address->update(['value' => $request['address']]) &&
            $fax->update(['value' => $request['fax']]) &&
            $email->update(['value' => $request['email']]) &&
            $facebook->update(['value' => $request['facebook']]) &&
            $phone->update(['value' => $request['phone']]) &&
            $twitter->update(['value' => $request['twitter']]) &&
            $footer->update(['value' => $request['footer']]) &&
            $youtube->update(['value' => $request['youtube']]) &&
            $welcomeMainText->update(['value' => $request['welcomeMainText']]) &&
            $welcomeSubText->update(['value' => $request['welcomeSubText']]) &&
            $welcomeReadMoreLink->update(['value' => $request['welcomeReadMoreLink']]) &&
            $sessionEnd->update(['value' => $request['sessionEnd']]) &&
            $welcomeReadMoreText->update(['value' => $request['welcomeReadMoreText']])
        ) {

            if (!is_null($sessionEnd->value)) {
                // update session
//              $value = config('SESSION_LIFETIME',$sessionEnd->value);
//                Artisan::call('config:clear');
//                Artisan::call('cache:clear');
//                Artisan::call('config:cache');
//                dd(Config::get('SESSION_LIFETIME'));

            }

            event(new NewLogCreated('تم تعديل اعدادت البرنامج بنجاح', null, 64, 1, url('admin/settings')));
            return back()->with('success', 'تم تعديل اعدادت البرنامج بنجاح');
        } else {
            event(new NewLogCreated('لم يتم تعديل اعدادت البرنامج بنجاح', null, 64, 1, url('admin/settings')));
            return back()->with('success', 'لم يتم تعديل اعدادت البرنامج بنجاح');
        }
    }

    /**
     * @param Request $request
     */
    public function logo_backgrounds($color)
    {
//        $color = $request['color'];
        $colorSetting = Setting::where('key', 'logo_backgrounds')->first();
        $colorSetting->update(['value' => $color]);
    }

    /**
     * @param Request $request
     */
    public function navbar_backgrounds($color)
    {
//        $color = $request['color'];
        $colorSetting = Setting::where('key', 'navbar_backgrounds')->first();
        $colorSetting->update(['value' => $color]);
    }

    /**
     * @param Request $request
     */
    public function sidebar_backgrounds($color)
    {
//        $color = $request['color'];
        $colorSetting = Setting::where('key', 'sidebar_backgrounds')->first();
        $colorSetting->update(['value' => $color]);
    }

    public function all_settings()
    {
        return view('admin.setting.all_settings');
    }

}
