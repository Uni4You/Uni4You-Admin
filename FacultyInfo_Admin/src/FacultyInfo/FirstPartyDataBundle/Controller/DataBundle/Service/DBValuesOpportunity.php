<?php
namespace AIESEC\Portal\DataBundle\Service;
use AIESEC\Portal\DataBundle\Entity\Opportunity;

/**
 * 
 * @author Felix Goroncy
 */
class DBValuesOpportunity
{
	public static $DB_VALUES_CITY_LC = array(
		"Aachen","Augsburg","Bamberg","Bayreuth","Berlin HU",
		"Berlin TU","Bielefeld","Bochum","Bonn","Braunschweig",
		"Bremen","Darmstadt","Dortmund","Dresden","Duesseldorf",
		"Essen","Frankfurt","Freiburg","Giessen","Goettingen",
		"Halle","Hamburg","Hannover","Heidelberg","Jena",
		"Kaiserslautern","Karlsruhe","Kiel","Koeln","Leipzig",
		"Lueneburg","Magdeburg","Mainz","Mannheim","National","Muenchen",
		"Muenster","Nuernberg","Oldenburg","Paderborn","Passau",
		"Regensburg","Rostock","Saarbruecken","Stuttgart","Tuebingen",
		"Ulm","Wuerzburg","Wuppertal",
	);
	
	public static $DB_VALUES_TYPE = array(
			"LC Teamleader",
			"LC VP",
			"LCP",
			"NST Member",
			"MC Member",
	);
	
	public static $DB_VALUES_SUBTYPE = array(
			"ER","TM","ICX","OGX","oGIP","oGCDP",
			"Fin","Com","Reception","LCP","NIST",
			"NST ER","NST TM","NST ICX","NST oGIP",
			"NST oGCDP","NST Fin","NST Com","NST OD",
			"NST BD","RegioCo","NTT","Other",
	);
	
	public static $DB_VALUES_SCOPE = array(
			"LC Level",
			"National Level",
	);
}