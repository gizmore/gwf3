<?php
$lang = array (
	# Sayfa Başlıkları
	'pt_list' => 'Download Bölümü',
	'mt_list' => 'Download Bölümü, Downloads, Exclusive downloads,'. GWF_SITENAME,
	'md_list' => GWF_SITENAME.'üzerinde özel yüklemeler.',
	
	# Sayfa Bilgisi
	'pi_add' => 'en iyi kullanıcı deneyimi için öncelikle dosya upload, o oturum içine saklanan alırsınız. Daha sonra seçenekleri değiştirmez. Maksimum yükleme boyutu <br/>%1$s olarak ayarlanır.',
	
	# Formu Başlıklar
	'ft_add' => 'bir dosya Yükleme',
	'ft_edit' => 'Düzenle İndir',
	'ft_token' => 'İndirme simge girin',
	
	# Hataları
	'err_file' => 'Bir dosya yüklemek gerekiyor.',
	'err_filename' => 'Kişisel belirtilen dosya geçersiz. Max uzunluk %1$s dir. temel ascii karakter kullanmaya çalışın.',
	'err_level' => 'kullanıcı seviyesi> = 0 olmalıdır.',
	'err_descr' => 'açıklamasına olmak zorundadır %s-%s karakter uzunluğunda olmalıdır.',
	'err_price' => 'fiyat arasında ve %s - %s olmalıdır.',
	'err_dlid' => 'download bulunamadı.',
	'err_token' => 'download token geçersiz senin.',
	
	# Mesajlar
	'prompt_download' => 'basın OK dosyasını indirmek için',
	'msg_uploaded' => 'Dosyanız başarıyla yüklendi var.',
	'msg_edited' => 'download düzenlenmiş başarılı olmuştur.',
	'msg_deleted' => 'Dosya başarıyla silindi.',
	
	# Tablo Başlıkları
	'th_dl_filename' => 'Dosya',
	'th_file' => 'Dosya',
	'th_dl_id' => 'ID',
	'th_dl_gid' => 'Gerekli Grubu',
	'th_dl_level' => 'Gerekli Level',
	'th_dl_descr' => 'Açıklama',
	'th_dl_price' => 'Fiyat',
	'th_dl_count' => 'Dosyalar',
	'th_dl_size' => 'Dosya büyüklüğü',
	'th_user_name' => 'Yükleme',
	'th_adult' => 'Yetişkin içerik?',
	'th_huname' => 'gizle adı?',
	'th_vs_avg' => 'Oy ver',
	'th_dl_expires' => 'Ishal dışarı',
	'th_dl_expiretime' => 'Download geçerli %1$s için mi',
	'th_paid_download' =>' Bir ödeme bu dosyayı indirmek için gerekli',
	'th_token' => 'İndir Simgesi',
	
	# Düğmeler
	'btn_add' => 'Ekle',
	'btn_edit' => 'Düzenle',
	'btn_delete' => 'Sil',
	'btn_upload' => 'Yükle',
	'btn_download' => 'İndir',
	'btn_remove' => 'Kaldır',
	
	# Admin config
	'cfg_anon_downld' => 'İzin ortalama indirme',
	'cfg_anon_upload' => 'İzin konuk yüklenenler',
	'cfg_user_upload' => 'İzin kullanıcı yüklenenler',
	'cfg_dl_gvotes' => 'İzin ortalama oy',
	'cfg_dl_gcaptcha' => 'Konuk yükle kaptan',
	'cfg_dl_descr_max' => 'Max. tanım uzunluğu',
	'cfg_dl_descr_min' => 'Min. tanım uzunluğu',
	'cfg_dl_ipp' => 'sayfa başına Öğeler',
	'cfg_dl_maxvote' => 'Max. votescore',
	'cfg_dl_minvote' => 'Min. votescore',
	
	# Sipariş
	'order_title' => 'İndir %1$s (Simgesi: %2$s için token)', 
	'order_descr' => '%1$s işareti download satın aldı. Geçerli %2$s için. Simgesi: %3$s',
	'msg_purchased' => 'Ödemeniz alındı ve bir indirme token eklenmiştir. Your token<br/>\'%1$s\' ve %2$s için geçerlidir.<br/><b>Yaz olduğu sen at '.GWF_SITENAME.'</b><br/>sadece <a href="%3$s">hiçbir hesabınız varsa aşağıya simge</a> bu linki izleyin.',
	
	# V2.01 (+ col)
	'th_purchases' => 'Alımlar',
	
	# V2.02 Geçerlilik + finsih
	'err_dl_expire' => 'süresi sona 0 saniye ile 5 yıl arasında olması gerekir.',
	'th_dl_expire' => 'İndir sonra sona eriyor',
	'tt_dl_expire' => 'Süresi ifadesi. 5 saniye veya 1 ay 3 gün gibi.',
	'th_dl_guest_view' => 'Konuk görebilir?',
	'tt_dl_guest_view' => 'Mayıs konuk Bu karşıdan görüyor musun?',
	'th_dl_guest_down' => 'Konuk yüklenebilir?',
	'tt_dl_guest_down' => 'Mayıs misafirler bu dosyayı download?',
	'ft_reup' => 'Yeniden yükle Dosya ',
	'order_descr2' => 'im %1$s download için satın aldı. Simgesi: %2$s.',
	'msg_purchased2' => 'Ödemeniz alındı ve bir indirme token eklenmiştir. Your token <br/>%1$s<br/><b>Yaz token aşağı hiçbir hesabınız varsa '.GWF_SITENAME.'!</b><br/>deki Else sadece <a href="%2$s">bu linki</a>izleyin.',
	'err_group' => 'Siz olması gerekiyor grubunun bu dosyayı indirmek için.',
	'err_level' => 'Siz bu dosyayı indirmek için %s of userlevel ihtiyacım var.',
	'err_guest' => 'Misafirler bu dosyayı indirmek için izniniz yok.',
	'err_adult' => 'Bu yetişkin içerik.',

	'th_dl_date' => 'Date',

	# GWF3v1.1
	'cfg_dl_min_level' => 'Minimum userlevel for an upload',
	'cfg_dl_moderated' => 'Require moderators to unlock uploads?',
	'cfg_dl_moderators' => 'Usergroup for upload moderators.',
	'th_enabled' => 'Enabled?',
	'err_disabled' => 'This download isn\'t enabled yet.',
	'msg_enabled' => 'The download has been enabled.',
	'msg_uploaded_mod' => 'Your file has been uploaded successfully, but has to be reviewed before it is released.',

	'mod_mail_subj' => GWF_SITENAME.': Upload Moderation',
	'mod_mail_body' =>
		'Dear %1$s'.PHP_EOL.
		PHP_EOL.
		'There has been a new file uploaded to '.GWF_SITENAME.' which requires moderation.'.PHP_EOL.
		PHP_EOL.
		'From: %2$s'.PHP_EOL.
		'File: %3$s (%4$s)'.PHP_EOL.
		'Mime: %5$s'.PHP_EOL.
		'Size: %6$s'.PHP_EOL.
		'Desc: %7$s'.PHP_EOL.
		PHP_EOL.
		'You can download the file here:'.PHP_EOL.
		'%8$s'.PHP_EOL.
		PHP_EOL.
		'You can allow the download here:'.PHP_EOL.
		'%9$s'.PHP_EOL.
		PHP_EOL.
		'You can delete the download here:'.PHP_EOL.
		'%10$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' script!',
);
?>