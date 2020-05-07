<?php

use Illuminate\Database\Seeder;

class NeighborhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  1,
            'name' => 'أخرى',
            'name_tr' => 'other',
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  2,
            'name' => ' الزيتون',
            'name_tr' => 'ALZEYTUN SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  3,
            'name' => 'شارع المصريين',
            'name_tr' => 'MASRİYİN CAD.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  4,
            'name' => 'شارع زمو',
            'name_tr' => ' ZİMMU SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  5,
            'name' => 'حي ابو عودة',
            'name_tr' => 'ABUODA HAY',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  6,
            'name' => 'بيارة ابو رحمة',
            'name_tr' => 'ABUREHME BEYARA',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  7,
            'name' => 'شارع العجوز',
            'name_tr' => 'ACÜZ SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  8,
            'name' => 'شارع البلدية',
            'name_tr' => 'BELEDİYE SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  9,
            'name' => 'شارع البنات',
            'name_tr' => 'BENET SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  10,
            'name' => 'بلدية بيت حانون',
            'name_tr' => 'BEYT HANUN BELEDİYE',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  11,
            'name' => 'بؤرة جميل',
            'name_tr' => 'BURA CEMİL',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  12,
            'name' => 'شارع دمرا',
            'name_tr' => 'DAMRA SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  13,
            'name' => 'شارع الواد',
            'name_tr' => 'ELVAD SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  14,
            'name' => 'شارع الفرطة',
            'name_tr' => 'FURTA SOK.',
            'city_id' => 1,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  15,
            'name' => 'شارع القرمان',
            'name_tr' => 'GARAMAN SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  16,
            'name' => 'شارع غزة',
            'name_tr' => 'GAZZE SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  17,
            'name' => 'شارع حمد',
            'name_tr' => 'HAMAD SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  18,
            'name' => 'شارع الكفارنة',
            'name_tr' => 'KEFERNE SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  19,
            'name' => 'شارع القدس',
            'name_tr' => 'KUDÜS SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  20,
            'name' => 'شارع نعيم',
            'name_tr' => 'NAYİM SOK.',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  21,
            'name' => 'شارع شبات',
            'name_tr' => 'ŞEBET SOK.',
            'city_id' => 1,

        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  22,
            'name' => 'شارع السكة',
            'name_tr' => 'SIKKA YOLU',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  23,
            'name' => 'عزبه بيت حانون',
            'name_tr' => 'BEYT HANUN İZBE',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  24,
            'name' => 'دوار زمو',
            'name_tr' => 'DİVAR ZİMO',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  25,
            'name' => 'فرطة',
            'name_tr' => 'FERTA',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  26,
            'name' => 'قرمان',
            'name_tr' => 'GARMAN',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  27,
            'name' => 'حي الامل',
            'name_tr' => 'HAY ELAMAL',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  28,
            'name' => 'جباليا النزلة',
            'name_tr' => ' CEBELİYE NAZLA',
            'city_id' => 2,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  29,
            'name' => 'بئر النعجة',
            'name_tr' => 'BİR NACE',
            'city_id' => 2,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  30,
            'name' => 'جباليا البلد',
            'name_tr' => 'CEBELİYE BALAD',
            'city_id' => 2,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  31,
            'name' => 'جباليا الفالوجا',
            'name_tr' => 'CEBELİYE FALUCA',
            'city_id' => 2,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  32,
            'name' => 'جباليا المعسكر',
            'name_tr' => 'CEBELİYE MUASKER',
            'city_id' => 2,

        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  33,
            'name' => 'تل الزعتر',
            'name_tr' => 'TEL ZATAR',
            'city_id' => 2,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  34,
            'name' => 'الجرن',
            'name_tr' => 'CÜRÜN KAVŞAĞI',
            'city_id' => 2,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  35,
            'name' => 'دوار القرم',
            'name_tr' => 'DEVAR Gırım',
            'city_id' => 2,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  36,
            'name' => 'معكسر جباليا',
            'name_tr' => 'MÖASKER CEBELİYE',
            'city_id' => 2,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  37,
            'name' => 'نزلة',
            'name_tr' => 'NEZLE',
            'city_id' => 2,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  38,
            'name' => 'شارع اصلان',
            'name_tr' => 'ASLAN SOK.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  39,
            'name' => 'شارع البرواي',
            'name_tr' => 'BARAVİ SOK.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  40,
            'name' => 'تل الذهب',
            'name_tr' => 'TEL ZEHEB',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  41,
            'name' => 'سكنة فدعوس',
            'name_tr' => 'SAKNIT FADVUS',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  42,
            'name' => 'شارع الخزان',
            'name_tr' => 'HAZAN YOLU',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  43,
            'name' => 'شارع الكمالية',
            'name_tr' => 'KEMALİYE YOLU',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  44,
            'name' => 'شارع كمال عدوان',
            'name_tr' => 'KEMAL EDVAN YOLU',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  45,
            'name' => 'عزبة دواس',
            'name_tr' => 'EZBET DAVUS',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  46,
            'name' => 'القرعة الخامسة',
            'name_tr' => '5\'Cİ GARA',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  47,
            'name' => 'عطاطرة',
            'name_tr' => 'ATATRA',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  48,
            'name' => 'منشية',
            'name_tr' => 'MANŞİYE',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  49,
            'name' => 'سلاطين',
            'name_tr' => 'SALATİN',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  50,
            'name' => 'سيفة',
            'name_tr' => 'SEYFE',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  51,
            'name' => 'جامعة امريكية',
            'name_tr' => 'AMERİKA ÜN.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  52,
            'name' => 'دوار الغربي',
            'name_tr' => 'GARBİ DİVAR',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  53,
            'name' => 'شارع الحطبية',
            'name_tr' => 'HATABA SOK.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  54,
            'name' => 'مشروع بيت لاهيا',
            'name_tr' => 'MAŞRU BEYT LAHTYA',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  55,
            'name' => 'شارع الشيماء',
            'name_tr' => 'ŞAYMA SOK.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  56,
            'name' => 'دوار السلاطين',
            'name_tr' => 'DEVAR SALATİN',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  57,
            'name' => 'شارع المنشية',
            'name_tr' => 'MANŞİYE SOK.',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  58,
            'name' => 'ابراج الندى',
            'name_tr' => 'ABRAJ NEDE',
            'city_id' => 4,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  59,
            'name' => 'قرية بدوية',
            'name_tr' => 'KARYA BEDAVİ',
            'city_id' => 4,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  60,
            'name' => 'شيخ زايد',
            'name_tr' => 'ŞEYH ZAYİD',
            'city_id' => 5,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  61,
            'name' => 'ابراج العودة',
            'name_tr' => 'AVDA SİTESİ',
            'city_id' => 6,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  62,
            'name' => 'قرية أولى',
            'name_tr' => '1\'Cİ KARYA',
            'city_id' => 7,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  63,
            'name' => 'لقرية  تانية',
            'name_tr' => '2\'Cİ KARYA',
            'city_id' => 7,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  64,
            'name' => 'شارع الفالوجة',
            'name_tr' => 'FALUJA YOLU',
            'city_id' => 8,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  65,
            'name' => 'شارع عبد الدايم',
            'name_tr' => 'ABDEDEYİM SOK',
            'city_id' => 8,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  66,
            'name' => 'شارع جميل طرخان',
            'name_tr' => 'TARHAN SOK.',
            'city_id' => 8,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  67,
            'name' => 'شجاعية',
            'name_tr' => 'ŞİCAYA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  68,
            'name' => 'ابراج المخابرات',
            'name_tr' => 'MUHABERET SİTESİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  69,
            'name' => 'ابراج المقوسي',
            'name_tr' => 'MAGUSİ SİTESİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  70,
            'name' => 'ارض الغول',
            'name_tr' => 'ARZ ELĞUL',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  71,
            'name' => 'سامر',
            'name_tr' => 'SAMIR',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  72,
            'name' => 'سرايا',
            'name_tr' => 'SERAYİH',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  73,
            'name' => 'سودانية',
            'name_tr' => 'SUDANİYE',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  74,
            'name' => 'شاليهات',
            'name_tr' => 'ŞALİYHAT',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  75,
            'name' => 'شيخ عجلين',
            'name_tr' => 'ŞEYH ECLİN',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  76,
            'name' => 'يرموك',
            'name_tr' => 'YARMUK',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  77,
            'name' => 'دوار ابو مازن',
            'name_tr' => 'DEVAR ABU MAZIN',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  78,
            'name' => 'دوار انصار',
            'name_tr' => 'DEVAR ANSAR',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  79,
            'name' => 'دوار حيدر',
            'name_tr' => 'DEVAR HİDAR',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  80,
            'name' => 'ساحة الشوا',
            'name_tr' => 'SAHET ŞEVA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  81,
            'name' => 'سوق السيارات',
            'name_tr' => 'SÜG SİYARET',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  82,
            'name' => 'شارع الصناعة',
            'name_tr' => 'SINAH YOLU',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  83,
            'name' => 'شارع المحطة',
            'name_tr' => 'MAHTA YOLU',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  84,
            'name' => 'شارع عمر المختار',
            'name_tr' => 'ÖMER MUHTAR YOLU',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  85,
            'name' => 'مفترق الشعبية',
            'name_tr' => 'MUFTEREG ŞABİYE',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  86,
            'name' => 'عمودي',
            'name_tr' => 'AMUDİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  87,
            'name' => 'جلاء',
            'name_tr' => 'CELA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  88,
            'name' => 'درج',
            'name_tr' => 'DARAC',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  89,
            'name' => 'كرامة',
            'name_tr' => 'KARAMA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  90,
            'name' => 'رمال',
            'name_tr' => 'RİMAL',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  91,
            'name' => 'شعف',
            'name_tr' => 'ŞAAF',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  92,
            'name' => 'صبرة',
            'name_tr' => 'SABRA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  93,
            'name' => 'صفطاوي',
            'name_tr' => 'SAFTAVI',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  94,
            'name' => 'صحابة',
            'name_tr' => 'SAHABA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  95,
            'name' => 'شاطئ',
            'name_tr' => 'ŞATİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  96,
            'name' => 'شمالي',
            'name_tr' => 'ŞEMALI',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  97,
            'name' => 'شيخ رضوان',
            'name_tr' => 'ŞEYH RIDVAN',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  98,
            'name' => 'سدرة',
            'name_tr' => 'SİDRA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  99,
            'name' => 'ثلاثيني',
            'name_tr' => 'TALATİNİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  100,
            'name' => 'تفاح',
            'name_tr' => 'TÜFAH',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  101,
            'name' => 'توام',
            'name_tr' => 'TÜVAM',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  102,
            'name' => 'زيتون',
            'name_tr' => 'ZEYTUN',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  103,
            'name' => 'عسقولة',
            'name_tr' => 'ASGULA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  104,
            'name' => 'ميناء',
            'name_tr' => 'MİNE',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  105,
            'name' => 'نفق',
            'name_tr' => 'NAFAK',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  106,
            'name' => 'نصر',
            'name_tr' => 'NASIR',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  107,
            'name' => 'ساحة',
            'name_tr' => 'SEHA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  108,
            'name' => 'تل الهوا',
            'name_tr' => 'TEL ALHAVA',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  109,
            'name' => 'شارع الوحدة',
            'name_tr' => 'VİHDA SOK.',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  110,
            'name' => 'ابو اسكندر',
            'name_tr' => 'ABU İSKANDER',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  111,
            'name' => 'رمال جنوبي',
            'name_tr' => 'RİMAL CENUBİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  112,
            'name' => 'مشروع عامر',
            'name_tr' => 'AMİR MEŞRU',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  113,
            'name' => 'ارض بكر',
            'name_tr' => 'BAKİR ALANI',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  114,
            'name' => 'دوار 17',
            'name_tr' => 'DİVAR 17',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  115,
            'name' => 'مخيم الشاطئ',
            'name_tr' => 'MUHAYAM ŞATİ',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  116,
            'name' => 'شعشاعة',
            'name_tr' => 'ŞÜŞEH',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  117,
            'name' => 'مستشفى الوفاء',
            'name_tr' => 'VEFA HASTANASI',
            'city_id' => 9,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  118,
            'name' => 'جحر الديك',
            'name_tr' => 'CUHR ELDİK',
            'city_id' => 10,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  119,
            'name' => 'أبراج تيكا',
            'name_tr' => 'ABRAJ TİKA',
            'city_id' => 10,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  120,
            'name' => 'عزبة أبو عيسى',
            'name_tr' => 'İZBE ABU İSA',
            'city_id' => 10,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  121,
            'name' => 'شارع المدرسة',
            'name_tr' => 'LİSE SOK.',
            'city_id' => 10,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  122,
            'name' => 'بلوك 1',
            'name_tr' => 'BLUK 1',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  123,
            'name' => 'بلوك 10',
            'name_tr' => 'BLUK 10',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  124,
            'name' => 'بلوك 11',
            'name_tr' => 'BLUK 11',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  125,
            'name' => 'بلوك 12',
            'name_tr' => 'BLUK 12',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  126,
            'name' => 'بلوك 2',
            'name_tr' => 'BLUK 2',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  127,
            'name' => 'بلوك 3',
            'name_tr' => 'BLUK 3',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  128,
            'name' => 'بلوك 4',
            'name_tr' => 'BLUK 4',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  129,
            'name' => 'بلوك 5',
            'name_tr' => 'BLUK 5',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  130,
            'name' => 'بلوك 6',
            'name_tr' => 'BLUK 6',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  131,
            'name' => 'بلوك 7',
            'name_tr' => 'BLUK 7',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  132,
            'name' => 'بلوك 8',
            'name_tr' => 'BLUK 8',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  133,
            'name' => 'بلوك 9',
            'name_tr' => 'BLUK 9',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  134,
            'name' => 'بلوك c',
            'name_tr' => 'BLUK C',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  135,
            'name' => 'مقبولة',
            'name_tr' => 'MAKBULE',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  136,
            'name' => 'تل أخضر',
            'name_tr' => 'TEL AHDAER',
            'city_id' => 11,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  137,
            'name' => 'زهراء',
            'name_tr' => 'ZAHRA',
            'city_id' => 12,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  138,
            'name' => 'مستشفى الوفاء',
            'name_tr' => 'VEFA HASTANASI',
            'city_id' => 12,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  139,
            'name' => 'مخيم جديد',
            'name_tr' => 'YENİ MUHAYEM',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  140,
            'name' => 'ابراج النصيرات',
            'name_tr' => 'NÜSEYRET SİTESİ',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  141,
            'name' => 'سوق',
            'name_tr' => 'SÜG',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  142,
            'name' => 'شارع الداخلية',
            'name_tr' => 'DAHLİYE YOLU',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  143,
            'name' => 'شارع يافا',
            'name_tr' => 'YAFA YOLU',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  144,
            'name' => 'صيدلية الزهور',
            'name_tr' => 'ZÖHÜR SAYDALİYE',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  145,
            'name' => 'مسجد الدعوة',
            'name_tr' => 'DAVA MESCİDİ',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  146,
            'name' => 'مدخل',
            'name_tr' => 'MEDHAL',
            'city_id' => 13,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  147,
            'name' => 'دوار ابو صرار',
            'name_tr' => 'DİVAR ABUSARAR',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  148,
            'name' => 'مشروع الحساينة',
            'name_tr' => 'MAŞRU ALHASAYNA',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  149,
            'name' => 'مخيم 1',
            'name_tr' => 'MUHAYAM 1',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  150,
            'name' => 'مخيم 2',
            'name_tr' => 'MUHAYAM 2',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  151,
            'name' => 'مخيم 3',
            'name_tr' => 'MUHAYAM 3',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  152,
            'name' => 'مخيم 4',
            'name_tr' => 'MUHAYAM 4',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  153,
            'name' => 'مخيم 5',
            'name_tr' => 'MUHAYAM 5',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  154,
            'name' => 'مسجد الفاروق',
            'name_tr' => 'ALFARUK CAMİİ',
            'city_id' => 13,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  155,
            'name' => 'خوالدة الشرقية',
            'name_tr' => 'HAVALDE ŞERGİYE',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  156,
            'name' => 'بئر ابو صلاح',
            'name_tr' => 'BIR ABU SALAH',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  157,
            'name' => 'جمعية الصلاح',
            'name_tr' => 'CEMİYET SALAH',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  158,
            'name' => 'شارع ابو ستة',
            'name_tr' => 'ABU SITA YOLU',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  159,
            'name' => 'شارع الاقصى',
            'name_tr' => 'AKSA YOLU',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  160,
            'name' => 'خوالدة',
            'name_tr' => 'HAVELDE',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  161,
            'name' => 'سوارحة غربية',
            'name_tr' => 'SEVERHE GARBİYE',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  162,
            'name' => 'سوارحة شرقية',
            'name_tr' => 'SEVERHE ŞARKİYE',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  163,
            'name' => 'تعابين',
            'name_tr' => 'TAABİN',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  164,
            'name' => 'سوارحة',
            'name_tr' => 'SEVARHA',
            'city_id' => 14,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  165,
            'name' => 'دوار ابو سيدو',
            'name_tr' => 'DEVAR ABU SİDO',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  166,
            'name' => 'شارع الترنس',
            'name_tr' => 'TIRANS YOLU',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  167,
            'name' => 'مربع ابو هريرة',
            'name_tr' => 'MÜREBA ABU HÜREYRA',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  168,
            'name' => 'مفترق الشهداء',
            'name_tr' => 'MÜGTERF ŞÜHADA',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  169,
            'name' => 'وادي غزة',
            'name_tr' => 'VADI GAZZE',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  170,
            'name' => 'شارع البرميل',
            'name_tr' => 'ALBARAMİL SOK.',
            'city_id' => 15,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  171,
            'name' => 'اقصى',
            'name_tr' => 'AKSA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  172,
            'name' => 'مزرعة',
            'name_tr' => 'MEZREHA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  173,
            'name' => 'مشاعلة',
            'name_tr' => 'MAŞALAH',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  174,
            'name' => 'حاجز ابو هولي',
            'name_tr' => 'HACİZ ABU HÜLEY',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  175,
            'name' => 'حي بشارة',
            'name_tr' => 'HEY BİŞARA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  176,
            'name' => 'شارع ابو عريف',
            'name_tr' => 'ABU ERİF YOLU',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  177,
            'name' => 'شارع الثانوية',
            'name_tr' => 'SENEVİYE YOLU',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  178,
            'name' => ' الدير',
            'name_tr' => 'ŞARG ELDİR',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  179,
            'name' => 'وادي السلقا',
            'name_tr' => 'VEDİ SELGE',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  180,
            'name' => 'ابراج الكلية',
            'name_tr' => 'ABRAJ KÜLLİYE',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  181,
            'name' => 'البروك',
            'name_tr' => 'AL BRÜK',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  182,
            'name' => 'البصة',
            'name_tr' => 'ALBASSA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  183,
            'name' => 'بركة',
            'name_tr' => 'BIRKA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  184,
            'name' => 'محطة',
            'name_tr' => 'MAHATA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  185,
            'name' => 'حدبة',
            'name_tr' => 'HADABA',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  186,
            'name' => 'حكر الجامع',
            'name_tr' => 'HİKIR ELCAMİ',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  187,
            'name' => 'ام ضهير',
            'name_tr' => 'OM DIHİR',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  188,
            'name' => 'كلية تقنية',
            'name_tr' => 'KÜLLİYE TEK.',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  189,
            'name' => 'بركة الوز',
            'name_tr' => 'ALVİZ',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  190,
            'name' => 'عيادة الوكالة',
            'name_tr' => 'VEKALA',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  191,
            'name' => 'المستوصف الحكومي',
            'name_tr' => 'MUSTAFSEF HÜKÜMİ',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  192,
            'name' => 'حارة البطنية',
            'name_tr' => 'HARET BATNİYE',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  193,
            'name' => 'حي الزعفران',
            'name_tr' => 'HEY ZAFARAN',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  194,
            'name' => 'دوار الصلاحات',
            'name_tr' => 'DEVAR SALAHAT',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  195,
            'name' => 'شرق المغازي',
            'name_tr' => 'ŞERG MAĞAZİ',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  196,
            'name' => 'بلوك b',
            'name_tr' => 'BLUK B',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  197,
            'name' => 'بلوك d',
            'name_tr' => 'BLUK D',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  198,
            'name' => 'دوار صدقي',
            'name_tr' => 'DEVER SIDKI',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  199,
            'name' => 'المدخل الجديد',
            'name_tr' => 'YENİ MEDHAL',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  200,
            'name' => 'الطريق الجديدة',
            'name_tr' => 'YENİ YOL',
            'city_id' => 17,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  201,
            'name' => 'حاوز المياه',
            'name_tr' => 'HAVUZ MEYA',
            'city_id' => 18,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  202,
            'name' => 'مقبرة',
            'name_tr' => 'MAKBARA',
            'city_id' => 18,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  203,
            'name' => 'خزاعة',
            'name_tr' => 'KHUZA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  204,
            'name' => 'الخرابة',
            'name_tr' => 'HARABA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  205,
            'name' => 'محافظة',
            'name_tr' => 'MOHAFAZA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  206,
            'name' => 'جامعة فلسطين',
            'name_tr' => 'FİLİSTİN ÜN.',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  207,
            'name' => 'حارة المصريين',
            'name_tr' => 'HARET MASRİYİN',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  208,
            'name' => 'مستشفى دار السلام',
            'name_tr' => 'MÜSTAŞFA DARÜSELEM',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  209,
            'name' => 'عبسان الجديدة',
            'name_tr' => 'ABASAN CEDİDE',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  210,
            'name' => 'عبسان الكبيرة',
            'name_tr' => 'ABASAN KABİRA',
            'city_id' => 25,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  211,
            'name' => 'عبسان الصغيرة',
            'name_tr' => 'ABASAN ZAĞİRA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  212,
            'name' => 'فخاري',
            'name_tr' => 'FUHARİ',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  213,
            'name' => 'قرارة',
            'name_tr' => 'GARARA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  214,
            'name' => 'سطر شرقي',
            'name_tr' => 'SATAR ŞARKİ',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  215,
            'name' => 'شيخ ناصر',
            'name_tr' => 'ŞEYH NASIR',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  216,
            'name' => 'تحلية',
            'name_tr' => 'TAHLİYE',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  217,
            'name' => 'اوروبي',
            'name_tr' => 'AVRUBİ',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  218,
            'name' => 'بني سهيلا',
            'name_tr' => 'BENİ SÜHAYİLE',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  219,
            'name' => 'حي المنارة',
            'name_tr' => 'HAY ALMANARA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  220,
            'name' => 'قاع القرين',
            'name_tr' => 'KAALKURİN',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  221,
            'name' => 'معن',
            'name_tr' => 'MA\'AN',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  222,
            'name' => 'جورة اللوت',
            'name_tr' => 'CÜRT ELUT',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  223,
            'name' => 'ارميضة',
            'name_tr' => 'İRMEYDE',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  224,
            'name' => 'منارة',
            'name_tr' => 'MENERA',
            'city_id' => 19,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  225,
            'name' => 'مدينة حمد',
            'name_tr' => 'HAMAD ŞEHİRİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  226,
            'name' => 'حي هولندي',
            'name_tr' => 'HAY HOLANDİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  227,
            'name' => 'حي اماراتي',
            'name_tr' => 'HAY İMARATİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  228,
            'name' => 'حي نمساوي',
            'name_tr' => 'HAY NİMSAVİ',
            'city_id' => 25,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  229,
            'name' => 'حي ياباني',
            'name_tr' => 'HAY YABANİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  230,
            'name' => 'المشروع',
            'name_tr' => 'ALMAŞRU',
            'city_id' => 3,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  231,
            'name' => 'مواصي',
            'name_tr' => 'MEVASI',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  232,
            'name' => 'معسكر غربي',
            'name_tr' => 'MUASKAR ĞARBİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  233,
            'name' => 'سطر غربي',
            'name_tr' => 'SATIR GARBİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  234,
            'name' => 'حي العرايشية',
            'name_tr' => 'HAY ALARAYŞİYE',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  235,
            'name' => 'أبراج قطر',
            'name_tr' => 'ABRAJ KATAR',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  236,
            'name' => 'حي الامل',
            'name_tr' => 'HAY ELAMAL',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  237,
            'name' => 'مشروع اماراتي',
            'name_tr' => 'MAŞRU EMERETİ',
            'city_id' => 20,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  238,
            'name' => 'البطن السمين',
            'name_tr' => 'BATIN SAMİN',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  239,
            'name' => 'حارة البيوك',
            'name_tr' => 'HARET BEYÜK',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  240,
            'name' => 'حارة المجايدة',
            'name_tr' => 'HARET MECEYDE',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  241,
            'name' => 'دوار ابو حميد',
            'name_tr' => 'DEVAR ABU HEMIT',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  242,
            'name' => 'شارع جلال',
            'name_tr' => 'CELAL YOLU',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  243,
            'name' => 'شارع جمال عبد الناصر',
            'name_tr' => 'CEMEL ABDÜLNASIR CAD',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  244,
            'name' => 'طريق رفح الغربية',
            'name_tr' => 'TARİG REFAH GAR.',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  245,
            'name' => 'قيزان النجار',
            'name_tr' => 'GİZAN NAJAR',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  246,
            'name' => 'كتيبة',
            'name_tr' => 'KATİPE',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  247,
            'name' => 'كراج رفح',
            'name_tr' => 'KERAJ REFAH',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  248,
            'name' => 'قيزان ابو رشوان',
            'name_tr' => 'KİZAN ABU RAŞVAN',
            'city_id' => 21,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  249,
            'name' => 'مطار',
            'name_tr' => 'MATAR',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  250,
            'name' => 'معبر',
            'name_tr' => 'MABER',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  251,
            'name' => 'شوكة',
            'name_tr' => 'ŞÜKA',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  252,
            'name' => 'حي النصر',
            'name_tr' => 'HAY ALNASIR',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  253,
            'name' => 'حي السلام',
            'name_tr' => 'HAY ALSALAM',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  254,
            'name' => 'خربة العدس',
            'name_tr' => 'HİRBET ALADAS',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  255,
            'name' => 'ميراج',
            'name_tr' => 'MİRAJ',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  256,
            'name' => 'شوكة شمالية',
            'name_tr' => 'KUZEY ŞÜKE',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  257,
            'name' => 'شوكة الوسطى',
            'name_tr' => 'ORTA ŞÜKE',
            'city_id' => 22,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  258,
            'name' => 'حي الجنينة',
            'name_tr' => 'HAY CENİYNE',
            'city_id' => 26,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  259,
            'name' => 'حي البراهمة',
            'name_tr' => 'HEY BEREHME',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  260,
            'name' => 'حي كندا',
            'name_tr' => 'HEY KANADA',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  261,
            'name' => 'بحر',
            'name_tr' => 'BAHAR',
            'city_id' => 16,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  262,
            'name' => 'حي سعودي',
            'name_tr' => 'LHAY SUADİ',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  263,
            'name' => 'دوار زعرب',
            'name_tr' => 'DİVAR ZURUP',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  264,
            'name' => 'حي شعوت',
            'name_tr' => 'HAY ŞÜAT',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  265,
            'name' => 'مخيم بدر',
            'name_tr' => 'MUHAYAM BADIR',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  266,
            'name' => 'قرية سويدية',
            'name_tr' => 'KARYA SEVİDİ',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  267,
            'name' => 'تل السلطان',
            'name_tr' => 'TEL SULTAN',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  268,
            'name' => 'ميراج الغربية',
            'name_tr' => 'MIRAJ GARBİYE',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  269,
            'name' => 'مشروع سعودي',
            'name_tr' => 'MAŞRU SUADİ',
            'city_id' => 23,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  270,
            'name' => 'دوار العودة',
            'name_tr' => 'DEVAR AVDE',
            'city_id' => 24,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  271,
            'name' => 'دوار النجمة',
            'name_tr' => 'DEVAR NİJMA',
            'city_id' => 24,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  272,
            'name' => 'مخيم بربرة',
            'name_tr' => 'MUHEYİM BERBERA',
            'city_id' => 24,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  273,
            'name' => 'شابورة',
            'name_tr' => 'ŞABURA',
            'city_id' => 24,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  274,
            'name' => 'حي البرازيل',
            'name_tr' => 'HAY ALBARAZİL',
            'city_id' => 24,


        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  275,
            'name' => 'عريبة',
            'name_tr' => 'İRİBEH',
            'city_id' => 24,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  276,
            'name' => 'منطقة مصبح',
            'name_tr' => 'MSABEH',
            'city_id' => 24,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  277,
            'name' => 'يبنا',
            'name_tr' => 'YÜBNE',
            'city_id' => 24,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  278,
            'name' => 'الشارع العام',
            'name_tr' => 'ANA CAD',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  279,
            'name' => 'خلف البلدية',
            'name_tr' => 'BELEDİYE ARKASI',
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  280,
            'name' => 'موقف',
            'name_tr' => 'MAVGIF',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  281,
            'name' => 'البلد',
            'name_tr' => 'ALBALAD',
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  282,
            'name' => 'معسكر',
            'name_tr' => 'MUASKAR',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  283,
            'name' => 'جمارك',
            'name_tr' => 'CEMERİK',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  284,
            'name' => 'ايرز',
            'name_tr' => 'EİRİZ',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  285,
            'name' => 'شارع صلاح الدين',
            'name_tr' => 'SALAHEDDİN CAD.',
            'city_id' => NULL,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  286,
            'name' => ' المخابرات',
            'name_tr' => 'MUHABERET',
            'city_id' => 9,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  287,
            'name' => ' رفح الغربية',
            'name_tr' => ' REFAH GAR.',
            'city_id' => 21,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  288,
            'name' => ' القرية الأولى',
            'name_tr' => NULL,
            'city_id' => 7,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  289,
            'name' => ' بيت حانون',
            'name_tr' => 'BEYT HANUN',
            'city_id' => 1,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  290,
            'name' => ' الشوكة الجنوبية',
            'name_tr' => '',
            'city_id' => 27,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  291,
            'name' => ' القرية البدوية',
            'name_tr' => NULL,
            'city_id' => 28,
        ]);


        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  292,
            'name' => 'العريبة',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  293,
            'name' => 'المغراقة',
            'name_tr' => NULL,
            'city_id' => 15,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  294,
            'name' => 'الزوايدة',
            'name_tr' => NULL,
            'city_id' => 14,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  295,
            'name' => 'الشرقية',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  296,
            'name' => 'رفح',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  297,
            'name' => 'العامودي',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  298,
            'name' => 'النصيرات',
            'name_tr' => NULL,
            'city_id' => 13,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  299,
            'name' => 'خانيونس',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  300,
            'name' => 'السنتيشن',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  301,
            'name' => 'اللبابيدي',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  302,
            'name' => 'برج 22',
            'name_tr' => NULL,
            'city_id' => 4,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  303,
            'name' => 'الطريق العام',
            'name_tr' => NULL,
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  304,
            'name' => 'صوفا',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  305,
            'name' => 'البريج',
            'name_tr' => NULL,
            'city_id' => 11,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  306,
            'name' => 'القلعة',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  307,
            'name' => 'المصدر',
            'name_tr' => NULL,
            'city_id' => 18,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  308,
            'name' => 'الشمال',
            'name_tr' => NULL,
            'city_id' => 28,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  309,
            'name' => 'الهوجا',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  310,
            'name' => 'غزة',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  311,
            'name' => 'مدخل القرية',
            'name_tr' => NULL,
            'city_id' => 7,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  312,
            'name' => ' عيادة الوكالة',
            'name_tr' => NULL,
            'city_id' => 17,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  313,
            'name' => ' برج 16',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  314,
            'name' => ' برج 21',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  315,
            'name' => ' برج 23',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  316,
            'name' => 'بلوك g',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  317,
            'name' => 'بلوك k',
            'name_tr' => NULL,
            'city_id' => 13,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  318,
            'name' => 'شارع النادي',
            'name_tr' => NULL,
            'city_id' => 3,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  319,
            'name' => 'شارع قطر',
            'name_tr' => NULL,
            'city_id' => 10,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  320,
            'name' => 'فندق الأمل',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  321,
            'name' => 'برج 11',
            'name_tr' => NULL,
            'city_id' => 12,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  322,
            'name' => 'برج 12',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  323,
            'name' => 'برج 14',
            'name_tr' => NULL,
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  324,
            'name' => 'حى الصلاح',
            'name_tr' => NULL,
            'city_id' => 1,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  325,
            'name' => 'حى ابو عبيدة',
            'name_tr' => NULL,
            'city_id' => 3,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  326,
            'name' => 'برج 6',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  327,
            'name' => 'برج 34',
            'name_tr' => NULL,
            'city_id' => 5,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  328,
            'name' => 'برج 25',
            'name_tr' => NULL,
            'city_id' => 12,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  329,
            'name' => 'الأبراج',
            'name_tr' => NULL,
            'city_id' => null,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  330,
            'name' => 'الزنة',
            'name_tr' => NULL,
            'city_id' => 12,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  331,
            'name' => 'الفاخورة',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  332,
            'name' => 'القصاصيب',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  333,
            'name' => ' الامن العام',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  334,
            'name' => ' الاتصالات',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  335,
            'name' => ' الترخيص القديم',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  336,
            'name' => 'الجامع الكبير',
            'name_tr' => NULL,
            'city_id' => 17,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  337,
            'name' => 'العبور',
            'name_tr' => NULL,
            'city_id' => 27,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  338,
            'name' => ' العلمي',
            'name_tr' => NULL,
            'city_id' => 3,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  339,
            'name' => 'المدرسة الزراعية',
            'name_tr' => NULL,
            'city_id' => 1,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  340,
            'name' => 'المدرسة الأمريكية',
            'name_tr' => NULL,
            'city_id' => 3,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  341,
            'name' => ' الغربية',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  342,
            'name' => ' المزلقان',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  343,
            'name' => 'المشاهرة',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  344,
            'name' => 'المشتل',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  345,
            'name' => 'عبسان',
            'name_tr' => NULL,
            'city_id' => 25,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  346,
            'name' => 'صلاح الدين',
            'name_tr' => NULL,
            'city_id' => null,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  347,
            'name' => 'شارع الجمارك',
            'name_tr' => NULL,
            'city_id' => 1,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  348,
            'name' => 'شارع ابو عوده',
            'name_tr' => NULL,
            'city_id' => 1,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  349,
            'name' => 'جباليا',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  350,
            'name' => 'بيت لاهيا',
            'name_tr' => NULL,
            'city_id' => 3,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  351,
            'name' => 'المنطقة الشرقية',
            'name_tr' => NULL,
            'city_id' => 11,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  352,
            'name' => 'المغازي',
            'name_tr' => NULL,
            'city_id' => 17,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  353,
            'name' => 'المحطة',
            'name_tr' => NULL,
            'city_id' => 16,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  354,
            'name' => 'أبراج دير البلح',
            'name_tr' => NULL,
            'city_id' => 16,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  355,
            'name' => ' البلدية',
            'name_tr' => 'BELEDİYE',
            'city_id' => null,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  356,
            'name' => ' الترنس',
            'name_tr' => NULL,
            'city_id' => 2,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  357,
            'name' => ' الرمال الشمالي',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  358,
            'name' => 'الخط الشرقي',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  359,
            'name' => 'الحي السعودي 5',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  360,
            'name' => 'الحي السعودي 4',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  361,
            'name' => 'الحي السعودي 3',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  362,
            'name' => 'الحي السعودي 2',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  363,
            'name' => 'الجمارك',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  364,
            'name' => 'أبراج الكويت',
            'name_tr' => NULL,
            'city_id' => 10,
        ]);

        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  365,
            'name' => ' القرية البدوية 2',
            'name_tr' => NULL,
            'city_id' => 28,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  366,
            'name' => ' القرية البدوية 1',
            'name_tr' => NULL,
            'city_id' => 28,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  367,
            'name' => 'ŞAVA',
            'name_tr' => NULL,
            'city_id' => 9,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  368,
            'name' => 'موراج العطاطرة',
            'name_tr' => NULL,
            'city_id' => 26,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  369,
            'name' => 'بجوار مكتب ضيوف الرحمن',
            'name_tr' => NULL,
            'city_id' => 13,
        ]);
        \App\Neighborhood::create([
            'status'=> 1,
            'id' =>  370,
            'name' => 'بؤرة ابو غزالة',
            'name_tr' => 'BURA ABU GAZALE',
            'city_id' => 1,
        ]);

    }
}