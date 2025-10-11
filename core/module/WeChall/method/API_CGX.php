<?php

/**
 * Ajax API Handler for various data.
 * %wc%x% => <a href="">
 * %wcc%sudoku% <a href="">Sudoku 1
 * %yt%abcdef141% => <a href="youtube.com/saggs">Title of video
 * 
 * @author gizmore
 * @since 17.Feb.
 */
final class API_CGX extends GWF_Method
{
	
	public function execute()
	{
		if ($cgx = Common::getGetString('cgx'))
		{
			$this->cgxChallenge($cgx);
		}
		if ($wcc = Common::getGetString('wcc'))
		{
			$this->wccChallenge($wcc);
		}
	}

	private function cgxChallenge($cgx)
	{
		$challs = WC_Challenge::table('WC_Challenge')->selectAll('chall_id, chall_title', "chall_title LIKE 'CGX%'");
		$this->levenstheinChallenge($challs, $cgx);
	}
	
	private function wccChallenge($wcc)
	{
		$challs = WC_Challenge::table('WC_Challenge')->selectAll('chall_id, chall_title');
		$this->levenstheinChallenge($challs, $cgx);
	}
	
	private function levenstheinChallenge(array $challs, $searchterm)
	{
		$data = array();
		foreach ($challs as $chall)
		{
			$id = $chall->getVar('chall_id');
			$ct = $chall->getVar('chall_title');
			$data[$id] = $ct;
		}
		$this->levenstheinChallengeB($data, $searchterm);
	}
	
	private function levenstheinChallengeB($data, $searchterm)
	{
		$min = PHP_INT_MAX;
		$minID = 0;
		
		foreach ($data as $id => $title)
		{
			$dist = levenshtein($searchterm, $title);
			if ($dist <= $min)
			{
				$min = $dist;
				$minID = $id;
			}
		}
		$this->levenstheinChallengeC($minID);
	}
	
	private function levenstheinChallengeC($id)
	{
		$challenge = WC_Challenge::getByID($id);
		$data = $challenge->getGDOData();
		$response = array(
			'code' => 200,
			'data' => $data,
		);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
		die(0);
	}

}
