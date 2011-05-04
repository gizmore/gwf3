<?php
$lang = array (
# Sayfa Başlıkları
'pt_list' => 'Download Bölümü',
'mt_list' => 'Download Bölümü, Downloads, Exclusive downloads,'. GWF_SITENAME,
'md_list' => GWF_SITENAME.'üzerinde özel yüklemeler.',

# Sayfa Bilgisi
'pi_add' => 'en iyi kullanıcı deneyimi için öncelikle dosya upload, o oturum içine saklanan alırsınız. Daha sonra seçenekleri değiştirmez. Maksimum yükleme boyutu <br/>%1% olarak ayarlanır.',

# Formu Başlıklar
'ft_add' => 'bir dosya Yükleme',
'ft_edit' => 'Düzenle İndir',
'ft_token' => 'İndirme simge girin',

# Hataları
'err_file' => 'Bir dosya yüklemek gerekiyor.',
'err_filename' => 'Kişisel belirtilen dosya geçersiz. Max uzunluk %1% dir. temel ascii karakter kullanmaya çalışın.',
'err_level' => 'kullanıcı seviyesi> = 0 olmalıdır.',
'err_descr' => 'açıklamasına 0 olmak zorundadır -%% 1 karakter uzunluğunda olmalıdır.',
'err_price' => 'fiyat% arasında% 1 ve% 2% olmalıdır.',
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
'th_dl_expiretime' => 'Download geçerli %1% için mi',
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
'order_title' => 'İndir %1% (Simgesi: %2% için token)', 
'order_descr' => '%1% işareti download satın aldı. Geçerli %2% için. Simgesi: %3%',
'msg_purchased' => 'Ödemeniz alındı ve bir indirme token eklenmiştir. Your token<br/>\'%1%\' ve %2% için geçerlidir.<br/><b>Yaz olduğu sen at '.GWF_SITENAME.'</b><br/>sadece <a href="%3%">hiçbir hesabınız varsa aşağıya simge</a> bu linki izleyin.',

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
'order_descr2' => 'im %1% download için satın aldı. Simgesi: %2%.',
'msg_purchased2' => 'Ödemeniz alındı ve bir indirme token eklenmiştir. Your token <br/>%1%<br/><b>Yaz token aşağı hiçbir hesabınız varsa '.GWF_SITENAME.'!</b><br/>deki Else sadece <a href="%2%">bu linki</a>izleyin.',
'err_group' => 'Siz% 1% olması gerekiyor grubunun bu dosyayı indirmek için.',
'err_level' => 'Siz% 1 bu dosyayı indirmek için% of userlevel ihtiyacım var.',
'err_guest' => 'Misafirler bu dosyayı indirmek için izniniz yok.',
'err_adult' => 'Bu yetişkin içerik.',

	'th_dl_date' => 'Date',
);
?> 