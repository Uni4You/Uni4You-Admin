<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Membership;
use AIESEC\Portal\DataBundle\Entity\Job;

class DBValuesMembership
{
	public static $DB_VALUES_MEMBERSHIP_STATUS = array(
			'active' => 'Active',
			'alumni' => 'Alumnus',
	);
	
	public static $DB_VALUES_TEAM_TYPE = array(
			Job::TEAM_TYPE_LOCAL => "Local",
			Job::TEAM_TYPE_NATIONAL => "National",
			Job::TEAM_TYPE_INTERNATIONAL => "International",
	);
	
	public static $DB_VALUES_TEAM_SUBTYPE = array(
			Job::TEAM_SUBTYPE_ER => "ER",
			Job::TEAM_SUBTYPE_TM => "TM",
			Job::TEAM_SUBTYPE_ICX => "ICX",
			Job::TEAM_SUBTYPE_IGCDP => "iGCDP",
			Job::TEAM_SUBTYPE_OGX => "OGX",
			Job::TEAM_SUBTYPE_OGIP => "oGIP",
			Job::TEAM_SUBTYPE_OGCDP => "oGCDP",
			Job::TEAM_SUBTYPE_FIN => "Fin",
			Job::TEAM_SUBTYPE_COM => "Com",
			Job::TEAM_SUBTYPE_REC => "Reception",
			Job::TEAM_SUBTYPE_OC => "OC",
			Job::TEAM_SUBTYPE_NIST => "NIST",
			Job::TEAM_SUBTYPE_NST_ER => "NST ER",
			Job::TEAM_SUBTYPE_NST_TM => "NST TM",
			Job::TEAM_SUBTYPE_NST_ICX => "NST ICX",
			Job::TEAM_SUBTYPE_NST_OGIP => "NST oGIP",
			Job::TEAM_SUBTYPE_NST_OGCDP => "NST oGCDP",
			Job::TEAM_SUBTYPE_NST_FIN => "NST Fin",
			Job::TEAM_SUBTYPE_NST_COM => "NST Com",
			Job::TEAM_SUBTYPE_NST_OD => "NST OD",
			Job::TEAM_SUBTYPE_NST_BD => "NST BD",
			Job::TEAM_SUBTYPE_NTT => "NTT",
			Job::TEAM_SUBTYPE_REGIO_CO => "RegioCo",
			Job::TEAM_SUBTYPE_RLP => "RLP",
			Job::TEAM_SUBTYPE_MC => "MC",
			Job::TEAM_SUBTYPE_OTHER => "Other",
	);
	
	public static $DB_VALUES_LC = array(
			"Aachen",
			"Augsburg",
			"Bamberg",
			"Bayreuth",
			"Berlin HU",
			"Berlin TU",
			"Bielefeld",
			"Bochum",
			"Bonn",
			"Braunschweig",
			"Bremen",
			"Darmstadt",
			"Dortmund",
			"Dresden",
			"Duesseldorf",
			"Essen",
			"Frankfurt",
			"Freiburg",
			"Giessen",
			"Goettingen",
			"Halle",
			"Hamburg",
			"Hannover",
			"Heidelberg",
			"Jena",
			"Kaiserslautern",
			"Karlsruhe",
			"Kiel",
			"Koeln",
			"Leipzig",
			"Lueneburg",
			"Magdeburg",
			"Mainz",
			"Mannheim",
			"MC",
			"Muenchen",
			"Muenster",
			"Nuernberg",
			"Oldenburg",
			"Paderborn",
			"Passau",
			"Regensburg",
			"Rostock",
			"Saarbruecken",
			"Stuttgart",
			"Tuebingen",
			"Ulm",
			"Wuerzburg",
			"Wuppertal",
	);
	
	public static $DB_VALUES_POSITION = array(
			Job::POSITION_MEMBER => "Member",
			Job::POSITION_TEAM_LEADER => "Team Leader",
			Job::POSITION_VICE_PRESIDENT => "Vice President",
			Job::POSITION_PRESIDENT => "President",
	);
	
	public static $DB_VALUES_YOUTH_TALENT_PROGRAM = array(
			Job::YOUTH_TALENT_PROGRAM_SOCIAL_SALES => "Social Sales",
			Job::YOUTH_TALENT_PROGRAM_DEVELOPMENT => "Development",
			Job::YOUTH_TALENT_PROGRAM_PROJECTS => "Projects",
			Job::YOUTH_TALENT_PROGRAM_ADMINISTRATION => "Administration",
	);
	
	public static $DB_VALUES_REQUESTED_WORKSHOPS = array(
			"Rhetoric" => "Rhetoric",
			"Sales" => "Sales",
			"Leadership" => "Leadership",
			"Team Management" => "Team Management",
			"Time Management" => "Time Management",
			"Self Presentation" => "Self Presentation",
			"Teambuilding" => "Teambuilding",
			"Functional Training" => "Functional Training",
			"Kick Off" => "Kick Off",
			"Project Management" => "Project Management",
			"Youth Talent Development" => "Youth Talent Development",
			"Youth Talent Social Sales" => "Youth Talent Social Sales",
			"Youth Talent Administration" => "Youth Talent Administration",
			"Youth Talent Projects" => "Youth Talent Projects",
	);
	/**
	 * Choices Callbackfunction for Validation
	*/
	public static function getValuesRequestedWorkshops ()
	{
		return array_keys(DBValuesMembership::$DB_VALUES_REQUESTED_WORKSHOPS);
	}
	
	public static $DB_VALUES_EXCHANGE_TYPE = array(
			Membership::EXCHANGE_TYPE_GIP => "GIP",
			Membership::EXCHANGE_TYPE_GCDP => "GCDP",
	);
}