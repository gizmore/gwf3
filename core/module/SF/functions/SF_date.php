<?php

final class SF_date extends SF_Function
{
	public function execute()
	{
		return GWF_Time::displayDate(GWF_Time::getDate(14));
	}
}
