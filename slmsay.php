<?php

/*
	SLMSAY (php edition)
	copyright 2001-2014 @tarasyoung

	Features in this edition:
	- Single colour
	- Multicolour
	- Rainbow colours
	- Shadow (with variable distance)
	- 3D
	- Upside-down
	- Stretch width/height
	- IRC colour code output
	- HTML output
*/

/*
	DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
			Version 2, December 2004
		  Copyright (C) 2004 Sam Hocevar
	 14 rue de Plaisance, 75014 Paris, France

	Everyone is permitted to copy and distribute verbatim or modified
	copies of this license document, and changing it is allowed as long
	as the name is changed.

	DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

	0. You just DO WHAT THE FUCK YOU WANT TO.
*/

function slm($input)
{
	// This returns an array of lines with a built text banner
	// using . for 'transparent' blocks and letters for colour blocks (a=0, b=1, c=2 ...)

	global $multicolour, $rainbow, $shadow, $dimensions, $allcolours, $upsidedown;
	global $widthmult, $heightmult, $background, $foreground, $shadowdistance;
	global $colours, $shadows, $rainbowcolours, $brightcolours;

	$characters = array(
				" " => "......,......,......,......,......",
				"!" => "#,#,#,.,#",
				"\"" => "#..#,....,....,....,....",
				"#" => ".#..#.,######,.#..#.,######,.#..#.",
				"$" => ".#####,#.##..,.####.,..##.#,#####.",
				"%" => "#...#,...#.,..#..,.#...,#...#",
				"&" => ".###..,#...#.,.###..,#...##,.#####",
				"'" => "#,.,.,.,.",
				"(" => ".#,#.,#.,#.,.#",
				")" => "#.,.#,.#,.#,#.",
				"*" => "#.#.#,.###.,#####,.###.,#.#.#",
				"+" => "...,.#.,###,.#.,...",
				"," => "..,..,..,.#,#.",
				"-" => "....,....,####,....,....",
				"." => ".,.,.,.,#",
				"/" => "....#,...#.,..#..,.#...,#....",
				"0" => ".###.,##.##,##.##,##.##,.###.",
				"1" => ".##.,###.,.##.,.##.,####",
				"2" => ".####.,#...##,..###.,.##...,######",
				"3" => "#####.,...###,.####.,...###,#####.",
				"4" => "..###.,.#.##.,#..##.,######,...##.",
				"5" => "######,##....,#####.,....##,#####.",
				"6" => ".####.,##....,#####.,##..##,.####.",
				"7" => "######,....##,...##.,..##..,.##...",
				"8" => ".####.,##..##,.####.,##..##,.####.",
				"9" => ".####.,##..##,.#####,....##,.####.",
				":" => ".,#,.,#,.",
				";" => "..,.#,..,.#,#.",
				"<" => "..#,.#.,#..,.#.,..#",
				"=" => "....,####,....,####,....",
				">" => "#..,.#.,..#,.#.,#..",
				"?" => ".####.,#....#,..###.,......,..#...",
				"@" => ".#####,#.###.,#.#..#,#..#.#,.####.",
				"A" => ".####.,##..##,######,##..##,##..##",
				"B" => "#####.,##..##,#####.,##..##,#####.",
				"C" => ".#####,##....,##....,##....,.#####",
				"D" => "#####.,##..##,##..##,##..##,#####.",
				"E" => "######,##....,######,##....,######",
				"F" => "######,##....,######,##....,##....",
				"G" => ".#####,##....,##.###,##..##,.#####",
				"H" => "##..##,##..##,######,##..##,##..##",
				"I" => "######,..##..,..##..,..##..,######",
				"J" => ".######,...##..,...##..,##.##..,.###...",
				"K" => "##..##,##.##.,####..,##.##.,##..##",
				"L" => "##....,##....,##....,##....,######",
				"M" => "##....##,###..###,##.##.##,##....##,##....##",
				"N" => "###...##,####..##,##.##.##,##..####,##...###",
				"O" => ".#####.,##...##,##...##,##...##,.#####.",
				"P" => "#####.,##..##,#####.,##....,##....",
				"Q" => ".####.,##..##,##..##,##.###,.#####",
				"R" => "#####.,##..##,#####.,##..##,##..##",
				"S" => ".#####,##....,.####.,....##,#####.",
				"T" => "######,..##..,..##..,..##..,..##..",
				"U" => "##..##,##..##,##..##,##..##,.####.",
				"V" => "##....##,##....##,.##..##.,.##..##.,...##...",
				"W" => "##....##,##....##,##.##.##,###..###,##....##",
				"X" => "##...##,.##.##.,..###..,.##.##.,##...##",
				"Y" => "##..##,##..##,.####.,..##..,..##..",
				"Z" => "######,...##.,..##..,.##...,######",
				"[" => "##,#.,#.,#.,##",
				"\\" => "#....,.#...,..#..,...#.,....#",
				"]" => "##,.#,.#,.#,##",
				"^" => ".#.,#.#,...,...,...",
				"_" => "......,......,......,......,######",
				"`" => "#.,.#,..,..,..",
				"{" => "..#,.#.,##.,.#.,..#",
				"|" => "#,#,#,#,#",
				"}" => "#..,.#.,.##,.#.,#..",
				"~" => ".....,.#...,#.#.#,...#.,.....",
				"Â£" => "..###.,.#...#,####..,.#....,######",
				"Â¬" => "......,......,######,.....#,......"
			);


	foreach ( $characters as $key=>$value )
	{
		$charset[$key] = explode(",", $value);	// Split character into array
		if( count($charset[$key]) > $maxlines ) $maxlines = count($charset[$key]);	// Determine max height
	}

	$letters = str_split(strtoupper($input));	// explode input letters e.g. == array("H","E","L","L","O")
	$lastcolour = 0; $bow = 0;	// init some variables
	if ( $shadow ) $maxlines+=$shadowdistance;	 // shadow requires additional lines

	// cycle through our input string and add each letter
	foreach ( $letters as $letter )
	{
		if ( $multicolour )
		{
			// pick a random colour from colours which is different to the last one
			$colour = newcolour($lastcolour);
			$lastcolour = $colour;
		}

		if ( $rainbow )
		{
			// cycle through rainbow colours
			$colour = $rainbowcolours[$bow];
			$bow++;
			if ( $bow >= count($rainbowcolours)  ) $bow = 0;
		}

		if ( !$multicolour && !$rainbow )
		{
			$colour = $foreground;
		}

		// build the letters up:
		for ( $n=0; $n < $maxlines; $n++ )
		{
			if ( $n < count($charset[$letter]) )
			{
				// add part of letter to total
				$letterline = $charset[$letter][$n];	// current line of current letter e.g. == "##..##"
				$letterline = str_replace("#", chr($colour + 97), $letterline); // apply random colour
				$total[$n] = $total[$n] . $letterline . ".";

			} else {

				// we're beyond height of this letter, so add a blank part
				$total[$n] = $total[$n] . str_repeat(".", strlen($charset[$letter][0])+1);

			}
		}
	}

	if ( !$shadow ) for ( $n=0; $n < count($total); $n++ ) $total[$n] = substr($total[$n], 0, -1);	// trim last 'space' from end of each line

	if ( $dimensions > 2 ) $total = add_3d($total);
	if ( $shadow ) $total = add_shadow($total);
	if ( $upsidedown ) $total = flip_it($total);

	$total = stretch_it($total, $widthmult, $heightmult);

	return $total;

}


function newcolour($oldcolour)
{
	// returns a new colour which isn't $oldcolour

	global $brightcolours, $allcolours;

	$colour = $oldcolour;
	while ( $colour == $oldcolour )
	{
		$colour = ( $allcolours )? rand(0,13) : $brightcolours[rand(0,count($brightcolours)-1)];
	}

	return $colour;

}


function add_shadow($input_array)
{
	// adds shadow to anything
	global $colours, $shadows, $rainbowcolours, $brightcolours, $background, $shadowdistance;

	// add enough space for the shadow to be cast into
	for ( $y=0; $y < count($input_array); $y++ ) $input_array[$y] = $input_array[$y] . str_repeat(".", $shadowdistance);

	for ( $y=0; $y < count($input_array); $y++ )
	{
		$current[$y] = str_split($input_array[$y]);
		$new[$y] = str_split($input_array[$y]);
	}

	for ( $y=0; $y < count($current); $y++ )
	{

		for ( $x=0; $x < count($current[$y]); $x++ )
		{
			if ( $current[$y][$x] != "." )
			{
				if ( $new[$y + $shadowdistance][$x + $shadowdistance] == "." )
				{
					$thiscolour = ord($current[$y][$x]) - 97;
					$new[$y + $shadowdistance][$x + $shadowdistance] = chr($shadows[$thiscolour]+97);
				}
			}
		}

	}


	for ( $n=0; $n < count($new); $n++ ) $output[$n] = implode($new[$n]); // collapse arrays back into strings
	return $output;

}


function add_3d($input_array)
{
	global $colours, $shadows, $rainbowcolours, $brightcolours;


	for ( $y=0; $y < count($input_array); $y++ )
	{
		// add padding to the right of the banner - this simplifies end-of-line detection
		$input_array[$y] = $input_array[$y] . ".";

		// split lines into colour blocks
		$chars[$y] = str_split($input_array[$y]);
	}

	for ( $y=0; $y < count($input_array); $y++ )
	{

		$flag = 0; $colour = 0; $length = 0;

		for ( $x=0; $x < count($chars[$y]); $x++ )
		{
			$thiscolour = ord($chars[$y][$x]) - 97;

			if ( $thiscolour == $colour || $colour == -1 )
			{
				$colour = $thiscolour;
				$length++;

			} else {

				// change colours of second half of stretch of blocks to shadow
				if ( $length > 0 )
				{
					$length++;	// it needs this, haven't figured out why
					$start = $x - intval($length / 2);
					for ( $z=$start; $z < ($x); $z++ ) $chars[$y][$z] = chr($shadows[$colour]+97);
				}

				// set variables
				if ( $thiscolour >= 0 )
				{
					$flag = 1; $length = 0;
					$colour = $thiscolour;
				} else {
					$flag = 0; $length = 0;
				}
			}
		}

		$total[$y] = implode($chars[$y]);
	}

	// trim additional block from end of banner
	for ( $y=0; $y < count($total); $y++ ) $total[$y] = substr($total[$y], 0, -1);


	return $total;

}

function flip_it($input_array)
{
	// flips a banner vertically and horizontally
	foreach ( array_reverse($input_array) as $line ) $total[] = strrev($line);
	return $total;
}

function stretch_it($input_array, $width, $height)
{

	// stretches a banner using integer multipliers

	if ( $width < 1 ) { $width = 1; }		// avoid width < 1
	if ( $height < 1 ) { $height = 1; }	// avoid hegiht < 1

	foreach ( $input_array as $line )
	{
		$line = preg_replace('/./', str_repeat("\$0", $width), $line);	// stretch width
		for ( $n=1; $n <= $height; $n++ ) $total[] = $line;			// stretch height
	}

	return $total;
}




function convert_irc($input_array)
{
	// converts a built text banner into irc code
	// do   echo convert_irc(slm("my text"));

	global $background;

	for ( $n=0; $n < count($input_array); $n++ )
	{
		$chars = str_split($input_array[$n]);
		for ( $i=0; $i < count($chars); $i++ )
		{
			$thiscolour = ord($chars[$i]) - 97;
			if ( $thiscolour == -51 ) $thiscolour = $background;	// background = black
			$chars[$i] = chr(3) . strval($thiscolour) . "," . strval($thiscolour) . "#";
		}
		$total[$n] = implode($chars);
	}

	return $total;
}

function convert_html($input_array)
{
	// converts a built text banner into html
	// do   echo convert_html(slm("my text"));

	global $background;

	$colourshex = array("#fff","#000","#008","#080","#f00","#800","#808","#fc0","#ff0","#0f0","#088","#0ff","#00f","#f0f","#888","#ccc");

	for ( $n=0; $n < count($input_array); $n++ )
	{
		$chars = str_split($input_array[$n]);
		for ( $i=0; $i < count($chars); $i++ )
		{
			$thiscolour = ord($chars[$i]) - 97;
			if ( $thiscolour == -51 ) $thiscolour = $background;	// background = black
			$total[$n] = $total[$n] . "<span style=\"color:" . $colourshex[$thiscolour] . "\">&#9608;</span>";
		}
	}

	return $total;
}

function slm_init()
{

	// Sets up variables to produce a standard text banner

	global $colours, $shadows, $rainbowcolours, $brightcolours;
	global $background, $foreground, $allcolours, $multicolour;
	global $rainbow, $shadow, $dimensions, $upsidedown;
	global $widthmult, $heightmult, $shadowdistance;

	$colours = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);	// standard colours
	$shadows = array(15,1,1,1,5,1,1,14,7,3,2,10,2,6,1,14);		// shadow colours (for dark backgrounds)
	$rainbowcolours = array(4,7,8,9,11,12,13);				// rainbow colour cycle
	$brightcolours = array(4,8,9,11,13);					// bright colours

	$background = 1;		// background colour (1=black)
	$foreground = 0;		// default foreground colour (0=white)
	$allcolours = 0;		// whether to use all colours or only bright ones
	$multicolour = 1;		// whether to use colours at all
	$rainbow = 0;			// use rainbow colours
	$shadow = 0;			// add shadow
	$shadowdistance = 1;	// distance of shadow
	$dimensions = 2;		// add 3D effect if set to 3
	$upsidedown = 0;		// flip it!
	$widthmult = 1;		// width multiplier
	$heightmult = 1;		// height multiplier
}


/* Demo code below this point */

slm_init();
$slm = slm("SLM");
foreach ( convert_html($slm) as $line )
{
	echo "<div>$line</div>\n";
}
