<?php
/*
 * dymy_dice
 * Dice Roller for MyBB
 * Copyright 2011 Dylan Myers
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

// Hooks here...
$plugins->add_hook("datahandler_post_insert_post", "dymy_dice_do");
$plugins->add_hook("datahandler_post_insert_thread_post", "dymy_dice_do");
$plugins->add_hook("datahandler_post_update", "dymy_dice_do");

function dymy_dice_info()
{
	return array(
		"name"					=> "Dymy Dice",
		"description"			=> "Simple Dice Roller for MyBB",
		"website"				=> "http://mybb.dylanspcs.com",
		"author"				=> "Dylan Myers",
		"authorsite"			=> "http://mybb.dylanspcs.com",
		"version"				=> "1.1",
		"guid"					=> "d21fb41e339f465a28c51919fa375150",
		"compatibility" 		=> "18*",
	);
}

/*function dymy_dice_install()
{
}

function dymy_dice_is_installed()
{
	return false;
}

function dymy_dice_uninstall()
{
}*/

function dymy_dice_activate()
{
}

function dymy_dice_deactivate()
{
}

function dymy_dice_do(&$post)
{
	if(isset($post->post_update_data['message']))
	{
		$msg = $post->post_update_data['message'];
	}
	else if(isset($post->post_insert_data['message']))
	{
		$msg = $post->post_insert_data['message'];
	}
	else
	{
		return;
	}
	
		// Yes/No dice
	
	if (preg_match("#/yesno#", $msg, $m))
	{
		$rand = rand(1, 2);
		$response = "";
		if ($rand == 1) $response = "Tak";
		else $response = "Nie";
		$msg = preg_replace("#/yesno#", $response, $msg, 1);
	}

		// Coin dice

	if (preg_match("#/moneta#", $msg, $m))
		{
			$rand = rand(1, 2);
			$response = "";
			if ($rand == 1) $response = "<center>[b]Orzeł[/b]</center>";
			else $response = "<center>[b]Reszka[/b]</center>";
			$msg = preg_replace("#/moneta#", $response, $msg, 1);
		}
	

		// Random symbol generator by Różowa Fasolka

	if (preg_match("#/symbol#", $msg, $m))
		{
			$msg = preg_replace("#/symbol#", get_random_symbol(), $msg, 1);
		}
	

		// Random direction generator by Różowa Fasolka

	if (preg_match("#/direction#", $msg, $m))
		{
			$msg = preg_replace("#/direction#", get_random_direction(), $msg, 1);
		}
	

		// Random fortune cookie generator by Różowa Fasolka

	if (preg_match("#/cookie#", $msg, $m))
		{
			$msg = preg_replace("#/cookie#", get_random_cookie(), $msg, 1);
		}

	
		// Random rune generator by Różowa Fasolka

	if (preg_match("#/rune#", $msg, $m))
		{
			$msg = preg_replace("#/rune#", get_random_rune(), $msg, 1);
		}
	

		// Random card generator by Tajemnicza Zielona Fasolka
	
	if (preg_match("#/card#", $msg, $m))
	{
		$msg = preg_replace("#/card#", nobu_get_random_card(), $msg, 1);
	}

	
		// Random bean flavour generator by Różowa Fasolka
	
	if (preg_match("#/bean#", $msg, $m))
	{
		$msg = preg_replace("#/bean#", get_random_bean(), $msg, 1);
	}

	
		// Random exploding card generator by Różowa Fasolka

	if (preg_match("#/explode#", $msg, $m))
	{
		$msg = preg_replace("#/explode#", get_random_explode(), $msg, 1);
	}


	// Random board generator by Różowa Fasolka

	if (preg_match("#/board#", $msg, $m))
	{
		$msg = preg_replace("#/board#", get_random_board(), $msg, 1);
	}


	// Random magic jenga generator by Różowa Fasolka

	if (preg_match("#/jenga#", $msg, $m))
	{
	$msg = preg_replace("#/jenga#", get_jenga_effect(), $msg, 1);
	}
	
		// Simple dice by Dylan Myers
	
	while(preg_match("#/dice (\d+)d(\d+)\+(\d+)#i", $msg, $m))
	{
		$dice = "(";
		$s = "";
		$total = 0;
		for($i = 0;$i < $m[1];$i++)
		{
			$rand = rand(1, $m[2]);
			$total += $rand;
			$dice .= $s.$rand;
			$s = ", ";
		}
		$dice .= $s."+".$m[3].")";
		$total += $m[3];
		$msg = preg_replace("#/dice {$m[1]}d{$m[2]}\+{$m[3]}#i", "{$m[1]}d{$m[2]}+{$m[3]} rzucono z sumą oczek równą: {$total} {$dice}", $msg, 1);
	}
	while(preg_match("#/roll (\d+)d(\d+)\+(\d+)#i", $msg, $m))
	{
		$dice = "(";
		$s = "";
		$total = 0;
		for($i = 0;$i < $m[1];$i++)
		{
			$rand = rand(1, $m[2]);
			$total += $rand;
			$dice .= $s.$rand;
			$s = ", ";
		}
		$dice .= $s."+".$m[3].")";
		$total += $m[3];
		$msg = preg_replace("#/roll {$m[1]}d{$m[2]}\+{$m[3]}#i", "{$m[1]}d{$m[2]}+{$m[3]} rzucono z sumą oczek równą: {$total} {$dice}", $msg, 1);
	}
	while(preg_match("#/dice (\d+)d(\d+)#i", $msg, $m))
	{
		$dice = "(";
		$s = "";
		$total = 0;
		for($i = 0;$i < $m[1];$i++)
		{
			$rand = rand(1, $m[2]);
			$total += $rand;
			$dice .= $s.$rand;
			$s = ", ";
		}
		$dice .= ")";
		$msg = preg_replace("#/dice {$m[1]}d{$m[2]}#i", "{$m[1]}d{$m[2]} rzucono z sumą oczek równą: {$total} {$dice}", $msg, 1);
	}
	while(preg_match("#/roll (\d+)d(\d+)#i", $msg, $m))
	{
		$dice = "(";
		$s = "";
		$total = 0;
		for($i = 0;$i < $m[1];$i++)
		{
			$rand = rand(1, $m[2]);
			$total += $rand;
			$dice .= $s.$rand;
			$s = ", ";
		}
		$dice .= ")";
		$msg = preg_replace("#/roll {$m[1]}d{$m[2]}#i", "{$m[1]}d{$m[2]} rzucono z sumą oczek równą: {$total} {$dice}", $msg, 1);
	}
	

	if(isset($post->post_update_data['message']))
	{
		$post->post_update_data['message'] = $msg;
	}
	else if(isset($post->post_insert_data['message']))
	{
		$post->post_insert_data['message'] = $msg;
	}
	else
	{
		return;
	}
}


		// Function for random card generator by Tajemnicza Zielona Fasolka

function nobu_get_random_card()
	{
		$cards = array(
			
					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Rcm5eLM.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Rcm5eLM.png]\' /><br />
					#1<br />
					<span style=\'font-weight: bold;\'>Merlin</span><br />
					Najbardziej znany czarodziej świata.<br />
					Średniowieczny nauczyciel i doradca króla Artura.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/sBC0zyE.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: sBC0zyE.png]\' /><br />
					#2<br />
					<span style=\'font-weight: bold;\'>Cornelius Agrippa</span><br />
					1486–1535<br />
					Niemiecki czarodziej, autor licznych książek na temat czarodziejów i magii.<br />
					Oskarżony o czary przez mugoli, uwięziony i skazany.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/C9G8OMI.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: C9G8OMI.png]\' /><br />
					#3<br />
					<span style=\'font-weight: bold;\'>Elfrida Clagg</span><br />
					1612-1687<br />
					Przywódczyni Rady Magów po Burdocku Muldoonie.<br />
					Wprowadziła kolejne zmiany w polityce wobec magicznych stworzeń.<br />
					Zakazała polowania na zagrożone wyginięciem znikacze,<br />
					które w rozgrywkach Quidditcha zastąpiono zniczami.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/mMe5E8e.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: mMe5E8e.png]\' /><br />
					#4<br />
					<span style=\'font-weight: bold;\'>Grogan Stump</span><br />
					1770-1884<br />
					Popularny Minister Magii i pasjonat Quidditcha.<br />
					Ustanowił Departament Magicznych Gier i Sportów <br />
					oraz wydziały: Zwierząt, Istot i Duchów.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielony do Hufflepuffu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/RjWePHC.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: RjWePHC.png]\' /><br />
					#5<br />
					<span style=\'font-weight: bold;\'>Gulliver Pokeby</span><br />
					1750-1839<br />
					Magizoolog, znawca magicznych ptaków.<br />
					Jako pierwszy poprawnie zinterpretował krzyki lelków wróżebników.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/ri5YFFB.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ri5YFFB.png]\' /><br />
					#6<br />
					<span style=\'font-weight: bold;\'>Glanmore Peakes</span><br />
					1677-1761<br />
					Szkocki czarodziej i kapitan.<br />
					Znany z pokonania węża morskiego z Cromer.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/5nliCIP.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 5nliCIP.png]\' /><br />
					#7<br />
					<span style=\'font-weight: bold;\'>Hesper Starkey</span><br />
					1841-1929<br />
					Twórczyni eliksirów i autorka książek.<br />
					Badała zależności pomiędzy warzeniem mikstur i fazami księżyca.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Q0WtRhy.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Q0WtRhy.png]\' /><br />
					#8<br />
					<span style=\'font-weight: bold;\'>Derwent Shimpling</span><br />
					1840-1934<br />
					Znany komik o kontrowersyjnym poczuciu humoru.<br />
					Jego skóra zmieniła kolor na fioletowy po tym, jak w ramach zakładu<br />
					spożył całą jadowitą tentakulię.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/IFyUn2v.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: IFyUn2v.png]\' /><br />
					#9<br />
					<span style=\'font-weight: bold;\'>Gunhilda z Gorsemoor</span><br />
					1556-1639<br />
					Czarownica, która stworzyła lekarstwo na smoczą ospę.<br />
					Miała tylko jedno oko oraz garba.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/IsOdeZB.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: IsOdeZB.png]\' /><br />
					#10<br />
					<span style=\'font-weight: bold;\'>Burdock Muldoon</span><br />
					1429-1490<br />
					Przewodniczący Rady Magów, później przekształconą w Ministerstwo Magii.<br />
					Zgodnie z jego zarządzeniem wprowadzono rozróżnienie nie-ludzkich,<br />
					magicznych stworzeń na istoty i zwierzęta. </div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/V9sixIX.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: V9sixIX.png]\' /><br />
					#11<br />
					<span style=\'font-weight: bold;\'>Herpo Podły</span><br />
					Czarnoksiężnik pochodzący ze starożytnej Grecji.<br />
					Odpowiedzialny za stworzenie pierwszego bazyliszka.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/6jgAAdQ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 6jgAAdQ.png]\' /><br />
					#12<br />
					<span style=\'font-weight: bold;\'>Merwyn Nikczemny</span><br />
					Średniowieczny czarnoksiężnik, <br />
					twórca licznych klątw i uroków.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/E6nOWis.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: E6nOWis.png]\' /><br />
					#13<br />
					<span style=\'font-weight: bold;\'>Andros Niezwyciężony</span><br />
					Czarodziej pochodzący ze starożytnej Grecjii.<br />
					Znany z umiejętności tworzenia cielesnego Patronusa gigantycznych rozmiarów.<br />
					Mistrz magii bezróżdżkowej.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Bf6jNs8.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Bf6jNs8.png]\' /><br />
					#14<br />
					<span style=\'font-weight: bold;\'>Fulbert Strachliwy</span><br />
					1014-1097<br />
					Czarodziej znany ze swojego niesamowitego tchórzostwa.<br />
					Bał się opuszczać swój dom, zginął kiedy zawalił się na niego dach.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/jRUxg0W.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: jRUxg0W.png]\' /><br />
					#15<br />
					<span style=\'font-weight: bold;\'>Paracelsus</span><br />
					1493-1591<br />
					Alchemik, twórca eliksirów i uzdrowiciel.<br />
					Jako pierwszy opisał fenomen wężoustości.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/MUHUngI.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: MUHUngI.png]\' /><br />
					#16<br />
					<span style=\'font-weight: bold;\'>Cliodne</span><br />
					Irlandzka druidka żyjąca w średniowieczu.<br />
					Znana z zamiłowania do zielarstwa. <br />
					Była animagiem potrafiącym zmieniać się w morskiego ptaka.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/6H47kOu.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 6H47kOu.png]\' /><br />
					#17<br />
					<span style=\'font-weight: bold;\'>Morgan le Fay</span><br />
					Średniowieczna czarownica, siostra przyrodnia króla Artura.<br />
					Uzdrowicielka, wróg Merlina i animag potrafiący zmieniać się w ptaka.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/aZjA85f.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: aZjA85f.png]\' /><br />
					#18<br />
					<span style=\'font-weight: bold;\'>Ulric Dziwak</span><br />
					Ekscentryczny, średniowieczny czarodziej.<br />
					Uważany za najdziwniejszego maga w historii,<br />
					stanowi puentę wielu żartów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/6yEewxC.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 6yEewxC.png]\' /><br />
					#19<br />
					<span style=\'font-weight: bold;\'>Newton Scamander</span><br />
					1897~<br />
					Podróżnik i magizoolog. Autor popularnego podręcznika<br />
					\'Fantastyczne zwierzęta i jak je znaleźć\'.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielony do Hufflepuffu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/usoype4.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: usoype4.png]\' /><br />
					#20<br />
					<span style=\'font-weight: bold;\'>Cudaczna Wendelin</span><br />
					Średniowieczna czarownica o zamiłowaniu do<br />
					bycia paloną żywcem na stosie.<br />
					Pozwoliła złapać się mugolom wielokrotnie,<br />
					używając różnych przebrań.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/WPW4nQ7.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: WPW4nQ7.png]\' /><br />
					#21<br />
					<span style=\'font-weight: bold;\'>Emrys Wittermore</span><br />
					1672-1769<br />
					Znany hodowca pegazów. Założyciel <br />
					działającej w Walii od pokoleń stadniny. <br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielon do Ravenclawu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/hTLsqWw.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: hTLsqWw.png]\' /><br />
					#22<br />
					<span style=\'font-weight: bold;\'>Kirke</span><br />
					Czarownica pochodząca ze starożytnej Grecji, żyjąca na wyspie Aeaea.<br />
					Mistrzyni transmutacji, znana z przemieniania żeglarzy w świnie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/hmDdSxR.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: hmDdSxR.png]\' /><br />
					#23<br />
					<span style=\'font-weight: bold;\'>Dexter Abbott</span><br />
					1911~<br />
					Aktor, celebryta, ulubieniec publiczności.<br />
					Znany z bycia sławnym.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/K6jz4Jc.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: K6jz4Jc.png]\' /><br />
					#24<br />
					<span style=\'font-weight: bold;\'>Adalbert Waffling</span><br />
					1841-1933<br />
					Znany teoretyk magii, autor licznych książek.<br />
					Stworzył szeroką gamę zaklęć inwokacyjnych.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/vFXbFy1.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: vFXbFy1.png]\' /><br />
					#25<br />
					<span style=\'font-weight: bold;\'>Perpetua Fancourt</span><br />
					1800-1891<br />
					Astronom i astrolog, twórca licznych map nieba.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielona do Ravenclawu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Hsve64l.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Hsve64l.png]\' /><br />
					#26<br />
					<span style=\'font-weight: bold;\'>Almeric Sawbridge</span><br />
					1602–1699<br />
					Znany z pokonania trolla rzecznego terroryzującego bród na Wye River.<br />
					Rzeczony troll, według podań, był jednym z największych,<br />
					jakie kiedykolwiek żyły na terenach Wielkiej Brytanii. </div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/984ypSv.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 984ypSv.png]\' /><br />
					#27<br />
					<span style=\'font-weight: bold;\'>Mirabella Plunkett</span><br />
					1839-?<br />
					Czarownica, która zakochała się w trytonie z Loch Lomond.<br />
					Transmutowała się w rybę, żeby zamieszkać z ukochanym.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/QyXG6bC.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: QyXG6bC.png]\' /><br />
					#28<br />
					<span style=\'font-weight: bold;\'>Tilly Toke</span><br />
					1803-1891<br />
					Znana poskramiaczka smoków.<br />
					Opracowała wiele zasad pracy z tymi gadami.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/c8jOeJn.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: c8jOeJn.png]\' /><br />
					#29<br />
					<span style=\'font-weight: bold;\'>Archibald Alderton</span><br />
					1568-1623<br />
					Czarodziej-kucharz.<br />
					Znany z przypadkowego wysadzenia wioski Little Dropping w Hampshire,<br />
					podczas próby wymieszania zaklęciem składników na ciasto urodzinowe. </div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/IMomgY7.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: IMomgY7.png]\' /><br />
					#30<br />
					<span style=\'font-weight: bold;\'>Artemisia Lufkin</span><br />
					1754-1825<br />
					Pierwsza czarownica, która została Ministrem Magii w Wielkiej Brytanii.<br />
					Wybrana na stanowisko dwukrotnie,<br />
					założyła Departament Międzynarodowej Współpracy Czarodziejów.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielona do Hufflepuffu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/NRag9oU.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: NRag9oU.png]\' /><br />
					#31<br />
					<span style=\'font-weight: bold;\'>Balfour Blane </span><br />
					1566-1629<br />
					Twórca licznych uroków. <br />
					Założyciel Komisji Zaklęć Eksperymentalnych, która w 1707 roku<br />
					weszła w skład nowo powstającego Ministerstwa Magii. </div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/mlM74yL.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: mlM74yL.png]\' /><br />
					#32<br />
					<span style=\'font-weight: bold;\'>Bridget Wenlock</span><br />
					1202–1285<br />
					Słynna numerolog z trzynastego wieku.<br />
					Jako pierwsza zbadała i opisała magiczne właściwości siódemki.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/lGhM4Ks.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: lGhM4Ks.png]\' /><br />
					#33<br />
					<span style=\'font-weight: bold;\'>Beaumont Marjoribanks</span><br />
					1742-1845<br />
					Pionier zielarstwa, zebrał i sklasyfikował wiele rodzajów roślin.<br />
					Przypisuje się mu odkrycie właściwości skrzeloziela.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/uFTyDcA.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: uFTyDcA.png]\' /><br />
					#34<br />
					<span style=\'font-weight: bold;\'>Serpens Black</span><br />
					1905~<br />
					Kapitan i pałkarz narodowej drużyny Quidditcha.<br />
					Według rankingu Proroka jeden z najlepszych graczy<br />
					w historii Brytyjsko-Irlandzka Ligi.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielony do Slytherinu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/GrKc2Rg.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GrKc2Rg.png]\' /><br />
					#35<br />
					<span style=\'font-weight: bold;\'>Bowman Wright</span><br />
					1492-1560<br />
					Mistrz uroków i magiczny kowal pochodzący z Doliny Godryka.<br />
					Znany ze stworzenia prototypu Złotego Znicza.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/0MdbsRp.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 0MdbsRp.png]\' /><br />
					#36<br />
					<span style=\'font-weight: bold;\'>hrabia Vlad Dracul</span><br />
					1390-?<br />
					Średniowieczny czarnoksiężnik.<br />
					Potężny wampir i ojciec Vlada Palownika.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/0GQ6ZeL.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 0GQ6ZeL.png]\' /><br />
					#37<br />
					<span style=\'font-weight: bold;\'>Cassandra Vablatsky</span><br />
					Jasnowidz i autorka licznych tekstów na temat wróżbiarstwa.<br />
					Jej najpopularniejsza książka to \'Demaskowanie przyszłości\'.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/STeoawO.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: STeoawO.png]\' /><br />
					#38<br />
					<span style=\'font-weight: bold;\'>Chauncey Oldridge</span><br />
					1342–1379<br />
					Pierwsza znana ofiara smoczej ospy. <br />
					Zmarł zanim udało się wynaleźć jakiekolwiek skuteczne lekarstwo.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/SjzfF9s.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: SjzfF9s.png]\' /><br />
					#39<br />
					<span style=\'font-weight: bold;\'>Volan Travers</span><br />
					1781-1843<br />
					Jeden z najlepiej znanych mediów w historii.<br />
					Napisał wiele traktatów naukowych na temat duchów<br />
					i życia po śmierci.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/FV8BROO.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: FV8BROO.png]\' /><br />
					#40<br />
					<span style=\'font-weight: bold;\'>Alastor \'Błyskawica\' Malfoy</span><br />
					1910~<br />
					Od 1934 roku ścigający narodowej drużyny Quidditcha.<br />
					Wcześniej najmłodszy członek Armat z Chudley w historii,<br />
					trafił do drużyny w wieku siedemnastu lat.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielony do Slytherinu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/ZkE3KmX.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ZkE3KmX.png]\' /><br />
					#41<br />
					<span style=\'font-weight: bold;\'>Godric Gryffindor</span><br />
					Średniowieczny czarodziej, jeden ze współzałożycieli<br />
					Szkoły Magii i Czarodziejstwa w Hogwarcie.<br />
					Pierwszy właściciel Tiary Przydziału oraz Miecza Gryffindora.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/YjtxdFp.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: YjtxdFp.png]\' /><br />
					#42<br />
					<span style=\'font-weight: bold;\'>Crispin Cronk</span><br />
					1795-1872<br />
					Prowadził nielegalną hodowlę sfinksów w ogrodzie swojego domu.<br />
					Skazany na pobyt w Azkabanie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/nOXmc8y.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: nOXmc8y.png]\' /><br />
					#43<br />
					<span style=\'font-weight: bold;\'>Cyprian Youdle</span><br />
					1312–1357<br />
					Jedyny sędzia Quidditcha, który kiedykolwiek zginął w trakcie meczu. <br />
					Autora klątwy, która go dosięgnęła nigdy nie zidentyfikowano.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/XhCqxXl.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: XhCqxXl.png]\' /><br />
					#44<br />
					<span style=\'font-weight: bold;\'>Dorian Weasley</span><br />
					1692-1788<br />
					Magizoolog, który zasłynął swoimi<br />
					traktatami naukowymi na temat smoków.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/PKpFSuD.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: PKpFSuD.png]\' /><br />
					#45<br />
					<span style=\'font-weight: bold;\'>Bathsheba Lestrange-Parkinson</span><br />
					1829-1876<br />
					Potężna czarownica i półwila.<br />
					Wraz z mężem uznawani za najpotężniejszych aurorów<br />
					w historii Ministerstwa Magii. Pierwsza czarownica, która<br />
					została szefem Biura Aurorów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/ooYjodl.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ooYjodl.png]\' /><br />
					#46<br />
					<span style=\'font-weight: bold;\'>Gabriel Parkinson</span><br />
					1823-1876<br />
					Wraz z małżonką uznawani za najpotężniejszych<br />
					aurorów w historii Ministerstwa Magii.<br />
					Zginęli tragicznie podczas pełnienia obowiązków.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/LJDtSh1.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: LJDtSh1.png]\' /><br />
					#47<br />
					<span style=\'font-weight: bold;\'>Edgar Stroulger</span><br />
					1703-1798<br />
					Magiczny wynalazca.<br />
					Zbudował, między innymi, pierwszy fałszoskop.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/5BGkT1V.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 5BGkT1V.png]\' /><br />
					#48<br />
					<span style=\'font-weight: bold;\'>Salazar Slytherin</span><br />
					Średniowieczny czarodziej, jeden ze współzałożycieli<br />
					Szkoły Magii i Czarodziejstwa w Hogwarcie.<br />
					Opanował perfekcyjnie swój dar wężoustości oraz leglimencję.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/w99juJR.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: w99juJR.png]\' /><br />
					#49<br />
					<span style=\'font-weight: bold;\'>Elladora Ketteridge</span><br />
					1656-1729<br />
					Faktyczna odkrywczyni skrzeloziela.<br />
					O mało nie zginęła dusząc się, nim wetknęła głowę do wiadra z wodą.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/TW5kr3H.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: TW5kr3H.png]\' /><br />
					#50<br />
					<span style=\'font-weight: bold;\'>Musidora Barkwith</span><br />
					1520-1666<br />
					Muzyk i kompozytor, autorka niedokończonej Magicznej Suity,<br />
					w której występowała między innymi wybuchająca tuba.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/dOc897s.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: dOc897s.png]\' /><br />
					#51<br />
					<span style=\'font-weight: bold;\'>Ethelred Zawsze Gotowy</span><br />
					Średniowieczny czarodziej znany ze swojej porywczości<br />
					i przeklinania przypadkowych przechodniów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/qT46u7U.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: qT46u7U.png]\' /><br />
					#52<br />
					<span style=\'font-weight: bold;\'>Felix Summerbee</span><br />
					1447-1508<br />
					Zaklęciotwórca zajmujący się głównie iluzjami. <br />
					Odpowiedzialny za stworzenie czaru rozweselającego.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/urxtHJG.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: urxtHJG.png]\' /><br />
					#53<br />
					<span style=\'font-weight: bold;\'>Isadora Macmillan</span><br />
					1778-1869<br />
					Pisarka i poetka.<br />
					Wiersze jej autorstwa uznawane są za<br />
					skarb literatury magicznego społeczeństwa.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Qzj1BEc.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Qzj1BEc.png]\' /><br />
					#54<br />
					<span style=\'font-weight: bold;\'>Icarus Selwyn</span><br />
					1699-1751<br />
					Alchemik, twórca eliksirów, wężousty.<br />
					Opracował miksturę wybuchową.<br />
					Zginął w pożarze własnego laboratorium.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/vVEIrpY.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: vVEIrpY.png]\' /><br />
					#55<br />
					<span style=\'font-weight: bold;\'>Honoria Nutcombe</span><br />
					1665-1743<br />
					Założycielka organizacji charytatywnej znanej jako<br />
					Stowarzyszenie Reformacji Wiedźm.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/utPDDoZ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: utPDDoZ.png]\' /><br />
					#56<br />
					<span style=\'font-weight: bold;\'>Myrna Longbottom</span><br />
					1850-1934<br />
					Kierownik Departamentu Magicznych Wypadków i Katastrof.<br />
					Dzięki przeprowadzonej przez nią sprawnej akcji ratowniczej<br />
					Ministerstwo Magii nie spłonęło w latach 90.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/4ajslBw.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 4ajslBw.png]\' /><br />
					#57<br />
					<span style=\'font-weight: bold;\'>Gifford Ollerton</span><br />
					1390–1441<br />
					Czarodziej i wojownik, pogromca gigantów.<br />
					Pokonał giganta Hengista z Upper Barnton.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Br3BCEt.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Br3BCEt.png]\' /><br />
					#58<br />
					<span style=\'font-weight: bold;\'>Glover Hipworth</span><br />
					1742-1805<br />
					Znany uzdrowiciel i mistrz eliksirów.<br />
					Stworzył eliksir pieprzowy, lekarstwo na katar.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/AjYQxZh.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: AjYQxZh.png]\' /><br />
					#59<br />
					<span style=\'font-weight: bold;\'>Gregory Przymilny</span><br />
					Średniowieczny czarodziej i twórca eliksirów.<br />
					Uwarzył eliksir powodujący, że każdy kto go wypije uważa <br />
					przygotowującego za swojego najlepszego przyjaciela.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/GTvLYgI.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GTvLYgI.png]\' /><br />
					#60<br />
					<span style=\'font-weight: bold;\'>Laverne de Montmorency</span><br />
					1823-1893<br />
					Mistrzyni eliksirów, wynalazła liczne odmiany<br />
					wywarów miłosnych.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielona do Ravenclawu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/ir2IRv3.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ir2IRv3.png]\' /><br />
					#61<br />
					<span style=\'font-weight: bold;\'>Havelock Sweeting</span><br />
					1634-1710<br />
					Magizoolog, ekspert w dziedzinie jednorożców.<br />
					Pomagał zakładać rezerwaty jednorożców w Wielkiej Brytanii.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/YCFlP8s.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: YCFlP8s.png]\' /><br />
					#62<br />
					<span style=\'font-weight: bold;\'>Ignatia Wildsmith</span><br />
					1227–1320<br />
					Wynalazła proszek Fiuu.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie, <br />
					przydzielona do Ravenclawu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/c2Z6ARs.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: c2Z6ARs.png]\' /><br />
					#63<br />
					<span style=\'font-weight: bold;\'>Caractacus Burke</span><br />
					1781-1866<br />
					Kolekcjoner czarnomagicznych artefaktów.<br />
					Wraz z Borginem założył sklep z takowymi.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielony do Slytherinu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/uuZEvVP.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: uuZEvVP.png]\' /><br />
					#64<br />
					<span style=\'font-weight: bold;\'>Ophiuchus Biblethump</span><br />
					1838~<br />
					Znany wróżbita i wieloletni, zasłużony dyrektor<br />
					Szkoły Magii i Czarodziejstwa w Hogwarcie.<br />
					Zrewolucjonizował podejście do wróżenia z pasjansa.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/djQLKT0.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: djQLKT0.png]\' /><br />
					#65<br />
					<span style=\'font-weight: bold;\'>Gondoline Oliphant</span><br />
					1720-1799<br />
					Magizoolog studiująca życie i zwyczaje trolli.<br />
					Zatłuczona na śmierć podczas szkicowania w Cotswolds.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/NmeGytG.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: NmeGytG.png]\' /><br />
					#66<br />
					<span style=\'font-weight: bold;\'>Flavius Belby</span><br />
					1715-1791<br />
					Podróżnik i magizoolog.<br />
					Przeżył spotkanie ze śmierciotulą w Papui Nowej Gwinei.<br />
					Odkrył wpływ zaklęcia Patronusa na śmierciotule.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/GirfEWU.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GirfEWU.png]\' /><br />
					#67<br />
					<span style=\'font-weight: bold;\'>John Dee</span><br />
					1527-1608<br />
					Astrolog na dworze Elżbiety I.<br />
					Był medium, przyjaźnił się z duchami.<br />
					Poszukiwał kamienia filozoficznego<br />
					i poznał starożytny język enochański.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/sHjokRA.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: sHjokRA.png]\' /><br />
					#68<br />
					<span style=\'font-weight: bold;\'>Gerald Brousseau Gardner</span><br />
					1884~<br />
					Uzdrowiciel i badacz.<br />
					Spisał wszystkie znane zastosowania białej magii.<br />
					Sporządził również spis składników,<br />
					zaklęć i eliksirów leczniczych.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/zUvDKyO.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: zUvDKyO.png]\' /><br />
					#69<br />
					<span style=\'font-weight: bold;\'>Robert Fludd</span><br />
					1574-1637<br />
					Astrolog i astronom.<br />
					Opisał szczegółowo wpływ księżyca i planet<br />
					na każdy ze znaków zodiaku.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/oTrV7Rr.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: oTrV7Rr.png]\' /><br />
					#70<br />
					<span style=\'font-weight: bold;\'>Leopoldina Smethwyck</span><br />
					1849-1930<br />
					Pierwsza w historii rozgrywek Quidditcha czarownica,<br />
					która została sędzią meczów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/GMi69oh.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GMi69oh.png]\' /><br />
					#71<br />
					<span style=\'font-weight: bold;\'>Królowa Maeve</span><br />
					Średniowieczna czarownica.<br />
					Szkoliła czarodziejów na terenach Irlandii<br />
					jeszcze przed założeniem Hogwartu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/a3Q27Hf.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: a3Q27Hf.png]\' /><br />
					#72<br />
					<span style=\'font-weight: bold;\'>Helga Hufflepuff</span><br />
					Średniowieczna czarownica, jedna ze współzałożycieli<br />
					Szkoły Magii i Czarodziejstwa w Hogwarcie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/3POYSg7.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 3POYSg7.png]\' /><br />
					#73<br />
					<span style=\'font-weight: bold;\'>Mopsus</span><br />
					Czarodziej pochodzący ze starożytnej Grecji.<br />
					Obdarzony talentem jasnowidzenia, <br />
					pokonał Calachasa podczas pojedynku jasnowidzów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/h4rA4a8.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: h4rA4a8.png]\' /><br />
					#74<br />
					<span style=\'font-weight: bold;\'>Montague Knightley</span><br />
					1506-1588<br />
					Zwycięzca niezliczonych pojedynków szachowych,<br />
					okrzyknięty mistrzem czarodziejskich szachów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/jmSV7Px.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: jmSV7Px.png]\' /><br />
					#75<br />
					<span style=\'font-weight: bold;\'>Mungo Bonham</span><br />
					1560-1659<br />
					Jeden z najbardziej znanych uzdrowicieli wszech czasów.<br />
					Założyciel szpitala Świętego Munga w Londynie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/3uJ8Gwq.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 3uJ8Gwq.png]\' /><br />
					#76<br />
					<span style=\'font-weight: bold;\'>hrabia de Saint-Germaine</span><br />
					Alchemik, muzyk i okultysta.<br />
					Prawdopodobnie wynalazł eliksir nieśmiertelności,<br />
					zniknął w nieodkrytych okolicznościach mając około trzystu lat.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/ciwub9h.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ciwub9h.png]\' /><br />
					#77<br />
					<span style=\'font-weight: bold;\'>Johann Georg Faust</span><br />
					1480–1536<br />
					Potężny średniowieczny magi i alchemik.<br />
					Rozwinął szeroko pojętą nekromancję<br />
					i napisał na jej temat wiele dzieł naukowych.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Yop99Im.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Yop99Im.png]\' /><br />
					#78<br />
					<span style=\'font-weight: bold;\'>Medea</span><br />
					Bratanica starożytnej wiedźmy Kirke.<br />
					Jako pierwsza zgłębiła sztukę tworzenia eliksirów,<br />
					przypisuje się jej uwarzenie legendarnego eliksiru młodości<br />
					oraz maści działającej jak Zaklęcie kameleona.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/luQ5NgO.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: luQ5NgO.png]\' /><br />
					#79<br />
					<span style=\'font-weight: bold;\'>Oswald Beamish</span><br />
					1850-1932<br />
					Aktywista i polityk.<br />
					Był pionierem walki o prawa goblinów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/uYOaPBE.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: uYOaPBE.png]\' /><br />
					#80<br />
					<span style=\'font-weight: bold;\'>Beatrix Bloxam</span><br />
					1794-1910<br />
					Autorka \'Opowieści spod muchomora\',<br />
					zbioru bajek dla dzieci będącego kontrowersyjną adaptacją<br />
					tradycyjnych \'Baśni barda Beedle\'a\'.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/LUBKzPl.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: LUBKzPl.png]\' /><br />
					#81<br />
					<span style=\'font-weight: bold;\'>Quong Po</span><br />
					1443–1539<br />
					Chiński czarodziej i magizoolog, zajmował się smokami.<br />
					Odkrył zastosowanie sproszkowanych smoczych jaj.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/WUtBfC9.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: WUtBfC9.png]\' /><br />
					#82<br />
					<span style=\'font-weight: bold;\'>Rowena Ravenclaw</span><br />
					Średniowieczna czarownica, jedna ze współzałożycieli<br />
					Szkoły Magii i Czarodziejstwa w Hogwarcie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/iRLQe7E.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: iRLQe7E.png]\' /><br />
					#83<br />
					<span style=\'font-weight: bold;\'>Roderick Plumpton</span><br />
					1889~<br />
					Były szukający brytyjskiej drużyny narodowej Quidditcha.<br />
					Pobił światowy rekord w czasie łapania znicza - <br />
					zajęło mu to trzy i pół sekundy.</div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/SLv45A3.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: SLv45A3.png]\' /><br />
					#84<br />
					<span style=\'font-weight: bold;\'>Layton Aslan Lestrange</span><br />
					1900~<br />
					Znany lingwista magiczny, dyrektor Hogwartu.<br />
					Napisał między innymi podręcznik do starożytnych runów,<br />
					\'Tajemnice przeszłości\'.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/v54wBGq.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: v54wBGq.png]\' /><br />
					#85<br />
					<span style=\'font-weight: bold;\'>Frederick Crouch</span><br />
					1884~<br />
					Obecny Minister Magii Wielkiej Brytanii.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/Z02XKJb.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Z02XKJb.png]\' /><br />
					#86<br />
					<span style=\'font-weight: bold;\'>Dorcas Wellbeloved</span><br />
					1812-1904<br />
					Założyła charytatywną grupę wsparcia znaną jako<br />
					Stowarzyszenie Zagrożonych Czarownic.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/dTB1wNQ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: dTB1wNQ.png]\' /><br />
					#87<br />
					<span style=\'font-weight: bold;\'>Thaddeus Thurkell</span><br />
					1632-1692<br />
					Znany z tego, że począł siedmiu synów-charłaków<br />
					i z obrzydzenia transmutował ich wszystkich w jeże.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/oLQKBsG.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: oLQKBsG.png]\' /><br />
					#88<br />
					<span style=\'font-weight: bold;\'>Aldona Prewett</span><br />
					1886-1934<br />
					Aktywistka i polityk.<br />
					Założycielka Ruch Obrony Mugoli.<br />
					Zginęła podczas rozruchów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/vAYgxV6.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: vAYgxV6.png]\' /><br />
					#89<br />
					<span style=\'font-weight: bold;\'>Alberta Toothill</span><br />
					1391–1483<br />
					Czarownica-pojedynkowicz, członek Brytyjskiej Ligi Pojedynków.<br />
					Znana z wygranej w krajowym konkursie w 1430 roku, po pokonaniu Samsona Wiblina.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/y8qpQhW.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: y8qpQhW.png]\' /><br />
					#90<br />
					<span style=\'font-weight: bold;\'>Sacharissa Tugwood</span><br />
					1874~<br />
					Twórczyni eliksirów kosmetycznych.<br />
					Opracowała magiczne właściwości ropy z czyrakobulwy.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/9iydeax.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 9iydeax.png]\' /><br />
					#91<br />
					<span style=\'font-weight: bold;\'>Wilfred Elphick</span><br />
					1112–1199<br />
					Pierwszy czarodziej, który zginął<br />
					ugodzony przez afrykańskiego buchorożca.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/t8J87Kb.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: t8J87Kb.png]\' /><br />
					#92<br />
					<span style=\'font-weight: bold;\'>Xavier Rastrick</span><br />
					1750-1836<br />
					Czarodziej-animator, zniknął podczas jednego ze swoich<br />
					występów, stepując poprzez tłum w Painswick.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/sVJnLDn.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: sVJnLDn.png]\' /><br />
					#93<br />
					<span style=\'font-weight: bold;\'>Vaksilij Bułhakow</span><br />
					1895~<br />
					Czarodziej rosyjskiego pochodzenia,<br />
					wróżbita, numerolog, autor książek naukowych.<br />
					Były dyrektor Hogwartu.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/X335xY0.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: X335xY0.png]\' /><br />
					#94<br />
					<span style=\'font-weight: bold;\'>David McDonald</span><br />
					1887-1929<br />
					Mistrz eliksirów, autor między innymi<br />
					profesjonalnego podręcznika \'Receptury\'.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/F9386AB.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: F9386AB.png]\' /><br />
					#95<br />
					<span style=\'font-weight: bold;\'>Yardley Platt</span><br />
					1446-1557<br />
					Seryjny zabójca goblinów.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/SDDh3vq.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: SDDh3vq.png]\' /><br />
					#96<br />
					<span style=\'font-weight: bold;\'>Hengist z Woodcroft</span><br />
					Ucieczka przed mugolami zmusiła go do wyprowadzki do Szkocji,<br />
					gdzie założył magiczną wioskę Hogsmeade.<br />
					W jego domu założono później znaną tawernę Pod Trzema Miotłami.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/SLt4lva.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: SLt4lva.png]\' /><br />
					#97<br />
					<span style=\'font-weight: bold;\'>Alberic Grunnion</span><br />
					1803–1882<br />
					Dziewiętnastowieczny czarodziej, wynalazca, twórca łajnobomb. <br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/As44CE0.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: As44CE0.png]\' /><br />
					#98<br />
					<span style=\'font-weight: bold;\'>Dymphna Furmage</span><br />
					1612-1698<br />
					Uprowadzona przez chochliki podczas wakacji w Kornwalii.<br />
					Bezskutecznie próbowała przekonać Radę Magów<br />
					do usunięcia wszystkich chochlików z terenów Wielkiej Brytanii.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/7GCqAXq.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 7GCqAXq.png]\' /><br />
					#99<br />
					<span style=\'font-weight: bold;\'>Daisy Dodderidge</span><br />
					1467-1555<br />
					Pierwsza właścicielka tawerny Dziurawy Kocioł.<br />
					Uczęszczała do Szkoły Magii i Czarodziejstwa w Hogwarcie,<br />
					przydzielona do Gryffindoru.</div>",

					"<div style=\'text-align: center;\'><img src=\'http://i.imgur.com/l6nqAfx.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: l6nqAfx.png]\' /><br />
					#100<br />
					<span style=\'font-weight: bold;\'>Topidus Slughorn</span><br />
					1799-1901<br />
					Wynalazca, budowniczy, filantrop.<br />
					Ufundował nagrodę swojego imienia, którą<br />
					przyznawano co pięć lat aż do jego śmierci.</div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/LW1ap3Z.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: LW1ap3Z.png]\' /><br />
					#101<br />
					<span style=\'font-weight: bold;\'>Quentin Rowle</span><br />
					1902~<br />
					Twórca zaklęć, poeta, pojedynkowicz.<br />
					Założyciel Dżentelmeńskiego Klubu Pojedynkowego.<br />
					Uczęszczał do Szkoły Magii i Czarodziejstwa w Hogwarcie, przydzielony do Slytherinu.</div>"
					);

	return $cards[array_rand( $cards, 1 )];
}


		// Function for random bean flavour generator by Różowa Fasolka

function get_random_bean()
	{
			$bean = array(
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/4G9aCuF.png\' style=\'border: none; background: none;\'alt=\'[Obrazek: 4G9aCuF.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku migdałów.</span></div>",
				   
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/A7KzH2p.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: A7KzH2p.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku bakłażanów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/3CzOl1q.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 3CzOl1q.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku bekonu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/lGlZEKH.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: lGlZEKH.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku zielonej fasoli.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/TNnwc94.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: TNnwc94.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku bananów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZyLRDyT.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZyLRDyT.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku kłaczków z pępka.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZvOURoH.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZvOURoH.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku jeżyn.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/VHuy0IA.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: VHuy0IA.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku zapiekanki serowej.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/Vvx6zZv.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: Vvx6zZv.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku borówek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/A7KzH2p.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: A7KzH2p.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku ciasta jagodowego.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/A7KzH2p.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: A7KzH2p.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku goblinich stóp.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/qGjDMAO.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: qGjDMAO.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku bouillabaisse, zupy z owoców morza.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/rPDLlcY.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: rPDLlcY.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku brokułów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/Jwfhxvz.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: Jwfhxvz.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku gumy do żucia.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZyLRDyT.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZyLRDyT.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku popcornu z masłem.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZyLRDyT.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZyLRDyT.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku kalafiorów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/jvP1bSP.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: jvP1bSP.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku żółtego sera.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/3CzOl1q.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 3CzOl1q.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku wiśni.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/3CzOl1q.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 3CzOl1q.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku pieczonego kurczaka.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/7VfhwUn.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 7VfhwUn.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku sproszkowanego, ostrego chili.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/z3FBule.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: z3FBule.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku mlecznej czekolady.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/VHuy0IA.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: VHuy0IA.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku cynamonu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/SonNoNF.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: SonNoNF.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku wiórków kokosowych.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/z3FBule.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: z3FBule.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku mocnej kawy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/7VfhwUn.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 7VfhwUn.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku żurawiny.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/K94BKTD.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: K94BKTD.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku curry.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/MgJMsy2.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: MgJMsy2.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku brudu spod paznokci.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZvOURoH.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZvOURoH.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku brudnej skarpetki.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/SGAg5vU.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: SGAg5vU.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku jedzenia dla psów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/JP3a7e8.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: JP3a7e8.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku dżdżownicy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/7MY3pQE.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 7MY3pQE.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku wędzonej ryby.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ZvOURoH.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ZvOURoH.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku galaretki winogronowej.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/7MY3pQE.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 7MY3pQE.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku grejpfrutów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/bxJT3o4.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: bxJT3o4.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku trawy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/hg8lC0o.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: hg8lC0o.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku sosu pieczeniowego.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/L5sJ97w.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: L5sJ97w.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku zielonych jabłek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/9WLTYTb.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 9WLTYTb.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku szynki.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/oMZql8S.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: oMZql8S.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku miodu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/SonNoNF.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: SonNoNF.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku chrzanu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/seRBDjh.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: seRBDjh.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku ketchupu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/rugnGdG.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: rugnGdG.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku majonezu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/jvP1bSP.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: jvP1bSP.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku soku z cytryny.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/2OjUVzP.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 2OjUVzP.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku smażonej wątróbki.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/Cupd72T.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: Cupd72T.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku krewetek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ANJDtvf.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ANJDtvf.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku marmolady.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/9WLTYTb.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 9WLTYTb.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku pianek marshmallow.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/SGAg5vU.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: SGAg5vU.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku gotowanych ziemniaków.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/MgJMsy2.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: MgJMsy2.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku grzybów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/j2PRM4a.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: j2PRM4a.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku małżów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/oMZql8S.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: oMZql8S.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku musztardy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/L5sJ97w.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: L5sJ97w.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku czarnych oliwek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/4G9aCuF.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 4G9aCuF.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku cebuli.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/dHtVVh8.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: dHtVVh8.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku rozgotowanej kapusty.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/j2PRM4a.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: j2PRM4a.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku brzoskwini. </span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/bxJT3o4.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: bxJT3o4.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku gruszek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/Vvx6zZv.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: Vvx6zZv.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku pieprzu.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/zAwT5lE.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: zAwT5lE.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku mięty.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/lGlZEKH.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: lGlZEKH.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku flegmy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/JP3a7e8.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: JP3a7e8.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku ciasta dyniowego.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/jvP1bSP.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: jvP1bSP.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku zepsutego jaja.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/zyJOhzr.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: zyJOhzr.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku kiełbasy.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ANJDtvf.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: ANJDtvf.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku sherry.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/zAwT5lE.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: zAwT5lE.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku mydła.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/K94BKTD.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: K94BKTD.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku spaghetti.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/dHtVVh8.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: dHtVVh8.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku szpinaku.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/seRBDjh.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: seRBDjh.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku truskawek.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/zyJOhzr.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: zyJOhzr.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku toffie.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/seRBDjh.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: seRBDjh.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku pomidorów.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/2OjUVzP.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: 2OjUVzP.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku flaczków.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/rPDLlcY.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: rPDLlcY.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku smarków trolla.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/TNnwc94.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: TNnwc94.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku wymiocin.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/qGjDMAO.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: qGjDMAO.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku wieloowocowym.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/Vvx6zZv.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: Vvx6zZv.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku lukrecji.</span></div>",

					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/rugnGdG.png\' style=\'border:none; background: none;\'alt=\'[Obrazek: rugnGdG.png]\' /><br />
					<span style=\'font-weight: bold;\'>Fasolka o smaku sardynek.</span></div>"
					);

	return $bean[array_rand( $bean, 1 )];
}


		// Function for random direction generator by Różowa Fasolka
	
function get_random_direction()
	{
			$direction = array(
					"<center>[b]Północ[/b]</center>",
					"<center>[b]Południe[/b]</center>",
					"<center>[b]Wschód[/b]</center>",
					"<center>[b]Zachód[/b]</center>",
					"<center>[b]Północny-wschód[/b]</center>",
					"<center>[b]Północny-zachód[/b]</center>",
					"<center>[b]Południowy-wschód[/b]</center>",
					"<center>[b]Południowy-zachód[/b]</center>"
					);
	
	return $direction[array_rand( $direction, 1 )];
					}


		// Function for random fortune cookie generator by Różowa Fasolka
	
function get_random_cookie()
	{
			$cookie = array(
					"<div class=\'ciastko\'>Wystrzegaj się zwierząt, może Ci się przytrafić bardzo niemiła niespodzianka.</div>",
					"<div class=\'ciastko\'>To jest świetny czas na produktywność, jeżeli miałeś jakieś sprawy do załatwienia to może warto się za nie zabrać?</div>",
					"<div class=\'ciastko\'>Wystrzegaj się otwartych akwenów wodnych.</div>",
					"<div class=\'ciastko\'>Spróbuj zrobić coś miłego dla drugiego człowieka, a wszechświat ci się odpłaci.</div>",
					"<div class=\'ciastko\'>Uwaga, ktoś cię obserwuje!</div>",
					"<div class=\'ciastko\'>Czeka cię wielka przygoda.</div>",
					"<div class=\'ciastko\'>Tajemniczy wielbiciel da ci wkrótce jakiś znak.</div>",
					"<div class=\'ciastko\'>Odważ się być sobą, wyznaj swoje uczucia, wyjdzie ci to na dobre.</div>",
					"<div class=\'ciastko\'>Spotkasz przystojnego blondyna.</div>",
					"<div class=\'ciastko\'>Uśmiechnij się do nieznajomego, a zobaczysz co się stanie.</div>",
					"<div class=\'ciastko\'>Niebawem spotkasz swojego wroga.</div>",
					"<div class=\'ciastko\'>Niebawem spotkasz swoją bratnią duszę.</div>",
					"<div class=\'ciastko\'>Niebawem spotkasz osobę, z którą spędzisz resztę życia.</div>",
					"<div class=\'ciastko\'>Schowaj pieniądze w bezpieczne miejsce.</div>",
					"<div class=\'ciastko\'>Szykuje się powiększenie rodziny!</div>",
					"<div class=\'ciastko\'>Nie wychodź z domu w najbliższym czasie, a unikniesz kłopotów. </div>",
					"<div class=\'ciastko\'>Szczęście w pracy przyniesie ci złote pióro.</div>",
					"<div class=\'ciastko\'>Zobaczysz światełko na końcu tunelu.</div>",
					"<div class=\'ciastko\'>Nie chodź po Nokturnie bez jakiegoś towarzysza.</div>",
					"<div class=\'ciastko\'>Odnajdziesz satysfakcję z nauki w piątek wieczorem.</div>",
					"<div class=\'ciastko\'>Strzeż się Ministerstwa Magii.</div>",
					"<div class=\'ciastko\'>Sprawdź swoją różdżkę!</div>",
					"<div class=\'ciastko\'>Uważaj, ktoś próbuje dolać ci amortencji do napoju.</div>",
					"<div class=\'ciastko\'>Czekaj na właściwy znak.</div>",
					"<div class=\'ciastko\'>Coś się wydarzy, uważaj na siebie.</div>",
					"<div class=\'ciastko\'>Naucz się zaklęcia przeciwko upiorom, przyda się.</div>",
					"<div class=\'ciastko\'>Sprawdź swoje umiejętności w dziedzinie zaklęć obronnych.</div>",
					"<div class=\'ciastko\'>Jak zawsze masz rację.</div>",
					"<div class=\'ciastko\'>Najbliższe wieczory sprzyjają nawiązywaniu korzystnych znajomości.</div>",
					"<div class=\'ciastko\'>Podążaj za pająkami.</div>",
					"<div class=\'ciastko\'>Masz dużą szansę na podwyżkę, postaraj się w pracy!</div>"
					);
	
	return $cookie[array_rand( $cookie, 1 )];
					}


		// Function for random symbol by Różowa Fasolka

function get_random_symbol()
	{
			$symbol = array(
					"<center>[b]Aligator[/b]</center>",
					"<center>[b]Anioł[/b]</center>",
					"<center>[b]Arkada[/b]</center>",
					"<center>[b]Bagnet[/b]</center>",
					"<center>[b]Balon[/b]</center>",
					"<center>[b]Beczka[/b]</center>",
					"<center>[b]Bęben[/b]</center>",
					"<center>[b]Biurko[/b]</center>",
					"<center>[b]Biżuteria[/b]</center>",
					"<center>[b]Bluszcz[/b]</center>",
					"<center>[b]Błazen[/b]</center>",
					"<center>[b]Boja[/b]</center>",
					"<center>[b]Brama[/b]</center>",
					"<center>[b]Bransoleta[/b].",
					"<center>[b]Brzytwa[/b]</center>",
					"<center>[b]Budynek[/b]</center>",
					"<center>[b]Bukiet[/b]</center>",
					"<center>[b]Bumerang[/b]</center>",
					"<center>[b]But[/b]</center>",
					"<center>[b]Butelka[/b]</center>",
					"<center>[b]Byk[/b]</center>",
					"<center>[b]Cymbałki[/b]</center>",
					"<center>[b]Cygaro[/b]</center>",
					"<center>[b]Chleb[/b]</center>",
					"<center>[b]Chmury[/b]</center>",
					"<center>[b]Chorągiewka[/b]</center>",
					"<center>[b]Czajniczek[/b]</center>",
					"<center>[b]Czajnik[/b]</center>",
					"<center>[b]Czapka[/b]</center>",
					"<center>[b]Diabeł[/b]</center>",
					"<center>[b]Dom[/b]</center>",
					"<center>[b]Drabina[/b]</center>",
					"<center>[b]Drzewo[/b]</center>",
					"<center>[b]Dzban[/b]</center>",
					"<center>[b]Dzbanek[/b]</center>",
					"<center>[b]Dziadek[/b]</center>",
					"<center>[b]Działo[/b]</center>",
					"<center>[b]Dzwon[/b]</center>",
					"<center>[b]Fartuch",
					"<center>[b]Fasola[/b]</center>",
					"<center>[b]Filar[/b]</center>",
					"<center>[b]Filiżanka[/b]</center>",
					"<center>[b]Flaga[/b]</center>",
					"<center>[b]Fontanna[/b]</center>",
					"<center>[b]Gad[/b]</center>",
					"<center>[b]Garnek[/b]</center>",
					"<center>[b]Gęś[/b]</center>",
					"<center>[b]Girlandy[/b]</center>",
					"<center>[b]Gitara[/b]</center>",
					"<center>[b]Głowa[/b]</center>",
					"<center>[b]Gniazdo[/b]</center>",
					"<center>[b]Gołąb[/b]</center>",
					"<center>[b]Gondola[/b]</center>",
					"<center>[b]Góra[/b]</center>",
					"<center>[b]Grabie[/b]</center>",
					"<center>[b]Gramofon[/b]</center>",
					"<center>[b]Gruszka[/b]</center>",
					"<center>[b]Grzebień[/b]</center>",
					"<center>[b]Grzyb[/b]</center>",
					"<center>[b]Gwóźdź[/b]</center>",
					"<center>[b]Gwiazda[/b]</center>",
					"<center>[b]Igła[/b]</center>",
					"<center>[b]Iglica[/b]</center>",
					"<center>[b]Infuła[/b]</center>",
					"<center>[b]Insekt[/b]</center>",
					"<center>[b]Jabłko[/b]</center>",
					"<center>[b]Jajko[/b]</center>",
					"<center>[b]Jaskółka[/b]</center>",
					"<center>[b]Jastrząb[/b]</center>",
					"<center>[b]Jednorożec[/b]</center>",
					"<center>[b]Jeleń[/b]</center>",
					"<center>[b]Jeździec[/b]</center>",
					"<center>[b]Jodła[/b]</center>",
					"<center>[b]Kaczka[/b]</center>",
					"<center>[b]Kałamarz[/b]</center>",
					"<center>[b]Kangur[/b]</center>",
					"<center>[b]Kapelusz[/b]</center>",
					"<center>[b]Kapusta[/b]</center>",
					"<center>[b]Katarynka[/b]</center>",
					"<center>[b]Kieliszek[/b]</center>",
					"<center>[b]Klatka[/b]</center>",
					"<center>[b]Klepsydra[/b]</center>",
					"<center>[b]Klucz[/b]</center>",
					"<center>[b]Kobieta[/b]</center>",
					"<center>[b]Kolczyk[/b]</center>",
					"<center>[b]Kolumna[/b]</center>",
					"<center>[b]Koło[/b]</center>",
					"<center>[b]Kometa[/b]</center>",
					"<center>[b]Komin[/b]</center>",
					"<center>[b]Kominek[/b]</center>",
					"<center>[b]Kompas[/b]</center>",
					"<center>[b]Koniczyna[/b]</center>",
					"<center>[b]Koń[/b]</center>",
					"<center>[b]Koperta[/b]</center>",
					"<center>[b]Korona[/b]</center>",
					"<center>[b]Kosa[/b]</center>",
					"<center>[b]Kot[/b]</center>",
					"<center>[b]Kotwica[/b]</center>",
					"<center>[b]Kowadło[/b]</center>",
					"<center>[b]Koza[/b]</center>",
					"<center>[b]Krab[/b]</center>",
					"<center>[b]Krowa[/b]</center>",
					"<center>[b]Król[/b]</center>",
					"<center>[b]Kruk[/b]</center>",
					"<center>[b]Krzesło[/b]</center>",
					"<center>[b]Krzyż[/b]</center>",
					"<center>[b]Książka[/b]</center>",
					"<center>[b]Kufer[/b]</center>",
					"<center>[b]Księżyc[/b]</center>",
					"<center>[b]Kura[/b]</center>",
					"<center>[b]Kwiat[/b]</center>",
					"<center>[b]Lampa[/b]</center>",
					"<center>[b]Laska[/b]</center>",
					"<center>[b]Latawiec[/b]</center>",
					"<center>[b]Latarka[/b]</center>",
					"<center>[b]Latarnia[/b]</center>",
					"<center>[b]Lew[/b]</center>",
					"<center>[b]Lis[/b]</center>",
					"<center>[b]Liść[/b]</center>",
					"<center>[b]Lornetka[/b]</center>",
					"<center>[b]Łańcuszek[/b]</center>",
					"<center>[b]Łabędź[/b]</center>",
					"<center>[b]Łopata[/b]</center>",
					"<center>[b]Łódka[/b]</center>",
					"<center>[b]Łuk[/b]</center>",
					"<center>[b]Łyżka[/b]</center>",
					"<center>[b]Małpa[/b]</center>",
					"<center>[b]Maska[/b]</center>",
					"<center>[b]Medal[/b]</center>",
					"<center>[b]Mężczyzna[/b]</center>",
					"<center>[b]Miecz[/b]</center>",
					"<center>[b]Miotła[/b]</center>",
					"<center>[b]Miska[/b]</center>",
					"<center>[b]Młotek[/b]</center>",
					"<center>[b]Moneta[/b]</center>",
					"<center>[b]Most[/b]</center>",
					"<center>[b]Motyka[/b]</center>",
					"<center>[b]Motyl[/b]</center>",
					"<center>[b]Mrówka[/b]</center>",
					"<center>[b]Mucha[/b]</center>",
					"<center>[b]Muszla[/b]</center>",
					"<center>[b]Namiot[/b]</center>",
					"<center>[b]Naparstek[/b]</center>",
					"<center>[b]Niemowlę[/b]</center>",
					"<center>[b]Nietoperz[/b]</center>",
					"<center>[b]Nożyczki[/b]</center>",
					"<center>[b]Nóż[/b]</center>",
					"<center>[b]Obroża[/b]</center>",
					"<center>[b]Okno[/b]</center>",
					"<center>[b]Okrąg[/b]</center>",
					"<center>[b]Orzeł[/b]</center>",
					"<center>[b]Osa[/b]</center>",
					"<center>[b]Ostryga[/b]</center>",
					"<center>[b]Ośmiornica[/b]</center>",
					"<center>[b]Owca[/b]</center>",
					"<center>[b]Paczka[/b]</center>",
					"<center>[b]Pająk[/b]</center>",
					"<center>[b]Palma[/b]</center>",
					"<center>[b]Pantofel[/b]</center>",
					"<center>[b]Paproć[/b]</center>",
					"<center>[b]Papuga[/b]</center>",
					"<center>[b]Parasol[/b]</center>",
					"<center>[b]Paw[/b]</center>",
					"<center>[b]Pielęgniarka[/b]</center>",
					"<center>[b]Pierścionek[/b]</center>",
					"<center>[b]Pies[/b]</center>",
					"<center>[b]Pięść[/b]</center>",
					"<center>[b]Piłka[/b]</center>",
					"<center>[b]Piórko[/b]</center>",
					"<center>[b]Piramida[/b]</center>",
					"<center>[b]Pistolet[/b]</center>",
					"<center>[b]Płot[/b]</center>",
					"<center>[b]Podkowa[/b]</center>",
					"<center>[b]Policjant[/b]</center>",
					"<center>[b]Pompa[/b]</center>",
					"<center>[b]Portmonetka[/b]</center>",
					"<center>[b]Powóz[/b]</center>",
					"<center>[b]Profil[/b]</center>",
					"<center>[b]Ptak[/b]</center>",
					"<center>[b]Pudełko[/b]</center>",
					"<center>[b]Ręka[/b]</center>",
					"<center>[b]Rękawiczka[/b]</center>",
					"<center>[b]Rondel[/b]</center>",
					"<center>[b]Ropucha[/b]</center>",
					"<center>[b]Róg[/b]</center>",
					"<center>[b]Róża[/b]</center>",
					"<center>[b]Rura[/b]</center>",
					"<center>[b]Schody[/b]</center>",
					"<center>[b]Serce[/b]</center>",
					"<center>[b]Sęp[/b]</center>",
					"<center>[b]Siekiera[/b]</center>",
					"<center>[b]Sierp księżyca[/b]</center>",
					"<center>[b]Skrzydła[/b]</center>",
					"<center>[b]Skrzypce[/b]</center>",
					"<center>[b]Słoń[/b]</center>",
					"<center>[b]Słońce[/b]</center>",
					"<center>[b]Smok[/b]</center>",
					"<center>[b]Sowa[/b]</center>",
					"<center>[b]Statek[/b]</center>",
					"<center>[b]Stokrotka[/b]</center>",
					"<center>[b]Stopy[/b]</center>",
					"<center>[b]Stół[/b]</center>",
					"<center>[b]Strzała[/b]</center>",
					"<center>[b]Strzelba[/b]</center>",
					"<center>[b]Szkielet[/b]</center>",
					"<center>[b]Szklanka[/b]</center>",
					"<center>[b]Sztaluga[/b]</center>",
					"<center>[b]Sztylet[/b]</center>",
					"<center>[b]Szubienica[/b]</center>",
					"<center>[b]Śmietniczka[/b]</center>",
					"<center>[b]Świeca[/b]</center>",
					"<center>[b]Świnia[/b]</center>",
					"<center>[b]Taczki[/b]</center>",
					"<center>[b]Talerz[/b]</center>",
					"<center>[b]Tancerka[/b]</center>",
					"<center>[b]Torba[/b]</center>",
					"<center>[b]Tory[/b]</center>",
					"<center>[b]Trójkąt[/b]</center>",
					"<center>[b]Trójząb[/b]</center>",
					"<center>[b]Trumna[/b]</center>",
					"<center>[b]Ucho[/b]</center>",
					"<center>[b]Ul[/b]</center>",
					"<center>[b]Urna[/b]</center>",
					"<center>[b]Wachlarz[/b]</center>",
					"<center>[b]Waga[/b]</center>",
					"<center>[b]Wagon towarowy[/b]</center>",
					"<center>[b]Wanna[/b]</center>",
					"<center>[b]Wazon[/b]</center>",
					"<center>[b]Wąż[/b]</center>",
					"<center>[b]Wiatrak[/b]</center>",
					"<center>[b]Widelec[/b]</center>",
					"<center>[b]Wieloryb[/b]</center>",
					"<center>[b]Wielbłąd[/b]</center>",
					"<center>[b]Wieniec[/b]</center>",
					"<center>[b]Wieża[/b]</center>",
					"<center>[b]Wilk[/b]</center>",
					"<center>[b]Winogrona[/b]</center>",
					"<center>[b]Wiosło[/b]</center>",
					"<center>[b]Wodospad[/b]</center>",
					"<center>[b]Wóz[/b]</center>",
					"<center>[b]Wulkan[/b]</center>",
					"<center>[b]Zając[/b]</center>",
					"<center>[b]Zakonnica[/b]</center>",
					"<center>[b]Zamek[/b]</center>",
					"<center>[b]Zasłona[/b].",
					"<center>[b]Zebra[/b]</center>",
					"<center>[b]Zegar[/b]</center>",
					"<center>[b]Żaba[/b]</center>",
					"<center>[b]Żółw[/b]</center>",
					"<center>[b]Żuk[/b]</center>",
					"<center>[b]Ponurak[/b]</center>",
					"<center>[b]Żyrafa[/b]</center>"
					);

	return $symbol[array_rand( $symbol, 1 )];
					}


		// Function for random rune generator by Różowa Fasolka

function get_random_rune()
	{
			$rune = array(
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/FRY7xlX.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: FRY7xlX.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/uvHrTQk.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: uvHrTQk.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/e5fG7oN.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: e5fG7oN.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/GpHXk5K.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GpHXk5K.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/dfSIojg.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: dfSIojg.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/gTluofM.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: gTluofM.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/wBcVYYo.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: wBcVYYo.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/K400l98.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: K400l98.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/5aqHAQG.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 5aqHAQG.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/oJG8Nzq.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: oJG8Nzq.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/7bSc1Rv.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 7bSc1Rv.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/K6Auvzp.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: K6Auvzp.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/mN5J6vD.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: mN5J6vD.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/9l7CFAj.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 9l7CFAj.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/xMK4RkL.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: xMK4RkL.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/1mn1FzL.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 1mn1FzL.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/RgYrFrJ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: RgYrFrJ.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/eOTzTCd.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: eOTzTCd.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/BExvZuu.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: BExvZuu.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/2NhpyEy.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 2NhpyEy.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/LnSYI7c.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: LnSYI7c.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/a4Kfzth.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: a4Kfzth.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/s3qVnPp.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: s3qVnPp.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/uVtUOP2.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: uVtUOP2.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/sM5U2aZ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: sM5U2aZ.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/itGw0VZ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: itGw0VZ.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/1PV0I8X.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 1PV0I8X.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/BwBBDiS.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: BwBBDiS.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/zlqrCo4.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: zlqrCo4.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/47WvBco.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: 47WvBco.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/WaIlY6h.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: WaIlY6h.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/wOBIy60.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: wOBIy60.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/s1uM7mZ.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: s1uM7mZ.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/s9eyMOi.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: s9eyMOi.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/ADP5rB8.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: ADP5rB8.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/GZ4exYC.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: GZ4exYC.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/KPryaH1.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: KPryaH1.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/DBnHpHv.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: DBnHpHv.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/qlXBX9V.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: qlXBX9V.png]\' /></div>",
							
					"<div style=\'text-align: center;\'><img src=\'https://i.imgur.com/RH0pzFl.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: RH0pzFl.png]\' /></div>"
					);

	return $rune[array_rand( $rune, 1 )];
					}


		// Function for random exploding card generator by Różowa Fasolka
			
function get_random_explode()
	{
			$explode = array(
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/XMaKH8e.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: XMaKH8e.png]\' /></span>",
				
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/Hq1Bwrv.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: Hq1Bwrv.png]\' /></span>",
				
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/OPG9BSN.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: OPG9BSN.png]\' /></span>",
				
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/NpKDVtw.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: NpKDVtw.png]\' /></span>",
				
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/zj5Gb90.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: zj5Gb90.png]\' /></span>",
				
					"<span style=\'text-align: center;\'><img src=\'https://i.imgur.com/cnvU9sX.png\' style=\'border:none; background: none;\' alt=\'[Obrazek: cnvU9sX.png]\' /></span>"
					);

	return $explode[array_rand( $explode, 1 )].$explode[array_rand( $explode, 1 )].$explode[array_rand( $explode, 1 )];
                    }
                    
            
                    
        // Function for random board generator by Zielona Fasolka & Różowa Fasolka

function get_random_board()
    {
        $amountOfStrings = 20; //amount of strings you want to randomly draw
        $strings = array(
                        ". Zastanawiałeś się kiedyś, czy nadajesz się na poetę? Do końca gry wszystkie zdania, które wypowiadasz rymują się. Nie kontrolujesz tego - jeśli nie grasz jak ci gumochłony zagrają, twóje usta po prostu wyrzucają z siebie pierwsze lepsze rymujące się słowa. <br/><br/>",

                        ". Mokre pole! Wylewa się na ciebie wiadro wody! <br/><br/>",

                        ". Klątwa Galopującego Gumochłona została rzucona! Twój gumochłon nagle zaczyna uciekać z planszy! Musisz go złapać, a kiedy w końcu ci się to udaje pionek nie dość, że pluje a ciebie jakimś dziwnie pachnącym śluzem, to jeszcze nie chce wrócić na swoje miejsce i upiera się, że cofnie się na start (wróć na pole START). <br/><br/>",

                        ". Tracisz głos! Do końca gry nie jesteś w stanie wydusić z siebie ani słowa. <br/><br/>",

                        ". Twój gumochłon zaczyna podskakiwać i ty także odczuwasz wielką chęć poskakania na jednej nodze. Do końca gry kicasz po swojej stronie planszy, ale za to twój gumochłon także skacze dwa pola do przodu (następną kolejkę zacznij z pola dalszego o dwa kroki, nie stosując się do efektu z tego pola). <br/><br/>",

                        ". Czyżbyś zjadł za dużo? Po stanięciu na to pole, twój gumochłon się kurczy o kilka rozmiarów - tak samo jak twoje ubrania, które stały się nieprzyjemnie małe. Jeżeli spróbujesz się rozebrać, dowiesz się, że w magiczny sposób przylgnęły do twojej skóry i nie jesteś w stanie tego zrobić. <br/><br/>",

                        ". Obrastasz futerkiem/łuskami/piórami i przybierasz formę hybrydy pierwszego zwierzęcia o jakim pomyślałeś. <br/><br/>",

                        ". Chyba zdenerwowałeś grę! Gumochłony uciekają z planszy, która zaczyna cię mocno uderzać w głowę. Jeżeli zaczniesz uciekać - podąży ona za tobą. Uspokaja się dopiero po chwili, kiedy na głowie pojawi się dorodny siniak. Kiedy to nastąpi, wszystko wraca do normy i gra może być kontynuowana. <br/><br/>",

                        ". Czy ci się wydaje, czy zrobiło się naraz strasznie gorąco? Z twoich uszu bucha para, a ty zaczynasz pogwizdywać jak imbryk od czasu do czasu! <br/><br/>",

                        ". Różowe pole! Sprawia, że czujesz się jak pod wpływem amortencji. Do końca gry <i>kochasz</i> swojego przeciwnika! Jeżeli gra was więcej, to <i>kochasz</i> osobę, która poruszyła się bezpośrednio przed tobą. <br/><br/>",

                        ". Twoja skóra, włosy i ubranie przybierają nowy odcień. Jeżeli wyrzuciłeś tę kostkę w: poniedziałek - są niebieskie; wtorek - czerwone; środę - zielone; czwartek - żółte; piątek - różowe; sobotę - fioletowe; a niedzielę - pomarańczowe. <br/><br/>",

                        ". Od teraz do końca gry, za każdym razem gdy powiesz jakieś kłamstwo, twój nos zaczyna rosnąć. <br/><br/>",

                        ". Czujesz nagły chłod? Twoje ubrania nagle znikają, a ty zostajesz w samej bieliźnie, podkoszulku i skarpetach! Ubrania pojawiają się znowu, kiedy gra się kończy. Jeżeli w grę grają osoby niepełnoletnie, gra cenzuruje to pole, zamieniając ubrania na piżamy. <br/><br/>",

                        ". Do końca gry cały czas chichoczesz i zacierasz ręcę, jakbyś planował zawładnąć światem. <br/><br/>",

                        ". Nagle wszelkie włosy na twoim ciele znikają. <br/><br/>",

                        ". Matka Natura się o ciebie upomniała! Twoje włosy zamieniają się w trawę, ubrania w kwiatki, a ciało obrasta korą. <br/><br/>",

                        ". Gra wiąże grubym sznurem twoje ręce, razem z rękoma osoby, z którą grasz tak, że trzymacie się za ręce. Jeżeli gracie w więcej niż dwie osoby, wiąże twoje ręce z kimś, kto poruszał się dwie kolejki przed tobą. <br/><br/>",

                        ". Na środku pokoju pojawia się szafa, z której wychodzi to, czego się najbardziej boisz. Magiczny bogin znika jednak sam z siebie, kiedy już porządnie cię nastraszy. <br/><br/>",

                        ". Czas pokazać swój anty-talent! Zaczynasz stepować lub jodłować, w zależności od tego w czym czujesz się gorzej! <br/><br/>",

                        ". Twój gumochłon zaczyna fiksować! Jeżeli w następnej kolejce wyrzucisz na kostce nieparzysty wynik, twój pionek zamiast przesunąć się o tyle pól do przodu, zacznie skakać do tyłu, oddalając cię od zwycięstwa! Efekt trwa do wyrzucenia parzystego wyniku na kości. <br/><br/>",

                        ". To jeszcze nie koniec! Zaczynasz odczuwać nienaturalnie silną potrzebę wygrania za wszelką cenę, przy okazji dostając też zastrzyk pewności siebie - oczywiście, że wygrasz! Kto inny miałby? <br/><br/>"
                    );
                
        $numbers = range(0, count($strings) - 1); //array of numbers from 0 to amount of strings you want to draw
        shuffle($numbers); //randomly shuffles the array
        
        $board = '';
                    
        for ($i = 0; $i < $amountOfStrings; $i++) //iterates over array of shuffled numbers, but only up to $amountOfStrings (as $numbers contains all numbers up to $strings length, so we have to stop it earlier)
            { 
                $string = $strings[$numbers[$i]]; //getting randomly generated string
                $stringNumber = $i + 1; //getting number of a string. +1 because it starts at 0
                
                $board = $board.$stringNumber.$string;
            }
        
        return $board;
    }
                    
            
                    
	// Function for magic jenga game generator by Różowa Fasolka

function get_jenga_effect()
	{
		$k6 = array(
					"<center><b>Kość:</b> 1<br/></center>",
					"<center><b>Kość:</b> 2<br/></center>",
					"<center><b>Kość:</b> 3<br/></center>",
					"<center><b>Kość:</b> 4<br/></center>",
					"<center><b>Kość:</b> 5<br/></center>",
					"<center><b>Kość:</b> 6<br/></center>"
				);

		$effect = array(
					"<b>Efekt:</b> Wieża zmieniła kolor! Osoba wyciągająca kolejny klocek decyduje, na jaki.",
					"<b>Efekt:</b> Wyciągnięte klocki zaczynają unosić się w powietrzu, a chwilę później śmigają już wokół grających jak wyjątkowo natrętne muchy!",
					"<b>Efekt:</b> Wieża zaczęła lewitować kilka centymetrów nad stołem, co zwykle trwa chwilę lub dwie. Powodzenia z wyciąganiem następnych klocków!",
					"<b>Efekt:</b> Wieża zakołysała się gwałtownie! Przewróci się, czy się nie przewróci?! Póki co stoi, ale nie warto jej ufać!",
					"<b>Efekt:</b> Wieża wygląda podejrzanie stabilnie... Masz przeczucie, że kolejny ruch nie skończy się dobrze!",
					"<b>Efekt:</b> Czy ktoś właśnie trącił wieżę?! Kto to był, przyznawać się! Jesteś pewien, że tym razem nie zakołysała się sama z siebie!",
					"<b>Efekt:</b> Jeden z klocków zaczyna samodzielnie wysuwać się ze struktury... Pomożesz mu, czy udasz, że nie widzisz?",
					"<b>Efekt:</b> Losowe klocki wewnątrz struktury zaczynają podświetlać się i gasnąć jak lampki na yule'owej choince! Nie trwa to długo, ale potrafi nieźle rozproszyć!",
					"<b>Efekt:</b> Wieża obraca się! Teraz góra jest dołem, a dół górą! Miałeś upatrzony klocek, który wyciągniesz? To już twój problem.",
					"<b>Efekt:</b> Wieża podskakuje w miejscu, a kilka klocków wewnątrz struktury zmienia swoje położenie."
				);
		

		$dice = $k6[array_rand( $k6, 1 )];
		$task = $effect[array_rand( $effect, 1 )];

		if ($dice == "<center><b>Kość:</b> 1<br/></center>")
		{
			$task = "<b>Efekt:</b> Nie, tylko nie ten klocek! Wieża rozsypuje się z hukiem, strzelając drewienkami na wszystkie strony!";
		} 
		
		else if ($dice == "<center><b>Kość:</b> 2<br/></center>")
		{
			$task = "<b>Efekt:</b> To był ryzykowny manewr! Wieża chwieje się niepokojąco... Kolejny wyciągający rozbija wieżę, jeśli wyrzuci 1 lub 2 na kości! Wszystkie pozostałe efekty działają jak dotychczas.";
		} 
		
		else if ($dice == "<center><b>Kość:</b> 6<br/></center>")
		{
			$task = "<b>Efekt:</b> Kto by pomyślał, że mniej klocków może POMÓC ze stabilizacją wieży? Nic się nie dzieje, jeśli kolejny wyciągający wyrzuci 1 na kości. Wszystkie pozostałe efekty działają jak dotychczas!";
		} 
		
		else { $task; }

			
		$jenga = $dice.$task;

	return $jenga;

	}

?>