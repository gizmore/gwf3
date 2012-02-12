<?php
final class Forum_GetAttach extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^forum/attachment/(\d+)$ index.php?mo=Forum&me=GetAttach&aid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($attach = GWF_ForumAttachment::getByID(Common::getGet('aid')))) {
			return $this->module->error('err_attach');
		}
		
		if (false === ($post = $attach->getPost())) {
			return $this->module->error('err_post');
		}
		
		$user = GWF_Session::getUser();
		
		if (!$post->hasViewPermission($user)) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}

		if (!$attach->canDownload($user)) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		return $this->templateAttach($attach, $post, $user);
	}
	
	private function templateAttach(GWF_ForumAttachment $attach, GWF_ForumPost $post, $user)
	{
		$path = $attach->dbimgPath();
		$mime = $attach->getVar('fatt_mime');
		$as_attach = !$attach->isImage();
		$filename = $as_attach ? $attach->getVar('fatt_filename') : true;
		if ($as_attach) {
			$attach->increase('fatt_downloads', 1);
		}
		GWF_Upload::outputFile($path, $as_attach, $mime, $filename);
		die();
	}
}
?>