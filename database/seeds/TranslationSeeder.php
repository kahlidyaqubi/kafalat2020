<?php

use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('name_translations')->insert([
//            ['arabic' => 'سجين', 'turkey' => 'MAHKUM'],
//            ['arabic' => 'محبوس', 'turkey' => 'TUTUKLU'],
//            ['arabic' => 'أرملة', 'turkey' => 'DUL'],
//            ['arabic' => 'أسير', 'turkey' => 'ESİR'],
//            ['arabic' => 'آنسة/أعزب', 'turkey' => 'İŞSİZ'],
//            ['arabic' => 'تارك الأسرة', 'turkey' => 'AİLESİNİ TERK ETMİŞ'],
//            ['arabic' => 'شهيد/ة', 'turkey' => 'ŞEHİT'],
//            ['arabic' => 'متزوج/ة', 'turkey' => 'EVLİ'],
//            ['arabic' => 'متوفى/ة', 'turkey' => 'RAHMETLİ'],
//            ['arabic' => 'مسن/ة', 'turkey' => 'YAŞLI'],
//            ['arabic' => 'ربة بيت', 'turkey' => 'EV HANIMI '],
//            ['arabic' => 'جريح', 'turkey' => 'YARALI'],
//            ['arabic' => 'مسافر', 'turkey' => 'YOLCU'],
//            ['arabic' => 'مطلقة', 'turkey' => 'BOŞANMIŞ'],
//            ['arabic' => 'مفقود', 'turkey' => 'KAYIP'],
//            ['arabic' => 'ابن', 'turkey' => 'OĞLU'],
//            ['arabic' => 'ابن الخال/ة', 'turkey' => 'KUZEN'],
//            ['arabic' => 'ابن الزوج', 'turkey' => 'VEY OĞUL'],
//            ['arabic' => 'ابن العم/ة', 'turkey' => 'KUZEN'],
//            ['arabic' => 'ابن/ة الاخ/ت', 'turkey' => 'YEĞEN'],
//            ['arabic' => 'ابنة', 'turkey' => 'KIZI'],
//            ['arabic' => 'اخ', 'turkey' => 'ERKEK KARDEŞİ'],
//            ['arabic' => 'اخ الزوج', 'turkey' => 'KAYIN BİRADER'],
//            ['arabic' => 'اخ الزوجة', 'turkey' => 'KAYIN BİRADER'],
//            ['arabic' => 'اخت', 'turkey' => 'KIZ KARDEŞİ'],
//            ['arabic' => 'اخت الزوج', 'turkey' => 'GÖRÜMCE'],
//            ['arabic' => 'اخت الزوجة', 'turkey' => 'BALDIZ'],
//            ['arabic' => 'الحالة', 'turkey' => 'KENDİSİ'],
//            ['arabic' => 'ام', 'turkey' => 'ANNESİ'],
//            ['arabic' => 'أب', 'turkey' => 'BABASI'],
//            ['arabic' => 'بنت الزوج', 'turkey' => 'VEY KIZ'],
//            ['arabic' => 'جدة', 'turkey' => 'NİNE'],
//            ['arabic' => 'جدة', 'turkey' => 'BABAANNE'],
//            ['arabic' => 'حفيد/ة', 'turkey' => 'TORUNU'],
//            ['arabic' => 'حماية', 'turkey' => 'KAYNANA'],
//            ['arabic' => 'خال', 'turkey' => 'DAYI'],
//            ['arabic' => 'خالة', 'turkey' => 'TEYZE'],
//            ['arabic' => 'رب الاسرة', 'turkey' => 'AİLE REİSİ '],
//            ['arabic' => 'زوج', 'turkey' => 'KOCASI'],
//            ['arabic' => 'زوج الام', 'turkey' => 'VEY BABA'],
//            ['arabic' => 'زوجة', 'turkey' => 'HANIMI'],
//            ['arabic' => 'زوجة ابن', 'turkey' => 'OĞLUNUN HANIMI'],
//            ['arabic' => 'زوجة اخ', 'turkey' => 'KARDEŞİNİN HANIMI'],
//            ['arabic' => 'زوجة الاب', 'turkey' => 'VEY ANNE'],
//            ['arabic' => 'زوجة الابن', 'turkey' => 'OĞUL HANIMI'],
//            ['arabic' => 'زوجة اولى', 'turkey' => '1\'Cİ HANIMI'],
//            ['arabic' => 'زوجة ثالثة', 'turkey' => '3\'Cİ HANIMI'],
//            ['arabic' => 'زوجة ثانية', 'turkey' => '2\'Cİ HANIMI'],
//            ['arabic' => 'شقيقة', 'turkey' => 'VEY KARDEŞ'],
//            ['arabic' => 'صهر/زوج الابنة', 'turkey' => 'KAYINBİRADER'],
//            ['arabic' => 'عديل', 'turkey' => 'BACANAK'],
//            ['arabic' => 'عم', 'turkey' => 'AMCA'],
//            ['arabic' => 'عمة', 'turkey' => 'HALA'],
//            ['arabic' => 'والد الزوج', 'turkey' => 'KAYINPEDER'],
//            ['arabic' => 'طالب/ة مدرسة', 'turkey' => 'OKUL ÖĞR.'],
//            ['arabic' => 'منقطع عن الجامعة', 'turkey' => 'ÜN. TERK ETMİŞ'],
//            ['arabic' => 'منقطع عن المدرسة', 'turkey' => 'OKUNMASINI TERK ETMİŞ'],
//            ['arabic' => 'خريج/ة جامعة', 'turkey' => 'ÜNİVERSİTE MEZUNU'],
//            ['arabic' => 'طالب/ة روضة', 'turkey' => 'ANA OKUL'],
//            ['arabic' => 'طالب/ة مهنى', 'turkey' => 'MESLEK LİSESİ'],
//            ['arabic' => 'طالب/ة ثانوية عامة', 'turkey' => 'LİSE ÖĞRENCİSİ'],
//            ['arabic' => 'خريج/ة ثانوية', 'turkey' => 'LİSE MEZUNU'],
//            ['arabic' => 'طالب/ة جامعة', 'turkey' => 'ÜNİVERSİTE ÖĞR.'],
//            ['arabic' => 'طفل/ة', 'turkey' => 'ÇOCUK'],
//            ['arabic' => 'يناير', 'turkey' => 'Ocak'],
//            ['arabic' => 'فبراير', 'turkey' => 'Şubat'],
//            ['arabic' => 'مارس', 'turkey' => 'Mart'],
//            ['arabic' => 'ابريل', 'turkey' => 'Nisan'],
//            ['arabic' => 'مايو', 'turkey' => 'Mayıs'],
//            ['arabic' => 'يونيو', 'turkey' => 'Haziran'],
//            ['arabic' => 'يوليو', 'turkey' => 'Temmuz'],
//            ['arabic' => 'أغسطس', 'turkey' => 'Ağustos'],
//            ['arabic' => 'سبتمبر', 'turkey' => 'Eylül'],
//            ['arabic' => 'أكتوبر', 'turkey' => 'Ekim'],
//            ['arabic' => 'نوفمبر', 'turkey' => 'Kasım'],
//            ['arabic' => 'ديسمبر', 'turkey' => 'Aralık'],
//            ['arabic' => 'متقاعد', 'turkey' => 'EMEKLİ'],
//            ['arabic' => 'حارس', 'turkey' => 'KABICI'],
//            ['arabic' => 'دهان', 'turkey' => 'BOYACI'],
//            ['arabic' => 'موظف', 'turkey' => 'MEMUR'],
//            ['arabic' => 'موظف حكومى', 'turkey' => 'DEVLET MEMURU'],
//            ['arabic' => 'موظف خاص', 'turkey' => 'MEMUR'],
//            ['arabic' => 'موظف سلطة', 'turkey' => 'GÖREVLİ'],
//            ['arabic' => 'ربة بيت', 'turkey' => 'EV HANIMI'],
//            ['arabic' => 'سائق', 'turkey' => 'ŞÖFÖR'],
//            ['arabic' => 'عامل', 'turkey' => 'İŞCİ'],
//            ['arabic' => 'عامل متقطع', 'turkey' => 'GEÇİCİ İŞÇİ'],
//            ['arabic' => 'لا يعمل', 'turkey' => 'İŞSİZ'],
//            ['arabic' => 'محافظة الشمال', 'turkey' => 'KUZEY'],
//            ['arabic' => 'محافظة غزة', 'turkey' => 'GAZZE'],
//            ['arabic' => 'محافظة الوسطى', 'turkey' => 'VESTA'],
//            ['arabic' => 'محافظة خانيونس', 'turkey' => 'HANYUNİS'],
//            ['arabic' => 'محافظة رفح', 'turkey' => 'RAFAH'],
//            ['arabic' => 'وثائق أخرى', 'turkey' => 'diğer belgeler'],
//            ['arabic' => 'صورة العائلة', 'turkey' => 'AİLE FOTOSU'],
//            ['arabic' => 'تقرير طبي', 'turkey' => 'SAĞLIK RAPORU'],
//            ['arabic' => 'صورة البيت', 'turkey' => 'EV FOTOSU'],
//            ['arabic' => 'شهادة وفاة', 'turkey' => 'VEFAT BELGESİ'],
//            ['arabic' => 'تقارير اخرى', 'turkey' => 'ÇEŞİTLİ RAPORLAR'],
//            ['arabic' => 'عقد ايجار', 'turkey' => 'KİRA SÖZLEŞMESİ'],
//            ['arabic' => 'شهادة قيد', 'turkey' => 'ÖĞRENCİ BELGESİ'],
//            ['arabic' => 'الهوية', 'turkey' => 'KİMLİK'],
//            ['arabic' => 'افادة هدم', 'turkey' => 'YIKIMA BELGEİ'],
//            ['arabic' => 'افادة اضرار', 'turkey' => 'HASAR BELGESİ'],
//            ['arabic' => 'شهادة طلاق', 'turkey' => 'BOŞANMA BELGESİ'],
//            ['arabic' => 'الشكر', 'turkey' => 'teşekkür mektubu'],
//            ['arabic' => 'سيء', 'turkey' => 'KÖTÜ'],
//            ['arabic' => 'سيء جدا', 'turkey' => 'ÇOK KÖTÜ'],
//            ['arabic' => 'مقبول', 'turkey' => 'MAKBUL'],
//            ['arabic' => 'جيد', 'turkey' => 'İYİ'],
//            ['arabic' => 'متوسط', 'turkey' => 'ORTA'],
//            ['arabic' => 'الأمر للكافل', 'turkey' => 'KARAR SAHİBİ VEREN EL'],
//            ['arabic' => 'بيت حانون', 'turkey' => 'BEYT HANUN'],
//            ['arabic' => 'جباليا', 'turkey' => 'CABALYA'],
//            ['arabic' => 'بيت لاهيا', 'turkey' => 'BEYT LAHYE'],
//            ['arabic' => 'ابراج الندى', 'turkey' => 'NADA ABRAJ'],
//            ['arabic' => 'شيخ زايد', 'turkey' => 'ŞİH ZAYİD'],
//            ['arabic' => 'ابراج العودة', 'turkey' => 'AVDA ABRAJ'],
//            ['arabic' => 'قرية بدوية', 'turkey' => 'GARYA BEDEVİ'],
//            ['arabic' => 'عزبة بيت حانون', 'turkey' => 'BEYT HANUN İZBE'],
//            ['arabic' => 'مدينة غزة', 'turkey' => 'GAZZE'],
//            ['arabic' => 'جحر الديك', 'turkey' => 'CUHR ELDİK'],
//            ['arabic' => 'بريج', 'turkey' => 'BÜRİC'],
//            ['arabic' => 'زهراء', 'turkey' => 'ZAHRA'],
//            ['arabic' => 'نصيرات', 'turkey' => 'NÜSEYRET'],
//            ['arabic' => 'زوايدة', 'turkey' => 'ZAVEYİDE'],
//            ['arabic' => 'مغراقة', 'turkey' => 'MUĞRAKA'],
//            ['arabic' => 'دير البلح', 'turkey' => 'DYR ALBALAH'],
//            ['arabic' => 'مغازي', 'turkey' => 'MAĞAZI'],
//            ['arabic' => 'مصدر', 'turkey' => 'MUSADİR'],
//            ['arabic' => 'خانيونس الشرقية', 'turkey' => 'HANYUNİS ŞERGİYE'],
//            ['arabic' => 'خانيونس الغربية', 'turkey' => 'HANYUNİS ĞARBİYE'],
//            ['arabic' => 'خانيونس البلد', 'turkey' => 'HANYUNİS ELBELAD'],
//            ['arabic' => 'رفح الشرقية', 'turkey' => 'REFAH ŞERGİYE'],
//            ['arabic' => 'رفح الغربية', 'turkey' => 'REFAH ĞARBİYE'],
//            ['arabic' => 'رفح البلد', 'turkey' => 'REFAH ELBELAD'],
//            ['arabic' => 'خانيونس', 'turkey' => 'HANYUNİS'],
//            ['arabic' => 'رفح', 'turkey' => 'REFAH'],
//            ['arabic' => 'فلسطين', 'turkey' => 'Filistin'],
//            ['arabic' => 'عائلة الأخوة', 'turkey' => 'Kardeşler ailesi'],
//            ['arabic' => 'تعليم الأيتام', 'turkey' => 'Yetimlerin eğitimi'],
//            ['arabic' => 'ارتجاج في المخ', 'turkey' => 'Beyin Sarsıntısı'],
//            ['arabic' => 'ازدواجية شخصية', 'turkey' => 'Şizofren'],
//            ['arabic' => 'ازمة صدرية', 'turkey' => 'GÖĞÜS AĞRISI'],
//            ['arabic' => 'اسهال', 'turkey' => 'ishal '],
//            ['arabic' => 'اضطراب بالنمو', 'turkey' => 'YAYGIN GELİŞİMSEL BOZUKLUK'],
//            ['arabic' => 'اعصاب', 'turkey' => 'SİNİR'],
//            ['arabic' => 'اغماء، غشيان', 'turkey' => 'Bayılmak'],
//            ['arabic' => 'اكتئاب', 'turkey' => ' manik depresif '],
//            ['arabic' => 'اكتئاب و هوس', 'turkey' => 'Depresyon ve manik depresif hastalık'],
//            ['arabic' => 'التهاب شعبي حاد', 'turkey' => 'bronşit '],
//            ['arabic' => 'التهاب قولون', 'turkey' => 'kalın bağırsak iltihabi'],
//            ['arabic' => 'التهاب مفاصل', 'turkey' => 'arterit'],
//            ['arabic' => 'التواء', 'turkey' => ' burkulma'],
//            ['arabic' => 'العقل الواعي، المنطقي', 'turkey' => 'Şuur, bilinç (Rasyonel)'],
//            ['arabic' => 'الم عصبي', 'turkey' => 'NEVRALJİ'],
//            ['arabic' => 'امراض جلدية', 'turkey' => 'Cildiye Hastalığı'],
//            ['arabic' => 'انزلاق غضروفي', 'turkey' => 'OMURGE EĞRİLİĞİ'],
//            ['arabic' => 'انسداد الشرايين', 'turkey' => 'damar tıkanmas'],
//            ['arabic' => 'انسداد رئوي', 'turkey' => 'Kronik Obstrüktif Akciğer Hastalığı'],
//            ['arabic' => 'انطوائي', 'turkey' => 'Otizm'],
//            ['arabic' => 'انفصام', 'turkey' => 'şizofreni '],
//            ['arabic' => 'انفلونزا', 'turkey' => 'grip '],
//            ['arabic' => 'أبرص', 'turkey' => 'Cüzamlı'],
//            ['arabic' => 'أذن وسطى', 'turkey' => 'Orta kulak '],
//            ['arabic' => 'أعرج', 'turkey' => 'topal '],
//            ['arabic' => 'أمعاء دقيقة', 'turkey' => 'ince bağırsak'],
//            ['arabic' => 'أمعاء غليظة', 'turkey' => 'kalın bağısak'],
//            ['arabic' => 'أورام', 'turkey' => 'KAPARMA'],
//            ['arabic' => 'بُلعوم', 'turkey' => 'yutak '],
//            ['arabic' => 'بتر', 'turkey' => 'AMPÜTASYON'],
//            ['arabic' => 'بدانة', 'turkey' => 'şişmanlık'],
//            ['arabic' => 'بروستاتا', 'turkey' => ' Prostat'],
//            ['arabic' => 'بلغم', 'turkey' => 'balgam'],
//            ['arabic' => 'تاكل مفاصل الحوض', 'turkey' => 'kemiğin avasküler nekrozu'],
//            ['arabic' => 'تأخر النطق', 'turkey' => 'Konuşma Gecikmesi'],
//            ['arabic' => 'تجلط الدم', 'turkey' => 'Koagülasyon; pıhtılaşma '],
//            ['arabic' => 'تخمة', 'turkey' => 'Mide fesadı'],
//            ['arabic' => 'تشنج', 'turkey' => 'Konvülziyon'],
//            ['arabic' => 'تشوه خلقي', 'turkey' => 'yaratılış bozukluğu'],
//            ['arabic' => 'تضخم كلى', 'turkey' => 'nefromegali'],
//            ['arabic' => 'تضيق في القصبات - حساسية', 'turkey' => 'Kua'],
//            ['arabic' => 'تقدم في العمر', 'turkey' => 'Yaşın artması'],
//            ['arabic' => 'تقلص عضلي', 'turkey' => 'kas krampları'],
//            ['arabic' => 'تقيؤ', 'turkey' => 'kusma '],
//            ['arabic' => 'تكسر الدم', 'turkey' => 'hemolitik anemi'],
//            ['arabic' => 'تلاثيميا', 'turkey' => 'Talasemi'],
//            ['arabic' => 'تلوث او تسمم الدم', 'turkey' => 'septisemi / Bakteriyemi '],
//            ['arabic' => 'تليف رئتين', 'turkey' => 'PULMONER FİBROZİS'],
//            ['arabic' => 'تليف كبد', 'turkey' => 'Karaciğer Fibrozisi '],
//            ['arabic' => 'توتر', 'turkey' => 'Gerginlik'],
//            ['arabic' => 'توحد', 'turkey' => 'OTİZM HASTALIĞI'],
//            ['arabic' => 'جُدري', 'turkey' => 'çiçek hastalığı '],
//            ['arabic' => 'جراحة تجميلية', 'turkey' => 'Estetik '],
//            ['arabic' => 'جرب', 'turkey' => ' uyuz'],
//            ['arabic' => 'جرب، حكة', 'turkey' => 'Uyuz'],
//            ['arabic' => 'جلطة', 'turkey' => 'PIHTI'],
//            ['arabic' => 'جلطة دماغية دموية', 'turkey' => 'BEYİN KAN PIHTISI'],
//            ['arabic' => 'جلطة دموية', 'turkey' => 'kan pıhtısı '],
//            ['arabic' => 'جنون', 'turkey' => 'Akılsız, deli'],
//            ['arabic' => 'جيوب', 'turkey' => 'Sinozit '],
//            ['arabic' => 'حجامة', 'turkey' => 'Hacamatçılık, kanamla sanatı'],
//            ['arabic' => 'حرق', 'turkey' => 'YANIK'],
//            ['arabic' => 'حساسية', 'turkey' => 'ALERJİ'],
//            ['arabic' => 'حصبة', 'turkey' => 'kızamık '],
//            ['arabic' => 'حماق، جدري الماء', 'turkey' => 'su çiçeği '],
//            ['arabic' => 'حمى الدريس', 'turkey' => 'saman nezlesi'],
//            ['arabic' => 'حمى شوكية - التهاب السحايا', 'turkey' => 'Menenjit'],
//            ['arabic' => 'حمى صفراء', 'turkey' => 'sarı humma'],
//            ['arabic' => 'خلع ولادة', 'turkey' => 'Doğumsal Kalça Çıkığı\n\n\n'],
//            ['arabic' => 'دوالي', 'turkey' => 'Varis '],
//            ['arabic' => 'ذئبة حمراء', 'turkey' => 'Sistemik lupus eritematozusun '],
//            ['arabic' => 'رباط صليبي', 'turkey' => 'çapraz bağ '],
//            ['arabic' => 'ربو', 'turkey' => 'astım '],
//            ['arabic' => 'ربو تشعبي', 'turkey' => 'bronşiyal astım'],
//            ['arabic' => 'رعاش', 'turkey' => 'Parkinson'],
//            ['arabic' => 'رهاب', 'turkey' => 'Fobiler '],
//            ['arabic' => 'روماتيد', 'turkey' => 'Romatizmal'],
//            ['arabic' => 'روماتيزم', 'turkey' => 'romatizma'],
//            ['arabic' => 'روماتيود المفاصل', 'turkey' => 'Romatoid artrit'],
//            ['arabic' => 'رئة', 'turkey' => 'akciğer '],
//            ['arabic' => 'زائدة', 'turkey' => 'Apandisit'],
//            ['arabic' => 'زكام، رشح', 'turkey' => 'nezle'],
//            ['arabic' => 'زواج احفاد', 'turkey' => 'TORUN EVLİLİKLERİ'],
//            ['arabic' => 'سرطان', 'turkey' => 'KANSER'],
//            ['arabic' => 'سرطان أمعاء', 'turkey' => 'Bağırsak kanseri'],
//            ['arabic' => 'سرطان ثدي', 'turkey' => 'meme kanseri'],
//            ['arabic' => 'سرطان جلدي', 'turkey' => 'CİLT KANSERİ '],
//            ['arabic' => 'سرطان حنجرة', 'turkey' => 'girtlak kanseri'],
//            ['arabic' => 'سرطان دم', 'turkey' => 'KAN KANSERİ'],
//            ['arabic' => 'سرطان قولون', 'turkey' => 'Kolon kanser\''],
//            ['arabic' => 'سعال', 'turkey' => 'Öksürük'],
//            ['arabic' => 'سكتة قلبية', 'turkey' => 'kalp krizi'],
//            ['arabic' => 'سكري', 'turkey' => 'DİYABET'],
//            ['arabic' => 'سل', 'turkey' => 'TÜBERKÜLOZ'],
//            ['arabic' => 'سلس البول', 'turkey' => 'Bağırsak inkontinansı'],
//            ['arabic' => 'سلس براز', 'turkey' => 'Dışkı kaçırma'],
//            ['arabic' => 'سمنة', 'turkey' => 'OBEZİTE'],
//            ['arabic' => 'سوء تغذية', 'turkey' => 'malnütrisyon'],
//            ['arabic' => 'سوء/عسر الهضم', 'turkey' => 'hazımsızlık'],
//            ['arabic' => 'شراهة', 'turkey' => 'Oburluk'],
//            ['arabic' => 'شلل', 'turkey' => 'felç '],
//            ['arabic' => 'شلل أطفال', 'turkey' => 'çocuk felci '],
//            ['arabic' => 'شيخوخة', 'turkey' => 'YAŞLILIK'],
//            ['arabic' => 'صداع', 'turkey' => 'baş ağrısı '],
//            ['arabic' => 'صداع نصفي', 'turkey' => 'MİGREN'],
//            ['arabic' => 'صداع نصفي - شقيقة', 'turkey' => 'Migren'],
//            ['arabic' => 'صدف', 'turkey' => 'Sedef '],
//            ['arabic' => 'صدفية', 'turkey' => 'SEDEF HASTALIĞI'],
//            ['arabic' => 'صدمة', 'turkey' => 'Şok '],
//            ['arabic' => 'صرع', 'turkey' => 'ELPİLEPSİ'],
//            ['arabic' => 'ضعف اللغة و الكلام', 'turkey' => 'DİL VE KONUŞMA BOZUKLUĞU'],
//            ['arabic' => 'ضغط', 'turkey' => ' tansiyon'],
//            ['arabic' => 'ضغط وسكري', 'turkey' => 'TANISYON VE ŞEKER'],
//            ['arabic' => 'ضمور اعصاب', 'turkey' => 'Sinir atrofisi'],
//            ['arabic' => 'ضمور عقل', 'turkey' => 'Beyin atrofisi'],
//            ['arabic' => 'ضيق نفس', 'turkey' => 'NEFES DARLIĞI'],
//            ['arabic' => 'طب الأسنان', 'turkey' => 'diş hekimi '],
//            ['arabic' => 'طحال', 'turkey' => 'dalak '],
//            ['arabic' => 'طفح جلدي، حكة', 'turkey' => ' kaşıntı'],
//            ['arabic' => 'عجز', 'turkey' => ' İmpotans'],
//            ['arabic' => 'عطاس', 'turkey' => 'hapşırmak '],
//            ['arabic' => 'عظمية', 'turkey' => 'Ortopedi - '],
//            ['arabic' => 'عقم', 'turkey' => 'Kısırlık'],
//            ['arabic' => 'علاج كهربائي', 'turkey' => 'Fizik tedavi'],
//            ['arabic' => 'غازات في المعدة', 'turkey' => 'Gastrit'],
//            ['arabic' => 'غدة درقية', 'turkey' => 'TİROİD'],
//            ['arabic' => 'غدة لعابية', 'turkey' => 'tükürük bezleri '],
//            ['arabic' => 'غدة نخامية', 'turkey' => 'hipofizi pitüiter bez '],
//            ['arabic' => 'غسيل كلى', 'turkey' => 'Diyaliz '],
//            ['arabic' => 'غضروف', 'turkey' => 'KIKIRDAK'],
//            ['arabic' => 'غياب وعي، فقدان ذاكرة', 'turkey' => 'Komaya girmek; Alzayemır'],
//            ['arabic' => 'فتق، فتوق', 'turkey' => 'Fıtık'],
//            ['arabic' => 'فحص طبي', 'turkey' => 'tipi muayene '],
//            ['arabic' => 'فشل كلوي', 'turkey' => 'BÖBREK YETMEZLİĞİ '],
//            ['arabic' => 'فصام، إزدواجية شخصية', 'turkey' => 'şizofreni '],
//            ['arabic' => 'فقدان ذاكرة', 'turkey' => 'Alzheimer '],
//            ['arabic' => 'فقر الدم - انيميا  الوراثي', 'turkey' => 'Talasemi'],
//            ['arabic' => 'فقر دم', 'turkey' => 'ANEMİ'],
//            ['arabic' => 'قرحة', 'turkey' => ' ülser'],
//            ['arabic' => 'قرحة المعدة', 'turkey' => 'ülser; mide hastalığı '],
//            ['arabic' => 'قصر نظر', 'turkey' => 'MİYOPİ'],
//            ['arabic' => 'قصور نخاع العظم المكتسب', 'turkey' => ' Edinsel Kemik iliği yetmezlikleri'],
//            ['arabic' => 'قفص صدري', 'turkey' => 'toraks '],
//            ['arabic' => 'قلب', 'turkey' => 'KALP'],
//            ['arabic' => 'قلق', 'turkey' => 'anksiyete; endişe '],
//            ['arabic' => 'قلق ، اضطراب نفسي', 'turkey' => 'Psikolojik hastalık'],
//            ['arabic' => 'قيئ', 'turkey' => 'Kusmak'],
//            ['arabic' => 'كبد', 'turkey' => 'karaciğer'],
//            ['arabic' => 'كبد وبائي', 'turkey' => 'HEPATİT'],
//            ['arabic' => 'كتف', 'turkey' => 'omuz '],
//            ['arabic' => 'كسر', 'turkey' => 'kırık '],
//            ['arabic' => 'كسر حوض', 'turkey' => 'Avasküler Nekroz'],
//            ['arabic' => 'كلوي مزمن', 'turkey' => 'KRONİK BÖBEK'],
//            ['arabic' => 'كلى', 'turkey' => 'BÖBREK'],
//            ['arabic' => 'لثة', 'turkey' => 'dişeti '],
//            ['arabic' => 'لوكيميا', 'turkey' => 'Lösemiler'],
//            ['arabic' => 'مخيخ', 'turkey' => 'Beyincik-'],
//            ['arabic' => 'مرارة', 'turkey' => 'Safra kesesi '],
//            ['arabic' => 'مرض عصبي', 'turkey' => 'Sinir hastalığı'],
//            ['arabic' => 'مريض نفسي', 'turkey' => 'PSİKOLOJİ HASTASI'],
//            ['arabic' => 'مرئ', 'turkey' => 'Yemek borusu ( özefakos ) '],
//            ['arabic' => 'مصران اعور', 'turkey' => 'Apantest'],
//            ['arabic' => 'معاق بالتعلم', 'turkey' => 'Özgül öğrenme güçlüğü'],
//            ['arabic' => 'معاق تشنج', 'turkey' => 'SPASTİK ENGELLİ'],
//            ['arabic' => 'معاق/ة', 'turkey' => 'ENGELLİ'],
//            ['arabic' => 'معاق/ة بصرياً', 'turkey' => 'GÖRME ENGELLİ'],
//            ['arabic' => 'معاق/ة حركياً', 'turkey' => 'FİZİKSEL ENGELLİ'],
//            ['arabic' => 'معاق/ة سمعياً', 'turkey' => 'İŞİTME ENGELLİ'],
//            ['arabic' => 'معاق/ة عقلياً', 'turkey' => 'ZİHNİSEL ENGELLİ'],
//            ['arabic' => 'معالجة بالاشعاع', 'turkey' => 'RADYOTERAPİ'],
//            ['arabic' => 'معدة', 'turkey' => 'mide '],
//            ['arabic' => 'مغص', 'turkey' => 'karın ağrısı '],
//            ['arabic' => 'منغولي/ة', 'turkey' => 'MOĞOL'],
//            ['arabic' => 'مياه في الرئتين', 'turkey' => 'Akciğer Ödemi'],
//            ['arabic' => 'نسيان', 'turkey' => 'Unutkanlık'],
//            ['arabic' => 'نقص سكر الدم', 'turkey' => 'hipoglisem'],
//            ['arabic' => 'نقص مناعة', 'turkey' => 'İMMÜN YETMEZLİK'],
//            ['arabic' => 'نقص هرمون النمو', 'turkey' => 'büyüme hormonu eksikliği '],
//            ['arabic' => 'هشاشة عظام', 'turkey' => 'OSTEOPOROZ'],
//            ['arabic' => 'هظم', 'turkey' => 'Sindirmek'],
//            ['arabic' => 'وراثي', 'turkey' => 'genetik '],
//            ['arabic' => 'ورم', 'turkey' => 'tümör'],
//            ['arabic' => 'ورم سرطاني', 'turkey' => 'KANSER TÜMÖRÜ'],
//            ['arabic' => 'ورم غدد', 'turkey' => 'ADENOMA'],
//            ['arabic' => 'ورم في الدماغ', 'turkey' => 'Beyin tümörü'],
//            ['arabic' => 'ورم ليفي', 'turkey' => 'LİFLİ TÜMÖR'],
//            ['arabic' => 'ورم، اورام', 'turkey' => 'Ur, şişlik'],
//            ['arabic' => 'وسواس قهري', 'turkey' => 'obsesif kompulsif bozukluk hastalıklarından ']
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'بؤرة ابو غزالة',
//            'turkey' => 'BURA ABU GAZALE',
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => ' الزيتون',
//            'turkey' => 'ALZEYTUN SOK.',
//        ]);
//
//        \App\NameTranslation::create([
//
//            'arabic' => 'شارع المصريين',
//            'turkey' => 'MASRİYİN CAD.',
//
//        ]);
//
//        \App\NameTranslation::create([
//
//            'arabic' => 'شارع زمو',
//            'turkey' => ' ZİMMU SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//
//            'arabic' => 'حي ابو عودة',
//            'turkey' => 'ABUODA HAY',
//
//        ]);
//
//        \App\NameTranslation::create([
//
//            'arabic' => 'بيارة ابو رحمة',
//            'turkey' => 'ABUREHME BEYARA',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 7,
//            'arabic' => 'شارع العجوز',
//            'turkey' => 'ACÜZ SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع البلدية',
//            'turkey' => 'BELEDİYE SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع البنات',
//            'turkey' => 'BENET SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'بلدية بيت حانون',
//            'turkey' => 'BEYT HANUN BELEDİYE',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'بؤرة جميل',
//            'turkey' => 'BURA CEMİL',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع دمرا',
//            'turkey' => 'DAMRA SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع الواد',
//            'turkey' => 'ELVAD SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع الفرطة',
//            'turkey' => 'FURTA SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع القرمان',
//            'turkey' => 'GARAMAN SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع غزة',
//            'turkey' => 'GAZZE SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع حمد',
//            'turkey' => 'HAMAD SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع الكفارنة',
//            'turkey' => 'KEFERNE SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع القدس',
//            'turkey' => 'KUDÜS SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع نعيم',
//            'turkey' => 'NAYİM SOK.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع شبات',
//            'turkey' => 'ŞEBET SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'شارع السكة',
//            'turkey' => 'SIKKA YOLU',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'عزبه بيت حانون',
//            'turkey' => 'BEYT HANUN İZBE',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'دوار زمو',
//            'turkey' => 'DİVAR ZİMO',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'فرطة',
//            'turkey' => 'FERTA',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'arabic' => 'قرمان',
//            'turkey' => 'GARMAN',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 27,
//            'arabic' => 'حي الامل',
//            'turkey' => 'HAY ELAMAL',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 28,
//            'arabic' => 'جباليا النزلة',
//            'turkey' => ' CEBELİYE NAZLA',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 29,
//            'arabic' => 'بئر النعجة',
//            'turkey' => 'BİR NACE',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 30,
//            'arabic' => 'جباليا البلد',
//            'turkey' => 'CEBELİYE BALAD',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 31,
//            'arabic' => 'جباليا الفالوجا',
//            'turkey' => 'CEBELİYE FALUCA',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 32,
//            'arabic' => 'جباليا المعسكر',
//            'turkey' => 'CEBELİYE MUASKER',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 33,
//            'arabic' => 'تل الزعتر',
//            'turkey' => 'TEL ZATAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 34,
//            'arabic' => 'الجرن',
//            'turkey' => 'CÜRÜN KAVŞAĞI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 35,
//            'arabic' => 'دوار القرم',
//            'turkey' => 'DEVAR Gırım',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 36,
//            'arabic' => 'معكسر جباليا',
//            'turkey' => 'MÖASKER CEBELİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 37,
//            'arabic' => 'نزلة',
//            'turkey' => 'NEZLE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 38,
//            'arabic' => 'شارع اصلان',
//            'turkey' => 'ASLAN SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 39,
//            'arabic' => 'شارع البرواي',
//            'turkey' => 'BARAVİ SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 40,
//            'arabic' => 'تل الذهب',
//            'turkey' => 'TEL ZEHEB',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 41,
//            'arabic' => 'سكنة فدعوس',
//            'turkey' => 'SAKNIT FADVUS',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 42,
//            'arabic' => 'شارع الخزان',
//            'turkey' => 'HAZAN YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 43,
//            'arabic' => 'شارع الكمالية',
//            'turkey' => 'KEMALİYE YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 44,
//            'arabic' => 'شارع كمال عدوان',
//            'turkey' => 'KEMAL EDVAN YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 45,
//            'arabic' => 'عزبة دواس',
//            'turkey' => 'EZBET DAVUS',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 46,
//            'arabic' => 'القرعة الخامسة',
//            'turkey' => '5\'Cİ GARA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 47,
//            'arabic' => 'عطاطرة',
//            'turkey' => 'ATATRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 48,
//            'arabic' => 'منشية',
//            'turkey' => 'MANŞİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 49,
//            'arabic' => 'سلاطين',
//            'turkey' => 'SALATİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 50,
//            'arabic' => 'سيفة',
//            'turkey' => 'SEYFE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 51,
//            'arabic' => 'جامعة امريكية',
//            'turkey' => 'AMERİKA ÜN.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 52,
//            'arabic' => 'دوار الغربي',
//            'turkey' => 'GARBİ DİVAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 53,
//            'arabic' => 'شارع الحطبية',
//            'turkey' => 'HATABA SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 54,
//            'arabic' => 'مشروع بيت لاهيا',
//            'turkey' => 'MAŞRU BEYT LAHTYA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 55,
//            'arabic' => 'شارع الشيماء',
//            'turkey' => 'ŞAYMA SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 56,
//            'arabic' => 'دوار السلاطين',
//            'turkey' => 'DEVAR SALATİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 57,
//            'arabic' => 'شارع المنشية',
//            'turkey' => 'MANŞİYE SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 58,
//            'arabic' => 'ابراج الندى',
//            'turkey' => 'ABRAJ NEDE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 59,
//            'arabic' => 'قرية بدوية',
//            'turkey' => 'KARYA BEDAVİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 60,
//            'arabic' => 'شيخ زايد',
//            'turkey' => 'ŞEYH ZAYİD',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 61,
//            'arabic' => 'ابراج العودة',
//            'turkey' => 'AVDA SİTESİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 62,
//            'arabic' => 'قرية أولى',
//            'turkey' => '1\'Cİ KARYA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 63,
//            'arabic' => 'لقرية  تانية',
//            'turkey' => '2\'Cİ KARYA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 64,
//            'arabic' => 'شارع الفالوجة',
//            'turkey' => 'FALUJA YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 65,
//            'arabic' => 'شارع عبد الدايم',
//            'turkey' => 'ABDEDEYİM SOK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 66,
//            'arabic' => 'شارع جميل طرخان',
//            'turkey' => 'TARHAN SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 67,
//            'arabic' => 'شجاعية',
//            'turkey' => 'ŞİCAYA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 68,
//            'arabic' => 'ابراج المخابرات',
//            'turkey' => 'MUHABERET SİTESİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 69,
//            'arabic' => 'ابراج المقوسي',
//            'turkey' => 'MAGUSİ SİTESİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 70,
//            'arabic' => 'ارض الغول',
//            'turkey' => 'ARZ ELĞUL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 71,
//            'arabic' => 'سامر',
//            'turkey' => 'SAMIR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 72,
//            'arabic' => 'سرايا',
//            'turkey' => 'SERAYİH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 73,
//            'arabic' => 'سودانية',
//            'turkey' => 'SUDANİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 74,
//            'arabic' => 'شاليهات',
//            'turkey' => 'ŞALİYHAT',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 75,
//            'arabic' => 'شيخ عجلين',
//            'turkey' => 'ŞEYH ECLİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 76,
//            'arabic' => 'يرموك',
//            'turkey' => 'YARMUK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 77,
//            'arabic' => 'دوار ابو مازن',
//            'turkey' => 'DEVAR ABU MAZIN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 78,
//            'arabic' => 'دوار انصار',
//            'turkey' => 'DEVAR ANSAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 79,
//            'arabic' => 'دوار حيدر',
//            'turkey' => 'DEVAR HİDAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 80,
//            'arabic' => 'ساحة الشوا',
//            'turkey' => 'SAHET ŞEVA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 81,
//            'arabic' => 'سوق السيارات',
//            'turkey' => 'SÜG SİYARET ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 82,
//            'arabic' => 'شارع الصناعة',
//            'turkey' => 'SINAH YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 83,
//            'arabic' => 'شارع المحطة',
//            'turkey' => 'MAHTA YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 84,
//            'arabic' => 'شارع عمر المختار',
//            'turkey' => 'ÖMER MUHTAR YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 85,
//            'arabic' => 'مفترق الشعبية',
//            'turkey' => 'MUFTEREG ŞABİYE ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 86,
//            'arabic' => 'عمودي',
//            'turkey' => 'AMUDİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 87,
//            'arabic' => 'جلاء',
//            'turkey' => 'CELA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 88,
//            'arabic' => 'درج',
//            'turkey' => 'DARAC',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 89,
//            'arabic' => 'كرامة',
//            'turkey' => 'KARAMA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 90,
//            'arabic' => 'رمال',
//            'turkey' => 'RİMAL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 91,
//            'arabic' => 'شعف',
//            'turkey' => 'ŞAAF',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 92,
//            'arabic' => 'صبرة',
//            'turkey' => 'SABRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 93,
//            'arabic' => 'صفطاوي',
//            'turkey' => 'SAFTAVI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 94,
//            'arabic' => 'صحابة',
//            'turkey' => 'SAHABA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 95,
//            'arabic' => 'شاطئ',
//            'turkey' => 'ŞATİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 96,
//            'arabic' => 'شمالي',
//            'turkey' => 'ŞEMALI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 97,
//            'arabic' => 'شيخ رضوان',
//            'turkey' => 'ŞEYH RIDVAN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 98,
//            'arabic' => 'سدرة',
//            'turkey' => 'SİDRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 99,
//            'arabic' => 'ثلاثيني',
//            'turkey' => 'TALATİNİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 100,
//            'arabic' => 'تفاح',
//            'turkey' => 'TÜFAH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 101,
//            'arabic' => 'توام',
//            'turkey' => 'TÜVAM',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 102,
//            'arabic' => 'زيتون',
//            'turkey' => 'ZEYTUN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 103,
//            'arabic' => 'عسقولة',
//            'turkey' => 'ASGULA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 104,
//            'arabic' => 'ميناء',
//            'turkey' => 'MİNE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 105,
//            'arabic' => 'نفق',
//            'turkey' => 'NAFAK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 106,
//            'arabic' => 'نصر',
//            'turkey' => 'NASIR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 107,
//            'arabic' => 'ساحة',
//            'turkey' => 'SEHA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 108,
//            'arabic' => 'تل الهوا',
//            'turkey' => 'TEL ALHAVA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 109,
//            'arabic' => 'شارع الوحدة',
//            'turkey' => 'VİHDA SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 110,
//            'arabic' => 'ابو اسكندر',
//            'turkey' => 'ABU İSKANDER',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 111,
//            'arabic' => 'رمال جنوبي',
//            'turkey' => 'RİMAL CENUBİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 112,
//            'arabic' => 'مشروع عامر',
//            'turkey' => 'AMİR MEŞRU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 113,
//            'arabic' => 'ارض بكر',
//            'turkey' => 'BAKİR ALANI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 114,
//            'arabic' => 'دوار 17 ',
//            'turkey' => 'DİVAR 17',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 115,
//            'arabic' => 'مخيم الشاطئ',
//            'turkey' => 'MUHAYAM ŞATİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 116,
//            'arabic' => 'شعشاعة',
//            'turkey' => 'ŞÜŞEH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 117,
//            'arabic' => 'مستشفى الوفاء ',
//            'turkey' => 'VEFA HASTANASI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 118,
//            'arabic' => 'جحر الديك',
//            'turkey' => 'CUHR ELDİK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 119,
//            'arabic' => 'أبراج تيكا',
//            'turkey' => 'ABRAJ TİKA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 120,
//            'arabic' => 'عزبة أبو عيسى ',
//            'turkey' => 'İZBE ABU İSA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 121,
//            'arabic' => 'شارع المدرسة',
//            'turkey' => 'LİSE SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 122,
//            'arabic' => 'بلوك 1',
//            'turkey' => 'BLUK 1',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 123,
//            'arabic' => 'بلوك 10',
//            'turkey' => 'BLUK 10',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 124,
//            'arabic' => 'بلوك 11',
//            'turkey' => 'BLUK 11',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 125,
//            'arabic' => 'بلوك 12',
//            'turkey' => 'BLUK 12',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 126,
//            'arabic' => 'بلوك 2',
//            'turkey' => 'BLUK 2',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 127,
//            'arabic' => 'بلوك 3',
//            'turkey' => 'BLUK 3',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 128,
//            'arabic' => 'بلوك 4',
//            'turkey' => 'BLUK 4',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 129,
//            'arabic' => 'بلوك 5',
//            'turkey' => 'BLUK 5',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 130,
//            'arabic' => 'بلوك 6',
//            'turkey' => 'BLUK 6',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 131,
//            'arabic' => 'بلوك 7',
//            'turkey' => 'BLUK 7',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 132,
//            'arabic' => 'بلوك 8',
//            'turkey' => 'BLUK 8',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 133,
//            'arabic' => 'بلوك 9',
//            'turkey' => 'BLUK 9',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 134,
//            'arabic' => 'بلوك c',
//            'turkey' => 'BLUK C',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 135,
//            'arabic' => 'مقبولة',
//            'turkey' => 'MAKBULE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 136,
//            'arabic' => 'تل أخضر',
//            'turkey' => 'TEL AHDAER',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 137,
//            'arabic' => 'زهراء',
//            'turkey' => 'ZAHRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 138,
//            'arabic' => 'مستشفى الوفاء ',
//            'turkey' => 'VEFA HASTANASI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 139,
//            'arabic' => 'مخيم جديد',
//            'turkey' => 'YENİ MUHAYEM',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 140,
//            'arabic' => 'ابراج النصيرات',
//            'turkey' => 'NÜSEYRET SİTESİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 141,
//            'arabic' => 'سوق',
//            'turkey' => 'SÜG',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 142,
//            'arabic' => 'شارع الداخلية',
//            'turkey' => 'DAHLİYE YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 143,
//            'arabic' => 'شارع يافا',
//            'turkey' => 'YAFA YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 144,
//            'arabic' => 'صيدلية الزهور',
//            'turkey' => 'ZÖHÜR SAYDALİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 145,
//            'arabic' => 'مسجد الدعوة',
//            'turkey' => 'DAVA MESCİDİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 146,
//            'arabic' => 'مدخل',
//            'turkey' => 'MEDHAL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 147,
//            'arabic' => 'دوار ابو صرار',
//            'turkey' => 'DİVAR ABUSARAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 148,
//            'arabic' => 'مشروع الحساينة',
//            'turkey' => 'MAŞRU ALHASAYNA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 149,
//            'arabic' => 'مخيم 1',
//            'turkey' => 'MUHAYAM 1',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 150,
//            'arabic' => 'مخيم 2',
//            'turkey' => 'MUHAYAM 2',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 151,
//            'arabic' => 'مخيم 3',
//            'turkey' => 'MUHAYAM 3',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 152,
//            'arabic' => 'مخيم 4',
//            'turkey' => 'MUHAYAM 4',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 153,
//            'arabic' => 'مخيم 5',
//            'turkey' => 'MUHAYAM 5',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 154,
//            'arabic' => 'مسجد الفاروق',
//            'turkey' => 'ALFARUK CAMİİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 155,
//            'arabic' => 'خوالدة الشرقية',
//            'turkey' => 'HAVALDE ŞERGİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 156,
//            'arabic' => 'بئر ابو صلاح',
//            'turkey' => 'BIR ABU SALAH ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 157,
//            'arabic' => 'جمعية الصلاح',
//            'turkey' => 'CEMİYET SALAH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 158,
//            'arabic' => 'شارع ابو ستة',
//            'turkey' => 'ABU SITA YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 159,
//            'arabic' => 'شارع الاقصى',
//            'turkey' => 'AKSA YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 160,
//            'arabic' => 'خوالدة',
//            'turkey' => 'HAVELDE ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 161,
//            'arabic' => 'سوارحة غربية',
//            'turkey' => 'SEVERHE GARBİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 162,
//            'arabic' => 'سوارحة شرقية',
//            'turkey' => 'SEVERHE ŞARKİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 163,
//            'arabic' => 'تعابين',
//            'turkey' => 'TAABİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 164,
//            'arabic' => 'سوارحة',
//            'turkey' => 'SEVARHA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 165,
//            'arabic' => 'دوار ابو سيدو',
//            'turkey' => 'DEVAR ABU SİDO ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 166,
//            'arabic' => 'شارع الترنس',
//            'turkey' => 'TIRANS YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 167,
//            'arabic' => 'مربع ابو هريرة',
//            'turkey' => 'MÜREBA ABU HÜREYRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 168,
//            'arabic' => 'مفترق الشهداء',
//            'turkey' => 'MÜGTERF ŞÜHADA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 169,
//            'arabic' => 'وادي غزة',
//            'turkey' => 'VADI GAZZE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 170,
//            'arabic' => 'شارع البرميل',
//            'turkey' => 'ALBARAMİL SOK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 171,
//            'arabic' => 'اقصى',
//            'turkey' => 'AKSA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 172,
//            'arabic' => 'مزرعة',
//            'turkey' => 'MEZREHA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 173,
//            'arabic' => 'مشاعلة',
//            'turkey' => 'MAŞALAH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 174,
//            'arabic' => 'حاجز ابو هولي',
//            'turkey' => 'HACİZ ABU HÜLEY',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 175,
//            'arabic' => 'حي بشارة',
//            'turkey' => 'HEY BİŞARA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 176,
//            'arabic' => 'شارع ابو عريف',
//            'turkey' => 'ABU ERİF YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 177,
//            'arabic' => 'شارع الثانوية',
//            'turkey' => 'SENEVİYE YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 178,
//            'arabic' => ' الدير',
//            'turkey' => 'ŞARG ELDİR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 179,
//            'arabic' => 'وادي السلقا',
//            'turkey' => 'VEDİ SELGE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 180,
//            'arabic' => 'ابراج الكلية',
//            'turkey' => 'ABRAJ KÜLLİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 181,
//            'arabic' => 'البروك',
//            'turkey' => 'AL BRÜK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 182,
//            'arabic' => 'البصة',
//            'turkey' => 'ALBASSA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 183,
//            'arabic' => 'بركة',
//            'turkey' => 'BIRKA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 184,
//            'arabic' => 'محطة',
//            'turkey' => 'MAHATA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 185,
//            'arabic' => 'حدبة',
//            'turkey' => 'HADABA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 186,
//            'arabic' => 'حكر الجامع',
//            'turkey' => 'HİKIR ELCAMİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 187,
//            'arabic' => 'ام ضهير',
//            'turkey' => 'OM DIHİR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 188,
//            'arabic' => 'كلية تقنية',
//            'turkey' => 'KÜLLİYE TEK.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 189,
//            'arabic' => 'بركة الوز',
//            'turkey' => 'ALVİZ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 190,
//            'arabic' => 'عيادة الوكالة',
//            'turkey' => 'VEKALA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 191,
//            'arabic' => 'المستوصف الحكومي',
//            'turkey' => 'MUSTAFSEF HÜKÜMİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 192,
//            'arabic' => 'حارة البطنية',
//            'turkey' => 'HARET BATNİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 193,
//            'arabic' => 'حي الزعفران',
//            'turkey' => 'HEY ZAFARAN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 194,
//            'arabic' => 'دوار الصلاحات',
//            'turkey' => 'DEVAR SALAHAT',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 195,
//            'arabic' => 'شرق المغازي',
//            'turkey' => 'ŞERG MAĞAZİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 196,
//            'arabic' => 'بلوك b',
//            'turkey' => 'BLUK B',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 197,
//            'arabic' => 'بلوك d',
//            'turkey' => 'BLUK D',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 198,
//            'arabic' => 'دوار صدقي',
//            'turkey' => 'DEVER SIDKI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 199,
//            'arabic' => 'المدخل الجديد',
//            'turkey' => 'YENİ MEDHAL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 200,
//            'arabic' => 'الطريق الجديدة',
//            'turkey' => 'YENİ YOL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 201,
//            'arabic' => 'حاوز المياه',
//            'turkey' => 'HAVUZ MEYA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 202,
//            'arabic' => 'مقبرة',
//            'turkey' => 'MAKBARA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 203,
//            'arabic' => 'خزاعة',
//            'turkey' => 'KHUZA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 204,
//            'arabic' => 'الخرابة',
//            'turkey' => 'HARABA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 205,
//            'arabic' => 'محافظة',
//            'turkey' => 'MOHAFAZA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 206,
//            'arabic' => 'جامعة فلسطين',
//            'turkey' => 'FİLİSTİN ÜN.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 207,
//            'arabic' => 'حارة المصريين',
//            'turkey' => 'HARET MASRİYİN ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 208,
//            'arabic' => 'مستشفى دار السلام',
//            'turkey' => 'MÜSTAŞFA DARÜSELEM ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 209,
//            'arabic' => 'عبسان الجديدة',
//            'turkey' => 'ABASAN CEDİDE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 210,
//            'arabic' => 'عبسان الكبيرة',
//            'turkey' => 'ABASAN KABİRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 211,
//            'arabic' => 'عبسان الصغيرة',
//            'turkey' => 'ABASAN ZAĞİRA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 212,
//            'arabic' => 'فخاري',
//            'turkey' => 'FUHARİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 213,
//            'arabic' => 'قرارة',
//            'turkey' => 'GARARA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 214,
//            'arabic' => 'سطر شرقي',
//            'turkey' => 'SATAR ŞARKİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 215,
//            'arabic' => 'شيخ ناصر',
//            'turkey' => 'ŞEYH NASIR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 216,
//            'arabic' => 'تحلية',
//            'turkey' => 'TAHLİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 217,
//            'arabic' => 'اوروبي',
//            'turkey' => 'AVRUBİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 218,
//            'arabic' => 'بني سهيلا',
//            'turkey' => 'BENİ SÜHAYİLE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 219,
//            'arabic' => 'حي المنارة',
//            'turkey' => 'HAY ALMANARA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 220,
//            'arabic' => 'قاع القرين',
//            'turkey' => 'KAALKURİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 221,
//            'arabic' => 'معن',
//            'turkey' => 'MA\'AN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 222,
//            'arabic' => 'جورة اللوت',
//            'turkey' => 'CÜRT ELUT',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 223,
//            'arabic' => 'ارميضة',
//            'turkey' => 'İRMEYDE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 224,
//            'arabic' => 'منارة',
//            'turkey' => 'MENERA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 225,
//            'arabic' => 'مدينة حمد',
//            'turkey' => 'HAMAD ŞEHİRİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 226,
//            'arabic' => 'حي هولندي',
//            'turkey' => 'HAY HOLANDİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 227,
//            'arabic' => 'حي اماراتي',
//            'turkey' => 'HAY İMARATİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 228,
//            'arabic' => 'حي نمساوي',
//            'turkey' => 'HAY NİMSAVİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 229,
//            'arabic' => 'حي ياباني',
//            'turkey' => 'HAY YABANİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 230,
//            'arabic' => 'المشروع',
//            'turkey' => 'ALMAŞRU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 231,
//            'arabic' => 'مواصي ',
//            'turkey' => 'MEVASI',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 232,
//            'arabic' => 'معسكر غربي',
//            'turkey' => 'MUASKAR ĞARBİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 233,
//            'arabic' => 'سطر غربي',
//            'turkey' => 'SATIR GARBİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 234,
//            'arabic' => 'حي العرايشية',
//            'turkey' => 'HAY ALARAYŞİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 235,
//            'arabic' => 'أبراج قطر',
//            'turkey' => 'ABRAJ KATAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 236,
//            'arabic' => 'حي الامل',
//            'turkey' => 'HAY ELAMAL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 237,
//            'arabic' => 'مشروع اماراتي',
//            'turkey' => 'MAŞRU EMERETİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 238,
//            'arabic' => 'البطن السمين',
//            'turkey' => 'BATIN SAMİN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 239,
//            'arabic' => 'حارة البيوك',
//            'turkey' => 'HARET BEYÜK',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 240,
//            'arabic' => 'حارة المجايدة',
//            'turkey' => 'HARET MECEYDE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 241,
//            'arabic' => 'دوار ابو حميد',
//            'turkey' => 'DEVAR ABU HEMIT',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 242,
//            'arabic' => 'شارع جلال',
//            'turkey' => 'CELAL YOLU',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 243,
//            'arabic' => 'شارع جمال عبد الناصر',
//            'turkey' => 'CEMEL ABDÜLNASIR CAD',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 244,
//            'arabic' => 'طريق رفح الغربية',
//            'turkey' => 'TARİG REFAH GAR.',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 245,
//            'arabic' => 'قيزان النجار',
//            'turkey' => 'GİZAN NAJAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 246,
//            'arabic' => 'كتيبة',
//            'turkey' => 'KATİPE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 247,
//            'arabic' => 'كراج رفح',
//            'turkey' => 'KERAJ REFAH',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 248,
//            'arabic' => 'قيزان ابو رشوان',
//            'turkey' => 'KİZAN ABU RAŞVAN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 249,
//            'arabic' => 'مطار',
//            'turkey' => 'MATAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 250,
//            'arabic' => 'معبر',
//            'turkey' => 'MABER',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 251,
//            'arabic' => 'شوكة',
//            'turkey' => 'ŞÜKA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 252,
//            'arabic' => 'حي النصر',
//            'turkey' => 'HAY ALNASIR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 253,
//            'arabic' => 'حي السلام',
//            'turkey' => 'HAY ALSALAM',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 254,
//            'arabic' => 'خربة العدس',
//            'turkey' => 'HİRBET ALADAS',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 255,
//            'arabic' => 'ميراج ',
//            'turkey' => 'MİRAJ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 256,
//            'arabic' => 'شوكة شمالية',
//            'turkey' => 'KUZEY ŞÜKE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 257,
//            'arabic' => 'شوكة الوسطى',
//            'turkey' => 'ORTA ŞÜKE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 258,
//            'arabic' => 'حي الجنينة',
//            'turkey' => 'HAY CENİYNE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 259,
//            'arabic' => 'حي البراهمة',
//            'turkey' => 'HEY BEREHME',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 260,
//            'arabic' => 'حي كندا',
//            'turkey' => 'HEY KANADA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 261,
//            'arabic' => 'بحر',
//            'turkey' => 'BAHAR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 262,
//            'arabic' => 'حي سعودي',
//            'turkey' => 'LHAY SUADİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 263,
//            'arabic' => 'دوار زعرب',
//            'turkey' => 'DİVAR ZURUP',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 264,
//            'arabic' => 'حي شعوت',
//            'turkey' => 'HAY ŞÜAT',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 265,
//            'arabic' => 'مخيم بدر',
//            'turkey' => 'MUHAYAM BADIR',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 266,
//            'arabic' => 'قرية سويدية',
//            'turkey' => 'KARYA SEVİDİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 267,
//            'arabic' => 'تل السلطان',
//            'turkey' => 'TEL SULTAN',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 268,
//            'arabic' => 'ميراج الغربية',
//            'turkey' => 'MIRAJ GARBİYE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 269,
//            'arabic' => 'مشروع سعودي',
//            'turkey' => 'MAŞRU SUADİ',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 270,
//            'arabic' => 'دوار العودة',
//            'turkey' => 'DEVAR AVDE',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 271,
//            'arabic' => 'دوار النجمة',
//            'turkey' => 'DEVAR NİJMA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 272,
//            'arabic' => 'مخيم بربرة',
//            'turkey' => 'MUHEYİM BERBERA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 273,
//            'arabic' => 'شابورة',
//            'turkey' => 'ŞABURA',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 274,
//            'arabic' => 'حي البرازيل',
//            'turkey' => 'HAY ALBARAZİL',
//
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 275,
//            'arabic' => 'عريبة',
//            'turkey' => 'İRİBEH',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 276,
//            'arabic' => 'منطقة مصبح',
//            'turkey' => 'MSABEH',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 277,
//            'arabic' => 'يبنا',
//            'turkey' => 'YÜBNE',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 278,
//            'arabic' => 'الشارع العام',
//            'turkey' => 'ANA CAD',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 279,
//            'arabic' => 'خلف البلدية',
//            'turkey' => 'BELEDİYE ARKASI',
//            'city_id' => null,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 280,
//            'arabic' => 'موقف',
//            'turkey' => 'MAVGIF',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 281,
//            'arabic' => 'البلد',
//            'turkey' => 'ALBALAD',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 282,
//            'arabic' => 'معسكر',
//            'turkey' => 'MUASKAR',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 283,
//            'arabic' => 'جمارك',
//            'turkey' => 'CEMERİK',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 284,
//            'arabic' => 'ايرز',
//            'turkey' => 'EİRİZ',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 285,
//            'arabic' => 'شارع صلاح الدين',
//            'turkey' => 'SALAHEDDİN CAD.',
//            'city_id' => NULL,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 286,
//            'arabic' => ' المخابرات',
//            'turkey' => 'MUHABERET',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 287,
//            'arabic' => ' رفح الغربية',
//            'turkey' => ' REFAH GAR.',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 288,
//            'arabic' => ' القرية الأولى',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 289,
//            'arabic' => ' بيت حانون',
//            'turkey' => 'BEYT HANUN ',
//
//        ]);
//
//        \App\NameTranslation::create([
//
//            'arabic' => ' الشوكة الجنوبية',
//            'turkey' => '',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 291,
//            'arabic' => ' القرية البدوية',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 292,
//            'arabic' => 'العريبة',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 293,
//            'arabic' => 'المغراقة',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 294,
//            'arabic' => 'الزوايدة',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 295,
//            'arabic' => 'الشرقية',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 296,
//            'arabic' => 'رفح',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 297,
//            'arabic' => 'العامودي',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 298,
//            'arabic' => 'النصيرات',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 299,
//            'arabic' => 'خانيونس',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 300,
//            'arabic' => 'السنتيشن',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 301,
//            'arabic' => 'اللبابيدي',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 302,
//            'arabic' => 'برج 22',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 303,
//            'arabic' => 'الطريق العام ',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 304,
//            'arabic' => 'صوفا ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 305,
//            'arabic' => 'البريج ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 306,
//            'arabic' => 'القلعة ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 307,
//            'arabic' => 'المصدر ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 308,
//            'arabic' => 'الشمال ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 309,
//            'arabic' => 'الهوجا ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 310,
//            'arabic' => 'غزة ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 311,
//            'arabic' => 'مدخل القرية  ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 312,
//            'arabic' => ' عيادة الوكالة',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 313,
//            'arabic' => ' برج 16',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 314,
//            'arabic' => ' برج 21',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 315,
//            'arabic' => ' برج 23',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 316,
//            'arabic' => 'بلوك g ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 317,
//            'arabic' => 'بلوك k ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 318,
//            'arabic' => 'شارع النادي',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 319,
//            'arabic' => 'شارع قطر',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 320,
//            'arabic' => 'فندق الأمل',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 321,
//            'arabic' => 'برج 11',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 322,
//            'arabic' => 'برج 12',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 323,
//            'arabic' => 'برج 14',
//            'turkey' => ' ',
//            'city_id' => null,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 324,
//            'arabic' => 'حى الصلاح',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 325,
//            'arabic' => 'حى ابو عبيدة',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 326,
//            'arabic' => 'برج 6',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 327,
//            'arabic' => 'برج 34',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 328,
//            'arabic' => 'برج 25',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 329,
//            'arabic' => 'الأبراج',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 330,
//            'arabic' => 'الزنة',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 331,
//            'arabic' => 'الفاخورة',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 332,
//            'arabic' => 'القصاصيب',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 333,
//            'arabic' => ' الامن العام',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 334,
//            'arabic' => ' ',
//            'turkey' => 'الاتصالات ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 335,
//            'arabic' => ' الترخيص القديم',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 336,
//            'arabic' => 'الجامع الكبير',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 337,
//            'arabic' => 'العبور ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 338,
//            'arabic' => ' العلمي',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 339,
//            'arabic' => 'المدرسة الزراعية ',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 340,
//            'arabic' => 'المدرسة الأمريكية',
//            'turkey' => ' ',
//
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 341,
//            'arabic' => ' الغربية',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 342,
//            'arabic' => ' المزلقان',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 343,
//            'arabic' => 'المشاهرة',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 344,
//            'arabic' => 'المشتل',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 345,
//            'arabic' => 'عبسان',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 346,
//            'arabic' => 'صلاح الدين',
//            'turkey' => ' ',
//            'city_id' => null,
//        ]);
//
//        \App\NameTranslation::create([
//            'id' => 347,
//            'arabic' => 'شارع الجمارك',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 348,
//            'arabic' => 'شارع ابو عوده',
//            'turkey' => ' ',
//
//        ]);
//        \App\NameTranslation::create([
//            'id' => 349,
//            'arabic' => 'جباليا',
//            'turkey' => ' ',
//
//        ]);

    }
}
