<?php
namespace AIESEC\Portal\DataBundle\Service;

class DBValues
{
    const ATTACHMENT_DESCRIPTION_LANGUAGE_CERTIFICATE = "&lt;language_certificate&gt;";
    const ATTACHMENT_DESCRIPTION_CV = "&lt;cv&gt;";
    const ATTACHMENT_DESCRIPTION_AGB_SIGNED = "&lt;agb_signed&gt;";
    const ATTACHMENT_DESCRIPTION_CERTIFICATE_OF_ENROLLMENT = "&lt;certificate_of_enrollment&gt;";
    const ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT = "&lt;experience_report&gt;";
    const ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT_PROMO = "&lt;experience_report_promo&gt;";
    const ATTACHMENT_DESCRIPTION_PUBLIC = "&lt;public&gt;";
    
    public static $PUBLIC_ATTACHMENTS_DESCRIPTION = array(
		self::ATTACHMENT_DESCRIPTION_LANGUAGE_CERTIFICATE,
		self::ATTACHMENT_DESCRIPTION_CV,
		self::ATTACHMENT_DESCRIPTION_AGB_SIGNED,
		self::ATTACHMENT_DESCRIPTION_CERTIFICATE_OF_ENROLLMENT,
    	self::ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT,
		self::ATTACHMENT_DESCRIPTION_PUBLIC,
    	self::ATTACHMENT_DESCRIPTION_EXPERIENCE_REPORT_PROMO,
    );
    
	/**
	 * This function can be used to get a copied version of the array,
	 * where the values are changed to the keys with prefix and suffix.
	 * This can be used to generate labels for the Symfony translation
	 * tool while keeping the original keys for the underlying entity.
	 */
	public static function prepareDBValues ($array, $prefix, $suffix = "")
	{
		array_walk($array, create_function('&$value,$key,$extra', '$value = $extra[0].$key.$extra[1];'), 
				array(
						$prefix,
						$suffix
				));
		
		return $array;
	}

	public static $DB_VALUES_GENDER = array(
			'male' => 'Male',
			'female' => 'Female'
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getGenders ()
	{
		return array_keys(DBValues::$DB_VALUES_GENDER);
	}

	public static $DB_VALUES_UNIVERSITY = array(
			"accadis Hochschule Bad Homburg",
			"Adam-Ries-FH",
			"AKAD Bildungsgesellschaft",
			"Akademie der Bildenden Künste München",
			"Akademie der Bildenden Künste Nürnberg",
			"Akademie für Darstellende Kunst Baden-Württemberg",
			"Akademie für digitale Medienproduktion",
			"Alanus Hochschule für Kunst und Gesellschaft",
			"Albert-Ludwigs-Uni Freiburg",
			"Alice Salomon Hochschule Berlin",
			"AMD Akademie Mode & Design",
			"Angell Akademie Freiburg",
			"Angell Business School Freiburg",
			"Apollon Hochschule der Gesundheitswirtschaft",
			"ASH",
			"Augustana-Hochschule Neuendettelsau",
			"Baltic College",
			"Bauhaus-Uni Weimar",
			"bbw Hochschule",
			"bbw Hochschule,",
			"Bergische Uni Wuppertal",
			"Berliner Technische Kunsthochschule",
			"Beuth Hochschule für Technik Berlin",
			"Beuth-Uni",
			"Brand Academy – Hochschule für Design und Kommunikation",
			"Brandenburgische Technische Uni",
			"Brandenburgische Technische Universität",
			"Bucerius Law School",
			"Burg Giebichenstein Kunsthochschule Halle",
			"Business and Information Technology School",
			"Carl von Ossietzky Uni Oldenburg",
			"Charité–Unismedizin Berlin",
			"Charité–Universitätsmedizin Berlin,",
			"Christian-Albrechts-Uni zu Kiel",
			"Cologne Business School",
			"Design akademie berlin, Hochschule für Kommunikation und Design (FH)",
			"Deutsche Film- und Fernsehakademie Berlin",
			"Deutsche Hochschule der Polizei",
			"Deutsche Sporthochschule Köln",
			"Deutsche Uni für Verwaltungswissenschaften Speyer",
			"Dresden International University",
			"Duale Hochschule Baden-Württemberg",
			"EBC Hochschule Hamburg",
			"Eberhard Karls Universität Tübingen",
			"EBS Uni für Wirtschaft und Recht",
			"EBZ Business School",
			"Edith Maryon Kunstschule Freiburg",
			"Ernst-Abbe-Fachhochschule Jena",
			"Ernst-Moritz-Arndt-Uni Greifswald",
			"ESB",
			"ESCP Europe Campus Berlin",
			"ESCP Europe Campus Berlin,",
			"Europäische Fernhochschule Hamburg",
			"Europäische FH",
			"Europa-Uni Viadrina",
			"European School of Management and Technology",
			"Evangelische FH Rheinland-Westfalen-Lippe",
			"Evangelische Hochschule Berlin",
			"Evangelische Hochschule Darmstadt",
			"Evangelische Hochschule Freiburg",
			"Evangelische Hochschule für Kirchenmusik Dresden",
			"Evangelische Hochschule für Kirchenmusik Halle",
			"Evangelische Hochschule für Kirchenmusik Tübingen",
			"Evangelische Hochschule für Soziale Arbeit & Diakonie",
			"Evangelische Hochschule für Soziale Arbeit Dresden",
			"Evangelische Hochschule Ludwigsburg",
			"Evangelische Hochschule Nürnberg",
			"Evangelische Hochschule Tabor",
			"Fachhochschule Brandenburg,",
			"Fachhochschule des Mittelstands (Bielefeld)",
			"Fachhochschule des Mittelstands (Hannover)",
			"Fachhochschule des Mittelstands (Köln)",
			"Fachhochschule des Mittelstands (Pullheim)",
			"Fachhochschule des Mittelstands (Rostock)",
			"Fachhochschule des Mittelstands (Schwerin)",
			"Fachhochschule für öffentliche Verwaltung Nordrhein-Westfalen",
			"Fachhochschule für Verwaltung und Rechtspflege Berlin",
			"Fachhochschule Ottersberg",
			"Fachhochschule Potsdam",
			"Fachhochschule Stralsund",
			"FernUni in Hagen",
			"FH Aachen",
			"FH Bielefeld",
			"FH Bingen",
			"FH Brandenburg",
			"FH der Diakonie",
			"FH der Wirtschaft",
			"FH des Bundes für öffentliche Verwaltung",
			"FH des Mittelstands",
			"FH Dortmund",
			"FH Düsseldorf",
			"FH Erfurt",
			"FH Flensburg",
			"FH Frankfurt am Main",
			"FH für angewandtes Management",
			"FH für die Wirtschaft",
			"FH für Finanzen Nordrhein-Westfalen",
			"FH für öffentliche Verwaltung, Polizei und Rechtspflege Güstrow",
			"FH für öffentliche Verwaltung und Rechtspflege in Bayern",
			"FH für Rechtspflege Nordrhein-Westfalen",
			"FH für Verwaltung und Dienstleistung",
			"FH für Verwaltung und Rechtspflege Berlin",
			"FH für Wirtschaft und Technik Vechta/Diepholz/Oldenburg",
			"FH Kaiserslautern",
			"FH Kiel",
			"FH Köln",
			"FH KUNST Arnstadt",
			"FH Lübeck",
			"FH Mainz",
			"FH Münster",
			"FH Nordhausen",
			"FH Potsdam",
			"FH Schmalkalden",
			"FH Schwäbisch Hall",
			"FH Schwetzingen",
			"FH Südwestfalen",
			"FH Westküste",
			"FH Worms",
			"Filmakademie Baden-Württemberg",
			"Folkwang Uni der Künste",
			"FOM Hochschule",
			"Frankfurt School of Finance & Management",
			"Freie Hochschule für Grafik-Design & Bildende Kunst Freiburg",
			"Freie Hochschule Stuttgart",
			"Freie Theologische Hochschule Gießen",
			"Freie Uni Berlin",
			"Friedrich-Alexander-Uni Erlangen-Nürnberg",
			"Friedrich-Schiller-Uni Jena",
			"Georg-August-Uni Göttingen",
			"Georg-Simon-Ohm-Hochschule für angewandte Wissenschaften – FH Nürnberg",
			"German Graduate School of Management and Law",
			"German open Business School",
			"German open Business School,",
			"Gottfried Wilhelm Leibniz Uni Hannover",
			"Gustav-Siewerth-Akademie",
			"HafenCity Uni Hamburg",
			"Hamburg School of Business Administration",
			"Handelshochschule Leipzig",
			"HAWK Hochschule Hildesheim/Holzminden/Göttingen",
			"Heidelberg International Business Academy",
			"Heinrich-Heine-Uni Düsseldorf",
			"Helmut-Schmidt-Uni",
			"Hertie School of Governance",
			"Hertie School of Governance,",
			"Hessische Hochschule für Polizei und Verwaltung",
			"HFH Hamburger Fern-Hochschule",
			"Hochschule 21",
			"Hochschule Aalen",
			"Hochschule Albstadt-Sigmaringen",
			"Hochschule Amberg-Weiden",
			"Hochschule Anhalt",
			"Hochschule Ansbach",
			"Hochschule Aschaffenburg",
			"Hochschule Augsburg",
			"Hochschule Biberach",
			"Hochschule Bochum",
			"Hochschule Bonn-Rhein-Sieg",
			"Hochschule Bremen",
			"Hochschule Bremerhaven",
			"Hochschule Darmstadt",
			"Hochschule Deggendorf",
			"Hochschule der Bildenden Künste Saar",
			"Hochschule der Bundesagentur für Arbeit",
			"Hochschule der Deutschen Bundesbank",
			"Hochschule der Medien",
			"Hochschule der Polizei Hamburg",
			"Hochschule der Sparkassen-Finanzgruppe",
			"Hochschule Emden/Leer",
			"Hochschule Esslingen",
			"Hochschule Fresenius (Idstein)",
			"Hochschule Fulda",
			"Hochschule für Angewandte Sprachen – FH des SDI München",
			"Hochschule für angewandte Wissenschaften Coburg",
			"Hochschule für Angewandte Wissenschaften Hamburg",
			"Hochschule für angewandte Wissenschaften Würzburg-Schweinfurt",
			"Hochschule für Bildende Künste Braunschweig",
			"Hochschule für Bildende Künste Dresden",
			"Hochschule für bildende Künste Hamburg",
			"Hochschule für evangelische Kirchenmusik Bayreuth",
			"Hochschule für Fernsehen und Film München",
			"Hochschule für Film und Fernsehen „Konrad Wolf“",
			"Hochschule für Forstwirtschaft Rottenburg",
			"Hochschule für Gestaltung Offenbach am Main",
			"Hochschule für Gestaltung Schwäbisch Gmünd",
			"Hochschule für Gesundheit",
			"Hochschule für Gesundheit und Sport",
			"Hochschule für Gesundheit und Sport,",
			"Hochschule für Grafik und Buchkunst Leipzig",
			"Hochschule für Jüdische Studien",
			"Hochschule für Katholische Kirchenmusik und Musikpädagogik Regensburg",
			"Hochschule für Kirchenmusik der Evangelischen Kirche von Westfalen",
			"Hochschule für Kirchenmusik Heidelberg",
			"Hochschule für Künste Bremen",
			"Hochschule für Kunsttherapie Nürtingen",
			"Hochschule für Musik, Theater und Medien Hannover",
			"Hochschule für Musik Carl Maria von Weber Dresden",
			"Hochschule für Musik Detmold",
			"Hochschule für Musik Franz Liszt Weimar",
			"Hochschule für Musik Freiburg",
			"Hochschule für Musik Karlsruhe",
			"Hochschule für Musik Nürnberg",
			"Hochschule für Musik Saar",
			"Hochschule für Musik Trossingen",
			"Hochschule für Musik und Darstellende Kunst Frankfurt am Main",
			"Hochschule für Musik und Darstellende Kunst Mannheim",
			"Hochschule für Musik und Darstellende Kunst Stuttgart",
			"Hochschule für Musik und Tanz Köln",
			"Hochschule für Musik und Theater Hamburg",
			"Hochschule für Musik und Theater München",
			"Hochschule für Musik und Theater Rostock",
			"Hochschule für Musik und Theater „Felix Mendelssohn Bartholdy“ Leipzig",
			"Hochschule für Musik Würzburg",
			"Hochschule für Musik „Hanns Eisler“ Berlin",
			"Hochschule für Musik „Hanns Eisler“ Berlin,",
			"Hochschule für nachhaltige Entwicklung Eberswalde",
			"Hochschule für Öffentliche Verwaltung Bremen",
			"Hochschule für öffentliche Verwaltung und Finanzen Ludwigsburg",
			"Hochschule für Philosophie München",
			"Hochschule für Politik München",
			"Hochschule für Polizei Villingen-Schwenningen",
			"Hochschule für Schauspielkunst „Ernst Busch“ Berlin",
			"Hochschule für Schauspielkunst „Ernst Busch“ Berlin,",
			"Hochschule für Technik, Wirtschaft und Kultur Leipzig",
			"Hochschule für Technik Stuttgart",
			"Hochschule für Technik und Wirtschaft Berlin",
			"Hochschule für Technik und Wirtschaft des Saarlandes",
			"Hochschule für Technik und Wirtschaft Dresden",
			"Hochschule für Telekommunikation Leipzig",
			"Hochschule Furtwangen",
			"Hochschule für Wirtschaft und Recht Berlin",
			"Hochschule für Wirtschaft und Umwelt Nürtingen-Geislingen",
			"Hochschule Geisenheim",
			"Hochschule Hamm-Lippstadt",
			"Hochschule Hannover",
			"Hochschule Harz",
			"Hochschule Heilbronn",
			"Hochschule Hof",
			"Hochschule Ingolstadt",
			"Hochschule Karlsruhe – Technik und Wirtschaft",
			"Hochschule Kehl",
			"Hochschule Kempten",
			"Hochschule Koblenz",
			"Hochschule Konstanz Technik, Wirtschaft und Gestaltung",
			"Hochschule Landshut",
			"Hochschule Lausitz",
			"Hochschule Ludwigshafen am Rhein",
			"Hochschule Magdeburg-Stendal",
			"Hochschule Mannheim",
			"Hochschule Merseburg",
			"Hochschule Mittweida",
			"Hochschule München",
			"Hochschule Neubrandenburg",
			"Hochschule Neuss für Internationale Wirtschaft",
			"Hochschule Neu-Ulm",
			"Hochschule Niederrhein",
			"Hochschule Offenburg",
			"Hochschule Osnabrück",
			"Hochschule Ostwestfalen-Lippe",
			"Hochschule Pforzheim",
			"Hochschule Ravensburg-Weingarten",
			"Hochschule Regensburg",
			"Hochschule Reutlingen",
			"Hochschule RheinMain",
			"Hochschule Rhein-Waal",
			"Hochschule Rosenheim",
			"Hochschule Ruhr West",
			"Hochschule Trier",
			"Hochschule Ulm",
			"Hochschule Weihenstephan-Triesdorf",
			"Hochschule Wismar",
			"Hochschule Zittau/Görlitz",
			"Humboldt-Uni zu Berlin",
			"IB-Hochschule Berlin",
			"IB-Hochschule Berlin,",
			"International Business School (Lippstadt)",
			"International Business School (Nürnberg)",
			"International Business School of Service Management",
			"Internationale Hochschule Bad Honnef · Bonn",
			"Internationale Hochschule Calw",
			"Internationale Hochschule Liebenzell",
			"Internationales Hochschulinstitut Zittau",
			"International School of Management",
			"ISW Business School Freiburg",
			"Jacobs University Bremen",
			"Jade Hochschule",
			"Johannes Gutenberg-Uni Mainz",
			"Johann Wolfgang Goethe-Uni Frankfurt am Main",
			"Julius-Maximilians-Uni Würzburg",
			"Justus-Liebig-Uni Gießen",
			"Karlshochschule International University",
			"Karlsruher Institut für Technologie",
			"Katholische Hochschule Freiburg",
			"Katholische Hochschule für Kirchenmusik Rottenburg",
			"Katholische Hochschule für Sozialwesen Berlin",
			"Katholische Hochschule Mainz",
			"Katholische Hochschule Nordrhein-Westfalen",
			"Katholische StiftungsFH München",
			"Katholische Uni Eichstätt-Ingolstadt",
			"Kirchliche Hochschule Wuppertal/Bethel",
			"Kühne Logistics University",
			"Kunstakademie Düsseldorf",
			"Kunstakademie Münster",
			"Kunsthochschule Berlin-Weißensee",
			"Kunsthochschule für Medien Köln",
			"Kunsthochschule Kassel",
			"Leopold-Mozart-Zentrum",
			"Leuphana Uni Lüneburg",
			"Ludwig-Maximilians-Uni München",
			"Lutherische Theologische Hochschule Oberursel",
			"Macromedia Hochschule für Medien und Kommunikation",
			"Martin-Luther-Uni Halle-Wittenberg",
			"Mathias Hochschule Rheine",
			"Medizinische Hochschule Hannover",
			"Merz Akademie",
			"MSH Medical School Hamburg – FH für Gesundheit und Medizin",
			"Munich Business School",
			"Musikhochschule Lübeck",
			"Muthesius Kunsthochschule",
			"Naturwissenschaftlich-Technische Akademie Isny",
			"Nordakademie",
			"Norddeutsche Akademie für Finanzen und Steuerrecht",
			"Norddeutsche Hochschule für Rechtspflege",
			"Ostfalia Hochschule für angewandte Wissenschaften",
			"Otto-Friedrich-Uni Bamberg",
			"Otto-von-Guericke-Uni Magdeburg",
			"Pädagogische Hochschule Freiburg",
			"Pädagogische Hochschule Heidelberg",
			"Pädagogische Hochschule Karlsruhe",
			"Pädagogische Hochschule Ludwigsburg",
			"Pädagogische Hochschule Schwäbisch Gmünd",
			"Pädagogische Hochschule Weingarten",
			"Palucca Schule Dresden",
			"PFH Private Hochschule Göttingen",
			"Philipps-Uni Marburg",
			"Philosophisch-Theologische Hochschule Benediktbeuern",
			"Philosophisch-Theologische Hochschule Münster",
			"Philosophisch-Theologische Hochschule Sankt Georgen",
			"Philosophisch-Theologische Hochschule SVD St. Augustin",
			"Philosophisch-Theologische Hochschule Vallendar",
			"Popakademie Baden-Württemberg",
			"Private FernFH Sachsen",
			"Private FH Wedel",
			"Provadis School of International Management and Technology",
			"Rheinische FH Köln",
			"Rheinische Friedrich-Wilhelms-Uni Bonn",
			"Robert-Schumann-Hochschule Düsseldorf",
			"Ruhr-Uni Bochum",
			"Ruprecht-Karls-Uni Heidelberg",
			"RWTH Aachen",
			"SRH Fernhochschule Riedlingen",
			"SRH FH für Gesundheit Gera",
			"SRH Hochschule Berlin",
			"SRH Hochschule für Logistik und Wirtschaft",
			"SRH Hochschule für Wirtschaft und Medien Calw",
			"SRH Hochschule Heidelberg",
			"Staatliche Akademie der Bildenden Künste Karlsruhe",
			"Staatliche Akademie der Bildenden Künste Stuttgart",
			"Staatliche Hochschule für Bildende Künste – Städelschule",
			"Staatliche Hochschule für Gestaltung Karlsruhe",
			"Steinbeis-Hochschule Berlin",
			"Technische FH Georg Agricola",
			"Technische Hochschule Mittelhessen",
			"Technische Hochschule Wildau (FH)",
			"Technische Uni Bergakademie Freiberg",
			"Technische Uni Berlin",
			"Technische Uni Braunschweig",
			"Technische Uni Chemnitz",
			"Technische Uni Clausthal",
			"Technische Uni Darmstadt",
			"Technische Uni Dortmund",
			"Technische Uni Dresden",
			"Technische Uni Hamburg-Harburg",
			"Technische Uni Ilmenau",
			"Technische Uni Kaiserslautern",
			"Technische Uni München",
			"Theologische Fakultät Fulda",
			"Theologische Fakultät Paderborn",
			"Theologische Fakultät Trier",
			"Theologische Hochschule Ewersbach",
			"Theologische Hochschule Friedensau",
			"Theologische Hochschule Reutlingen",
			"Theologisches Seminar Elstal (Fachhochschule)",
			"Theologisches Seminar Elstal (FH)",
			"Thüringer FH für öffentliche Verwaltung",
			"Tierärztliche Hochschule Hannover",
			"Touro College Berlin",
			"Touro College Berlin,",
			"Ukrainische Freie Uni München",
			"Uni Augsburg",
			"Uni Bayreuth",
			"Uni Bielefeld",
			"Uni Bremen",
			"Uni der Bundeswehr München",
			"Uni der Künste Berlin",
			"Uni des Saarlandes",
			"Uni Duisburg-Essen",
			"Uni Erfurt",
			"Uni Flensburg",
			"Uni Hamburg",
			"Uni Hohenheim",
			"Uni Kassel",
			"Uni Koblenz-Landau - Campus Landau",
			"Uni Koblenz-Landau - Campus Koblenz",
			"Uni Konstanz",
			"Uni Leipzig",
			"Uni Mannheim",
			"Uni Paderborn",
			"Uni Passau",
			"Uni Potsdam",
			"Uni Regensburg",
			"Uni Rostock",
			"Uni Stuttgart",
			"Uni Trier",
			"Uni Ulm",
			"Uni Vechta",
			"Universität der Künste Berlin",
			"Universität Hildesheim",
			"Universität Osnabrück",
			"Universität Siegen",
			"University of Management and Communication (FH)",
			"University of Management and Communication (FH),",
			"Uni Witten/Herdecke",
			"Uni zu Köln",
			"Uni zu Lübeck",
			"Westfälische Hochschule Gelsenkirchen Bocholt Recklinghausen",
			"Westfälische Wilhelms-Uni",
			"Westsächsische Hochschule Zwickau",
			"WHU – Otto Beisheim School of Management",
			"Wildau",
			"Wilhelm Büchner Hochschule",
			"Wissenschaftliche Hochschule Lahr",
			"Zeppelin Uni"
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getUniversities ()
	{
		return array_keys(DBValues::$DB_VALUES_UNIVERSITY);
	}

	public static $DB_VALUES_GRADUATION_YEAR = array(
			"2013",
			"2014",
			"2015",
			"2016",
			"2017"
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getGraduationYears ()
	{
		return array_keys(DBValues::$DB_VALUES_GRADUATION_YEAR);
	}

	public static $DB_VALUES_DEGREE_TYPE = array(
			'diplom' => '"Diplom"',
			'bachelor' => 'Bachelor',
			'magister' => 'Magister',
			'master' => 'Master',
			'other' => 'Other'
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getDegreeTypes ()
	{
		return array_keys(DBValues::$DB_VALUES_DEGREE_TYPE);
	}

	public static $DB_VALUES_AREA_OF_STUDIES = array(
			'adminBusComMan' => 'Administration / Business / Commerce / Management',
			'artsHumanities' => 'Arts / Humanities',
			'compScience' => 'Computer Science',
			'econPolPublic' => 'Economics / Political Science / Public Affairs',
			'education' => 'Education',
			'engineering' => 'Engineering',
			'intDevelStudies' => 'International / Development Studies',
			'law' => 'Law',
			'mastersMBA' => 'Masters / MBA',
			'sciences' => 'Sciences',
			'otherStudies' => 'Other',
			//'agrarForstHaushaltErnaerung' => 'Agrar-, Forst-, Haushalts- und Ernährungswissenschaften',
			//'gesundheitMedizin' => 'Gesundheitswissenschaften, Medizin',
			//'ingeIngenieurwissenschaften
			//Kunst, Musik
			//Mathematik, Naturwissenschaften
			//Rechts-, Wirtschafts- und Sozialwissenschaften
			//Sprach- und Kulturwissenschaften
	);
	

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getAreasOfStudies ()
	{
		return array_keys(DBValues::$DB_VALUES_AREA_OF_STUDIES);
	}

	public static $DB_VALUES_STUDENT = array(
			'isStudent' => "Yes",
			'noStudent' => "No"
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getValuesIsStudent ()
	{
		return array_keys(DBValues::$DB_VALUES_STUDENT);
	}

	public static $DB_VALUES_YES_NO = array(
			'yes' => "Yes",
			'no' => "No"
	);
	
	/**
	 * Choices Callbackfunction for Validation
	*/
	public static function getValuesYesNo ()
	{
		return array_keys(DBValues::$DB_VALUES_YES_NO);
	}
	
	public static $DB_VALUES_ICLS_NECESSARY = array(
			'yes' => "Yes",
			'substitute' => "Substitute"
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getValuesICLSNecessary ()
	{
		return array_keys(DBValues::$DB_VALUES_ICLS_NECESSARY);
	}

	public static $DB_VALUES_LANGUAGES = array(
			"Arabic" => "Arabic",
			"Armenian" => "Armenian",
			"Bahasa Indonesian" => "Bahasa Indonesian",
			"Bahasa Malaysia" => "Bahasa Malaysia",
			"Bulgarian" => "Bulgarian",
			"Chinese Cantonese" => "Chinese Cantonese",
			"Chinese Mandarin" => "Chinese Mandarin",
			"Czech" => "Czech",
			"Danish" => "Danish",
			"Dutch" => "Dutch",
			"English" => "English",
			"Estonian" => "Estonian",
			"Farsi" => "Farsi",
			"Finnish" => "Finnish",
			"French" => "French",
			"Georgian" => "Georgian",
			"German" => "German",
			"Greek" => "Greek",
			"Hindi" => "Hindi",
			"Hungarian" => "Hungarian",
			"Italian" => "Italian",
			"Japanese" => "Japanese",
			"Kiswahili" => "Kiswahili",
			"Korean" => "Korean",
			"Latvian" => "Latvian",
			"Lithuanian" => "Lithuanian",
			"Norwegian" => "Norwegian",
			"Polish" => "Polish",
			"Portuguese" => "Portuguese",
			"Romanian" => "Romanian",
			"Russian" => "Russian",
			"Slavic" => "Slavic",
			"Slovak" => "Slovak",
			"Slovenian" => "Slovenian",
			"Spanish" => "Spanish",
			"Swedish" => "Swedish",
			"Thai" => "Thai",
			"Turkish" => "Turkish",
			"Ukrainian" => "Ukrainian",
			"Urdu" => "Urdu",
			"Vietnamese" => "Vietnamese"
	);

	/**
	 * Choices Callbackfunction for Validation
	 */
	public static function getLanguages ()
	{
		return array_keys(DBValues::$DB_VALUES_LANGUAGES);
	}

	public static $DB_VALUES_EP_STATUS = array(
			"available" => "Available",
			"matched" => "Matched",
			"realized" => "Realized",
			"onHolde" => "On Hold",
			"rejected" => "Rejected",
			"expired" => "Expired",
			"pending" => "Pending",
	);
	
	public static $DB_VALUES_AGB_STATUS = array(
			"review" => "Review",
			"confirmed" => "Confirmed",
			"notConfirmed" => "Not Confirmed",
			"notUploaded" => "not uploaded yet"
	);
	
	public static $DB_VALUES_EXCHANGE_TYPE = array(
			"gip" => "GIP",
			"gcdp" => "GCDP",
	);
}