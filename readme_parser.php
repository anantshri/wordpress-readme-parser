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
function get_url($url)
{
	if (function_exists('curl_init'))
	{
	//		echo "curl found;";
		   $ch = curl_init();
		   curl_setopt($ch, CURLOPT_URL, $url); 
		   curl_setopt($ch, CURLOPT_HEADER, 0); 
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0'); 
		   $data = curl_exec($ch); 
		   curl_close($ch); 
	//	   echo $data;
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
if (isset($_GET['plugin']))
{
	$name = $_GET['plugin'];
	$url = 'http://svn.wp-plugins.org/' . $name . '/trunk/readme.txt';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//																											//
//			Lets Define some variables for this work.														//
//																											//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$short_desc="";
	$plug_name="";
	$contrib_name="";
	$stable="";
	$require="";
	$tested="";
	$tags = "";
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//
////////////////////////////////////////////////////////////////////////////////////////////////////////////
//	echo $url;
//	echo "<link rel='stylesheet' href='http://blog.anantshri.info/wp-content/themes/glossymod/style.css' type='text/css' media='all' />";
	$data = get_url($url);
	if ($data != null)
	{
	//	echo "<br />lets Parse then;";
//		echo "<br />String";
		//echo strpos($data,'Stable tag:');
		$tag =  substr($data,strpos($data,'Stable tag:')+12,10);
		if ($tag != null)
		{
			$tag1=explode("\n",$tag);
//			echo "<br />new file needs to be loaded";
			$url1 = 'http://svn.wp-plugins.org/' . $name . '/tags/' . trim($tag1[0]) . '/readme.txt';
//			echo "<br /> New Url will be : ". $url1;
//				echo $data;
			$data = get_url($url1);
		}
		else
		{
			echo "<br /> Trunk readme is default";
		}
		$data_array = explode("\n",$data);
//		echo "<pre>";
//				print_r($data_array);
//		echo "</pre>";
		$link_length = 0;
		$link_code = 0;
		foreach($data_array as $line)
		{
			//echo "Length : " . strlen($line) . "<br />";
//				echo " : " . strpos($line," ==="); 	
			$line = str_replace("<br />","",$line);
//			$line = htmlentities($line);
			if (stristr($line,"==="))
			{
				$link_length = 1;
				$line = "<h1>". substr($line,4,strpos($line," ===") - 4) . "</h1>";
			}
			else if (stristr($line,"=="))
			{
				$link_length = 2;
				$line = "<h2>" . substr($line,3,strpos($line," ==")-3) . "</h2>";
			}
			// a check to avoid picking up = in url parameter or other places
			else if (stristr($line,"=") && strpos($line,"=") == 0)
			{
				$line = "<h3>" . substr($line,2,strpos($line," =")-2) . "</h3>";
			}
			else if (stristr($line,":") && $link_length != 2)
			{
				if (stristr($line,"Contributors"))
				{
					$contrib_name = substr($line,strpos($line,":")+2);
				}
				$line = "<b>" . substr($line,0,strpos($line,":")) . "</b>" . substr($line,strpos($line,":"));
			}
			else if ($link_length == 1 && !stristr($line,":") && strlen($line) != 1)
			{
				$short_desc=$line;
				$line =  "<br /><b>Short Description </b> : " . $line;
			}
			else if(stristr($line,"`") && substr_count($line,"`") == 1)
			{	
				if ($link_code == 1)
				{
					$line = str_replace ("`","</code>",$line);
					$link_code=0;
				}
				if($link_code == 0)
				{
					$line = str_replace("`","<code>",$line);
					$link_code = 1;
				}
			}
			if (strlen($line) != 1 && !isset($_GET['part']))
			{
				echo $line . "<br />\n";
			}
		}
	}
	if(isset($_GET['part']))
	{
		switch ($_GET['part'])
		{
			case 'short':
				echo $short_desc;
				break;
			case 'contrib':
				echo $contrib_name;
				break;
		}
	}
}
else
{
	echo "Please pass variable";
}
echo "\n<br />Mem" . memory_get_usage();
?>