<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																											//
//	Wordpress Readme Parser - by Anant Shrivastava http://anantshri.info									//
//	Licensed under GNU GPL v2																				//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
class wp_readme_parser {
	//////////////////////////////////////////////////////////////////////////////////////////////
	//  Lets Define Some Variables her for the class                                            //
	//////////////////////////////////////////////////////////////////////////////////////////////
	$data;
	$contrib;
	$stable;
	$require;
	$faq;
	$installation;
	$other;
	$changelog;
	$short_desc;
	$desc;
	$screenshots;
	$upgrade_notice;
	$url;
	// Function to get the readme url
	function get_url($url)
	{
// start with the best method <- if curl found then use it.
		if (function_exists('curl_init'))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_HEADER, 0); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 
			$data = curl_exec($ch); 
			curl_close($ch); 
		}
		else
		{
		//	echo "curl not found";
			$data = file_get_contents($url);
			if ($data == false)
			{
				echo "error occured";
			}
			else
			{
		//		echo "<pre>";
		//		print_r($data);
		//		echo "</pre>";
			}
		}
		return $data;
	}
}
?>