<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Job;
use AIESEC\Portal\DataBundle\Entity\Goal;

class DBValuesGoal
{
	public static $DB_VALUES_GOAL_TYPE = array(
			"ICX/ER",
			"OGX",
			"FIN",
			"TM",
			"COM",
	);
	
	public static $DB_VALUES_GOAL_SUBTYPE = array(
			"TNs Raised",
			"TNs Matched",
			"Company meetings",
			"Company Contacts",
			"EPs Matched",
			"Eps realized",
			"Conversion rate",
			"HJA Grade",
			"JA Grade",
			"Financial result",
			"Member selected",
			"% of PDTs covered",
			"Retention Rate",
			"Member efficiency",
			"Students on information evening",
			"Students converted to applicants",
			"Other",
	);
}