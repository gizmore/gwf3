<?php
$lang = array (
	'ERR_DATABASE' => 'Dosyası %s satır Veritabanı hatası %s.',
	'ERR_FILE_NOT_FOUND' => 'Dosya bulunamadı: %s',
	'ERR_MODULE_DISABLED' => 'modülü %s şu anda devre dışıdır.',
	'ERR_LOGIN_REQUIRED' => 'Bu işlev için sen oturum olması yeterlidir',
	'ERR_NO_PERMISSION' => 'Erişim engellendi.',
	'ERR_WRONG_CAPTCHA' => 'You tip Resimdeki harfleri doğru var.',
	'ERR_MODULE_MISSING' => 'Modül %s saptanmıştır olamazdı.',
	'ERR_COOKIES_REQUIRED' => 'Oturumunuz zaman aşımına uğradı ya da tarayıcınızın çerezleri etkinleştirmeniz gerekir. <br/> Lütfen sayfayı yenilemek için çalışıyoruz.',
	'ERR_UNKNOWN_USER' => 'Kullanıcı bilinmemektedir.',
	'ERR_UNKNOWN_GROUP' => 'Grup bilinmemektedir.',
	'ERR_UNKNOWN_COUNTRY' => 'Ülke bilinmemektedir.',
	'ERR_UNKNOWN_LANGUAGE' => 'Bu dil bilinmemektedir.',
	'ERR_METHOD_MISSING' => 'Bilinmeyen Yöntem: %s Modül %s.',
	'ERR_GENERAL' => '%s Bilinmeyen hata. Hat %s',
	'ERR_WRITE_FILE' => 'dosyası yazılamıyor: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Bilinmiyor Sınıf: %s.',
	'ERR_MISSING_VAR' => 'Eksik HTTP POST var: %s.',
	'ERR_MISSING_UPLOAD' => 'Bir dosya yüklemek gerekiyor.', #Bir e-posta gönderirken  ????
	'ERR_MAIL_SENT' => 'bir hata oluştu.',
	'ERR_CSRF' => 'Sayfanızın kod geçersiz. Belki veya oturum sonrası çift çalıştım çıkış süresi ise bitti.',
	'ERR_HOOK' => 'Çengel yanlış döndü: %s.',
	'ERR_PARAMETER' => '%s çizgi %s geçersiz argüman. Fonksiyon argüman %s geçersiz.',
	'ERR_DEPENDENCY' => 'Çözümlenmemiş Bağımlılık: Modülü %s, yöntem %s depends on Modülü %s Version %s.',
	'ERR_SEARCH_TERM' => 'Arama Terimi %s - %s karakter uzunluğunda olmalıdır.',
	'ERR_SEARCH_NO_MATCH' => 'Arama %s bir eşleşme bulamadık.',
	'ERR_POST_VAR' => 'Beklenmeyen POST var: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',
	
	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',
	
	'm1' => 'Ocak',
	'm2' => 'Şubat',
	'm3' => 'Mart',
	'm4' => 'Nisan',
	'm5' => 'Mayıs',
	'm6' => 'Haziran',
	'm7' => 'Temmuz',
	'm8' => 'Ağustos',
	'm9' => 'Eylül',
	'm10' => 'Ekim',
	'm11' => 'Kasım',
	'm12' => 'Aralık',
	
	'M1' => 'Ocak',
	'M2' => 'Şubat',
	'M3' => 'Mart',
	'M4' => 'Nisan',
	'M5' => 'Mayıs',
	'M6' => 'Haziran',
	'M7' => 'Temmuz',
	'M8' => 'Ağustos',
	'M9' => 'Eylül',
	'M10' => 'Ekim',
	'M11' => 'Kasım',
	'M12' => 'Aralık',
	
	'D0' => 'Pazar',
	'D1' => 'Pazartesi',
	'D2' => 'Salı',
	'D3' => 'Çarşamba',
	'D4' => 'Perşembe',
	'D5' => 'Cuma',
	'D6' => 'Cumartesi',
	
	'd0' => 'Sun',
	'd1' => 'Pzt',
	'd2' => 'Sal',
	'd3' => 'Çar',
	'd4' => 'Per',
	'd5' => 'Cum',
	'd6' => 'Sat',
	
	'ago_s'=> '%s saniye önce',
	'ago_m' => '%s dakika önce',
	'ago_h' => '%s saat önce',
	'ago_d' => '%s gün önce',
	
	# # #
	# # # TODO: GWF_DateFormat, sorunlu, çünkü tr! = Tr [tr / gb]
	# # #
	# # # Burada nasıl bir varsayılan dateformats farklı dil arar belirtmelisiniz.
	# # Aşağıdaki yedek var #
	# # # Yıl: Y = 1.990, y = 90
	# # # Ay: m = 01, n = 1, M = Ocak, N = Jan
	# # # Gün: d = 01, j = 1, l = Salı, D = Sal
	# # # Saat: H: 23 h = 11
	# # # Dakika: i: 59
	# # # İkinci: s: 59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # January 2009
	'df8' => 'D, M j, Y', # Tue, January 9, 2009
	'df10' => 'M d, Y - H:00', # January 09, 2009 - 23:00
	'df12' => 'M d, Y - H:i',  # January 09, 2009 - 23:59
	'df14' => 'M d, Y - H:i:s',# January 09, 2009 - 23:59:59
	
	'datecache' => array(
	array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'),
	array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'),
	array('Sun','Pzt','Sal','Çar','Per','Cum','Sat'),
	array('Pazar','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi'),
	array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),
	
	# GWF_Form
	'th_captcha1' => '<a href="http://tr.wikipedia.org/wiki/Captcha">Captcha</a>', # <br/> Resmin 'yeniden yüklemek,
	'th_captcha2' => 'Bana gelen 5 harf Captcha Image',
	'tt_password' => 'Şifreler en az 8 karakter uzunluğunda olmalıdır.',
	'tt_captcha1' => 'tıklayın captcha Image yenisini istemek için.',
	'tt_captcha2' => 'yeniden yazın görüntü ispat için bir insansınız.',
	
	# GWF_Category
	'no_category' => 'Tüm Kategoriler',
	'sel_category' => 'Kategori Seçin',
	
	# GWF_Language
	'sel_language' => 'Bir Dil Seçin',
	'unknown_lang' => 'Bilinmeyen dil',
	
	# GWF_Country
	'sel_country' => 'Bir Ülke',
	'unknown_country' => 'Bilinmeyen Ülke',
	'alt_flag' => '%s ',
	
	# GWF_User # cinsiyet
	'gender_male' => 'erkek',
	'gender_female' => 'Kadın',
	'gender_no_gender' => 'Bilinmiyor Cinsiyet',
	
	# GWF_User # avatar
	'alt_avatar' => '%s`s Avatar',
	
	# GWF_Group
	'sel_group' => 'Bir kullanıcı grubuna',
	
	# Tarih seçmek
	'sel_year' => 'Seç Yıl',
	'sel_month' => 'Select Ay',
	'sel_day' => 'Seç Day',
	'sel_older' => 'En eski',
	'sel_younger' => 'genç den',
	
	# # # Genel Bits! # # #
	'guest' => 'Misafir',
	'unknown' => 'Bilinmiyor',
	'never' => 'Asla',
	'search' => 'Arama',
	'term' => 'Dönem',
	'by' => 'Tarafından',
	'and' => 've',
	
	'alt_flag' => '%s Bayrağı',
	
	# V2.01 (copyright)
	'copy' => '©%s '.GWF_SITENAME.'. Tüm hakları saklıdır.',
	'copygwf' => GWF_SITENAME. ' <a href="http://gwf.gizmore.org"> GWF </ a> kullanıyorsa, BSD-Web Framework gibi.',
	
	# V2.02 (Tuttum + required_fields)
	'form_required' => '%s gereklidir anlamına gelir.',
	
	# V2.03 BBCode
	'bbhelp_b' => 'bold',
	'bbhelp_i' => 'italik',
	'bbhelp_u' => ', altı çizili',
	'bbhelp_code' => 'Kod buraya',
	'bbhelp_quote' => 'Metin burada bir teklif',
	'bbhelp_url' => 'Bağlantı metin',
	'bbhelp_email' => 'e-posta bağlantısı için Metin',
	'bbhelp_noparse' => 'sakatlar bb-burada kod çözme.',
	'bbhelp_level' => 'Metin görüntülenebilir olması için minimum userlevel ihtiyacı.',
	'bbhelp_spoiler' => 'Bir tıklama ile gösterilir Görünmez metin.',
	
	# V2.04 BBCode3
	'quote_from' => '%s alıntı',
	'code' => 'kod',
	'for' => 'için',
	
	# 2.05 Bits
	'yes' => 'Evet',
	'no' => 'Yok',
	
	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',
	
	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);
?>