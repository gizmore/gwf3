<?php
final class GWF_ForumBoardSelect
{
	public static function single($name, $selected='0')
	{
		GWF_ForumBoard::init(true);
		$back = sprintf('<select name="%s">', htmlspecialchars($name));
		self::singleB(GWF_ForumBoard::getRoot(), $back, 0, $selected);
		$back .= '</select>'.PHP_EOL;
		return $back;
	}
	private static function singleB(GWF_ForumBoard $board, &$back, $level, $selected)
	{
		$rep = '+'.str_repeat('=', $level*2);
		$back .= sprintf('<option value="%s"%s>%s</option>', $board->getID(), GWF_HTML::selected($selected===$board->getID()), $rep.$board->display('board_title'));
		$childs = $board->getChilds();
		if (count($childs) > 0)
		{
			foreach ($childs as $child)
			{
				self::singleB($child, $back, $level+1, $selected);
			}
		}
	}
}
?>
