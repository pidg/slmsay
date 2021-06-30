<?php

/*
	slmsay (PHP edition)
	Advanced IRC Banner Tool

	Copyright 2001-2021 Taras Young (@pidg)

	20th Anniversary Edition

	Now with:

	 - Mono colour
	 - Multicolour
	 - Rainbow colour palette
	 - Grey colour palette
	 - Shadow (with variable shadow size)
	 - 3D effect
	 - Flip upside-down
	 - Width/height multipliers
	 - IRC colour code output
	 - HTML output

	Usage:
	 
	 // Convert input text to SLM code:
	 $slm_code = slm("input text");

	 // Apply any effects:
	 $slm_code = add_shadow($slm_code);
	 $slm_code = add_3d($slm_code);
	 $slm_code = flip_it($slm_code);
	 $slm_code = stretch_it($slm_code, 2, 2);

	 // Export to IRC or HTML code:
	 $irc_export  = convert_irc($slm_code);
	 $html_export = convert_html($slm_code);

	Licence:

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

	Happy bannering!
*/

function slm($input)
{
	/* 
		This returns an array of lines with a built text banner which uses "."
		 for 'transparent' blocks, and letters for coloured blocks (a=0, b=1, c=2 ...)
		 The output from this function can then be fed to another function for
		 conversion to IRC character codes, or conversion to HTML, etc.
	*/

	global $multicolour, $rainbow, $shadow, $dimensions, $allcolours, $upsidedown;
	global $widthmult, $heightmult, $background, $foreground, $greys, $greycolours;
	global $colours, $shadows, $shadowwidth, $brightcolours, $rainbowcolours;

	// Define character set:

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
				"£" => "..###.,.#...#,####..,.#....,######",
				"¬" => "......,......,######,.....#,......"
			);


	// Load the above charset into a 2D array:
	$maxlines=0;
	foreach ( $characters as $key=>$value )
	{
		// Split character into second dimension by comma:
		$charset[$key] = explode(",", $value);

		// Update maximum possible height of this charset:
		if( count($charset[$key]) > $maxlines ) $maxlines = count($charset[$key]);
	}


	// Place input characters into an array e.g. == array("H","E","L","L","O"):
	$letters = str_split(strtoupper($input));

	// If there's a shadow it will require additional rows:
	if ( $shadow ) $maxlines += $shadowwidth;

	// Init some colour-related variables:
	$lastcolour = 0; $bow = 0; $grey = 0;

	// Cycle through our input string and add each letter:
	foreach ( $letters as $letter )
	{

		// ------------ Begin colour selection ------------ //

		if ( $multicolour )
		{
			// Pick a random colour from colours which is different to the last one
			$colour = newcolour($lastcolour);
			$lastcolour = $colour;
		}

		if ( $rainbow )
		{
			// Cycle through rainbow colours
			$colour = $rainbowcolours[$bow];
			$bow++;
			if ( $bow >= count($rainbowcolours)  ) $bow = 0;
		}

		if ( $greys )
		{
			// Cycle through grey colours
			$colour = $greycolours[$grey];
			$grey++;
			if ( $colour == 0 && $background == 0 ) $colour = 1;	// If bg && colour are white use black instead
			if ( $grey >= count($greycolours)  ) $grey = 0;
		}

		if ( !$multicolour && !$rainbow && !$greys )
		{
			// Use a single foreground colour
			$colour = $foreground;
		}

		// ------------ End of colour selection ------------ //


		// Build up the letters:
		for ( $n=0; $n < $maxlines; $n++ )
		{
			if ( $n < count($charset[$letter]) )
			{
				// Add part of letter to total
				
				// Current row of current character e.g."##..##"
				$letterline = $charset[$letter][$n];

				// Apply selected colour:
				$letterline = str_replace("#", chr($colour + 97), $letterline);

				if ( !isset($total[$n]) ) $total[$n] = "";	// Prevent 'unset' notices
				$total[$n] = $total[$n] . $letterline . ".";	// Add to total


			} else {

				// We're beyond the height of this character, so add a blank part:
				if ( !isset($total[$n]) ) $total[$n] = "";	// Prevent 'unset' notices
				
				// Add blank space to match width of current character:
				$total[$n] = $total[$n] . str_repeat(".", strlen($charset[$letter][0])+1);

			}
		}
	}

	// Trim last 'space' from each line:
	if ( !$shadow ) for ( $n=0; $n < count($total); $n++ ) $total[$n] = substr($total[$n], 0, -1);
	
	if ( $dimensions > 2 ) $total = add_3d($total);			// Add 3D!
	if ( $shadow ) $total = add_shadow($total);			// Add shadow!
	if ( $upsidedown ) $total = flip_it($total);			// Flip it!
	$total = stretch_it($total, $widthmult, $heightmult);		// Stretch it!

	return $total;							// Bop it!

}


function newcolour($oldcolour)
{
	// Returns a new colour which isn't $oldcolour (or the background)

	global $brightcolours, $allcolours, $background;

	$colour = $oldcolour;
	
	while ( $colour == $oldcolour || $colour == $background ) 
		$colour = ( $allcolours )? rand(0,13) : $brightcolours[rand(0,count($brightcolours)-1)];
	
	return $colour;

}


function add_shadow($input_array)
{
	// Adds shadow to anything..!

	global $colours, $shadows, $rainbowcolours, $greycolours, $brightcolours, $background, $shadowwidth;

	// Add enough space for the shadow to be cast into:
	for ( $y=0; $y < count($input_array); $y++ )
	{
		// Add extra width:
		$input_array[$y] = $input_array[$y] . str_repeat(".", $shadowwidth);
		
		// Split row into individual chars:
		$current[$y] = str_split($input_array[$y]);
	}

	// We'll be using $current as a reference so create a copy into $new for practical purposes
	$new = $current;

	// Add shadow:
	for ( $y=0; $y < count($current); $y++ )
	{

		for ( $x=0; $x < count($current[$y]); $x++ )
		{
			if ( $current[$y][$x] != "." )
			{
				// Only add a shadow if there is an empty space ("."):
				if ( $new[$y + $shadowwidth][$x + $shadowwidth] == "." )
				{
					// Get colour of casting block (chr(97) = "a" = white = 0):
					$thiscolour = ord($current[$y][$x]) - 97;

					// Set shadow colour to the shadow version of the casting block colour:
					$new[$y + $shadowwidth][$x + $shadowwidth] = chr($shadows[$thiscolour] + 97);
				}
			}
		}

	}

	// Collapse the 2D array we built in '$new' back into a simple array of strings
	for ( $n=0; $n < count($new); $n++ ) $output[$n] = implode($new[$n]);

	return $output;		// Bop it!

}


function add_3d($input_array)
{
	global $colours, $shadows, $rainbowcolours, $greycolours, $brightcolours;

	// Adds 3D effect to anything..!


	// Add padding to the right of the banner
	// (this simplifies end-of-line detection later):
	for ( $y=0; $y < count($input_array); $y++ )
	{
		// Add 1 column of padding
		$input_array[$y] = $input_array[$y] . ".";

		// Split rows into 2D array:
		$chars[$y] = str_split($input_array[$y]);
	}

	// Cycle through rows:
	for ( $y=0; $y < count($input_array); $y++ )
	{
		/* Init some variables:
			$flag stores whether we are currently in a contiguous 'stretch' of blocks
		 	$colour stores the colour of that stretch
		 	$length stores the known length of the stretch so far
		 */

		$flag = 0; $colour = 0; $length = 0;

		// Cycle through columns within current row:
		for ( $x=0; $x < count($chars[$y]); $x++ )
		{
			// Get current block's colour (chr(97) = white = 0)
			$thiscolour = ord($chars[$y][$x]) - 97;

			if ( $thiscolour == $colour || $colour == -1 )
			{
				// $colour stores the colour of the current 'stretch' of blocks:
				$colour = $thiscolour;
				
				// Increase known length of current 'stretch':
				$length++;

			} else {

				// We've reached the end of the stretch (as the colour has changed)

				// Change colours of second half of stretch of blocks to shadow
				if ( $length > 0 )
				{
					$length++;	// It needs this, can't remember why  #documentyourcode

					// Apply shadow version of colour to second half of 'stretch':
					$start = $x - intval($length / 2);
					for ( $z=$start; $z < ($x); $z++ ) $chars[$y][$z] = chr($shadows[$colour]+97);
				}

				if ( $thiscolour >= 0 )
				{
					// New stretch begins
					$flag = 1; $length = 0;
					$colour = $thiscolour;
				
				} else {

					// Empty space - no new stretch yet
					$flag = 0; $length = 0;
				}
			}
		}

		// Colapse it back into a simple array of strings:
		$total[$y] = implode($chars[$y]);
	}

	// Trim the additional block from end of banner (we added this to make things easier at the start):
	for ( $y=0; $y < count($total); $y++ ) $total[$y] = substr($total[$y], 0, -1);

	return $total;		// BOP IT!

}

function flip_it($input_array)
{
	// Flips a banner both vertically and horizontally:
	foreach ( array_reverse($input_array) as $line ) $total[] = strrev($line);
	return $total;
}

function stretch_it($input_array, $width, $height)
{

	// Stretches a banner by a multiple of integers:

	if ($width < 1)  $width = 1; 	// Width multiplier must be > 0
	if ($height < 1) $height = 1; 	// Height multiplier must be > 0

	foreach ( $input_array as $line )
	{
		// Stretch width:
		$line = preg_replace('/./', str_repeat("\$0", $width), $line);

		// Stretch height:
		for ( $n=1; $n <= $height; $n++ ) $total[] = $line;
	}

	return $total;
}



function convert_irc($input_array)
{
	// Converts an already-built text banner into IRC character codes
	// e.g. echo convert_irc(slm("my text"));

	global $background;

	// Go through each row:
	for ( $n=0; $n < count($input_array); $n++ )
	{
		// Split row into an array of characters (columns):
		$chars = str_split($input_array[$n]);

		// Go through each column (i.e. step through char by char):
		for ( $i=0; $i < count($chars); $i++ )
		{
			// Grab current colour (chr(97) = "a" = white = 0)
			$thiscolour = ord($chars[$i]) - 97;
			if ( $thiscolour == -51 ) $thiscolour = $background; // 97 - 51 = 46 = ord(".")
			
			// Add colour control char (chr(3)), foreground/background, and block character "#"
			$chars[$i] = chr(3) . strval($thiscolour) . "," . strval($thiscolour) . "#";
		}

		// Collapse it back into a string:
		$total[$n] = implode($chars);
	}

	return $total;
}

function convert_html($input_array)
{
	// Converts an already-built text banner into HTML code.
	// e.g.   echo convert_html(slm("my text"));

	global $background;

	// Hex equivalents of the IRC colour palette 0 to 15:
	$colourshex = array
			(
				"#fff", "#000",	"#008",
				"#080",	"#f00",	"#800",
				"#808",	"#fc0",	"#ff0",
				"#0f0",	"#088",	"#0ff",
				"#00f",	"#f0f",	"#888",
				"#ccc"
			);

	// Cycle through rows
	for ( $n=0; $n < count($input_array); $n++ )
	{
		// Split into characters (columns):
		$chars = str_split($input_array[$n]);

		// Step through char-by-char (i.e. columns)
		for ( $i=0; $i < count($chars); $i++ )
		{
			// Get current block's colour (chr(97) = "a" = white = 0)
			$thiscolour = ord($chars[$i]) - 97;

			if ( $thiscolour == -51 ) $thiscolour = $background; // 97 - 51 = 46 = ord(".")
			
			// Create HTML code:
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
	global $rainbow, $greys, $shadow, $dimensions, $upsidedown;
	global $widthmult, $heightmult, $shadowwidth, $greycolours;

	$colours = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);	// standard colours
	$shadows = array(15,1,1,1,5,1,1,14,7,3,2,10,2,6,1,14);		// shadow colours (for dark backgrounds)
	$rainbowcolours = array(4,7,8,9,11,12,13);			// rainbow colour cycle
	$brightcolours = array(4,8,9,11,13);				// bright colours
	$greycolours = array(14,15,0);					// bright colours

	$background = 1;		// background colour (1=black)
	$foreground = 0;		// default foreground colour (0=white)
	$allcolours = 0;		// whether to use all colours or only bright ones
	$multicolour = 1;		// whether to use colours at all
	$rainbow = 0;			// use rainbow colours
	$greys = 0;			// use grey (gray) colours
	$shadow = 0;			// add shadow
	$shadowwidth = 1;		// distance of shadow
	$dimensions = 2;		// add 3D effect if set to 3
	$upsidedown = 0;		// flip it!
	$widthmult = 1;			// width multiplier
	$heightmult = 1;		// height multiplier
}


/* ------------------ Demo code below this point! ------------------ */


/* 
	Example usage: 
	Output IRC code based on input passed from command line

	To add as an irssi alias:
	/alias slm /exec -o php -e ~/path/to/slmsay.php $0-

	You must escape any special chars e.g.
	/slm /r /s hi \#channel!
*/

slm_init();
$all="";

// Parse command line:
if ( isset($argv) )
{
        $argv[0]="";

        foreach ( $argv as $item )
        {
        	// Get switches

        	$clear=0;

        	if ( $item == "/r" ) { $rainbow = 1; 		$clear=1; }	// use rainbow palette
        	if ( $item == "/s" ) { $shadow = 1;		$clear=1; }	// shadow switch
        	if ( $item == "/3" ) { $dimensions = 3;		$clear=1; }	// 3D switch
        	if ( $item == "/u" ) { $upsidedown = 1;		$clear=1; }	// flip switch
        	if ( $item == "/w" ) { $widthmult++;		$clear=1; }	// increase width
        	if ( $item == "/h" ) { $heightmult++;		$clear=1; }	// increase height
        	if ( $item == "/m" ) { $multicolour = 0;	$clear=1; }	// turn off multicolour
        	if ( $item == "/a" ) { $allcolours = 1;		$clear=1; }	// use dark colours too
        	if ( $item == "/g" ) { $greys = 1;		$clear=1; }	// use grey palette

        	// Ordinary text
	       	if ( !$clear ) $all = $all . " " . $item;
        	
        }

	$all = trim($all);

	// Build the figure
	$slm = slm($all);

	// Echo it back out
	foreach ( convert_irc($slm) as $line )
	{
		echo "$line\n";
	}
}
