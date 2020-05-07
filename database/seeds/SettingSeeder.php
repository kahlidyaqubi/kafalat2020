<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'name', 'value' => 'جمعيه ياردم الي التركيه'],
            ['key' => 'number_one', 'value' => null],
            ['key' => 'number_two', 'value' => null],
            ['key' => 'logo', 'value' => null],
            ['key' => 'address', 'value' => null],
            ['key' => 'fax', 'value' => null],
            ['key' => 'phone', 'value' => null],
            ['key' => 'email', 'value' => 'Gaza@yardimeli.org.tr'],
            ['key' => 'facebook', 'value' => 'https://www.facebook.com/yardimeliAR/'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/yardimeliAR'],
            ['key' => 'youtube', 'value' => 'https://www.youtube.com/channel/UCGLKV2tgN4rKwAL8trz38Uw'],
            ['key' => 'footer', 'value' => 'جميع الحقوق محفوظه لجميعه ياردم الي'],
            ['key' => 'logo_backgrounds', 'value' => 'skin5'],
            ['key' => 'navbar_backgrounds', 'value' => 'skin6'],
            ['key' => 'sidebar_backgrounds', 'value' => 'skin5'],
            ['key' => 'welcomeMainText', 'value' => 'مرحبا بكم في جمعية ياردم إلي التركية'],
            ['key' => 'welcomeSubText', 'value' => 'مرحبا بك في لوحة تحكم جمعية ياردم إلي'],
            ['key' => 'welcomeReadMoreText', 'value' => 'اقراء المزيد'],
            ['key' => 'welcomeReadMoreLink', 'value' => 'http://a.hams.site/finalYar/public/'],
            ['key' => 'welcomeBackground', 'value' => null],
            ['key' => 'sessionEnd', 'value' => null],
        ]);
    }
}
