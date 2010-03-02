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
	var $data;
	var $contrib;
	var $stable;
	var $require;
	var $faq;
	var $installation;
	var $other;
	var $changelog;
	var $short_desc;
	var $desc;
	var $screenshots;
	var $upgrade_notice;
	var $url;
	var $plug_name;
	var $tags;
// Getter and setters for all the variables.	
	function getTags() { return $this->tags; } 
	function getData() { return $this->data; } 
	function getContrib() { return $this->contrib; } 
	function getStable() { return $this->stable; } 
	function getRequire() { return $this->require; } 
	function getFaq() { return $this->faq; } 
	function getInstallation() { return $this->installation; } 
	function getOther() { return $this->other; } 
	function getChangelog() { return $this->changelog; } 
	function getShort_desc() { return $this->short_desc; } 
	function getDesc() { return $this->desc; } 
	function getScreenshots() { return $this->screenshots; } 
	function getUpgrade_notice() { return $this->upgrade_notice; } 
	function getUrl() { return $this->url; } 
	function getPlug_name() { return $this->plug_name;}
	function setData($x) { $this->data = $x; } 
	function setContrib($x) { $this->contrib = $x; } 
	function setStable($x) { $this->stable = $x; } 
	function setRequire($x) { $this->require = $x; } 
	function setFaq($x) { $this->faq = $x; } 
	function setTags($x) { $this->tags = $x; } 
	function setInstallation($x) { $this->installation = $x; } 
	function setOther($x) { $this->other = $x; } 
	function setChangelog($x) { $this->changelog = $x; } 
	function setShort_desc($x) { $this->short_desc = $x; } 
	function setDesc($x) { $this->desc = $x; } 
	function setScreenshots($x) { $this->screenshots = $x; } 
	function setUpgrade_notice($x) { $this->upgrade_notice = $x; } 
	function setUrl($x) { $this->url = $x; } 
	function setPlug_name($x) { $this->plug_name = $x;}
	
	// Costructor setting the plugin name
	function __construct($plug)
	{
		$this->setPlug_name($plug);
		$this->find_stable();
		$this->set_values();
		//$this->fetch_data();
	}
	function set_values()
	{
		$this->fetch_data();
//		echo "Data Fetch" . $this->getData();
		$data_ar = explode("\n",$this->getData());
		foreach ($data_ar as $line)
		{
			if (stristr($line,"Contributors:"))
			{
				$this->setContrib(substr($line,strpos($line,"Contributers:")+13));
			}
			if (stristr($line,"Tags:"))
			{
				$this->setTags(substr($line,strpos($line,"Tags:")+5));			
			}
			if (stristr($line,"Requires at least:"))
			{
				$this->setRequire(substr($line,strpos($line,"Requires at least:")+18));			
			}
			if (stristr($line,"==="))
			{
				$line = str_replace("=== ","<h1>",$line);
				$line = str_replace(" ===","</h1>",$line);
			}
			if (stristr($line,"=="))
			{
				$line = str_replace("== ","<h2>",$line);
				$line = str_replace(" ==","</h2>",$line);
			}
			if (stristr($line,"==="))
			{
				$line = str_replace("= ","<h3>",$line);
				$line = str_replace(" =","</h3>",$line);
			}
			
		}
//		implode("\n",$line);
	}
	function find_stable()
	{
		$url_temp = 'http://svn.wp-plugins.org/' . $this->plug_name . '/trunk/readme.txt';;
		$data_temp = file_get_contents($url_temp,0,null,0,300);
		if (stristr($data_temp,'Stable tag:'))
		{
			$this->stable = trim(substr($data_temp,strpos($data_temp,'Stable tag:')+11,8));
		}
		if ($this->getStable() == "")
		{
			$this->setUrl($url_temp);
		}
		else
		{
			$url_temp='http://svn.wp-plugins.org/' . $this->getPlug_name() . '/tags/' . $this->getStable() . '/readme.txt';
			$this->setUrl($url_temp);
		}
	}
	// Function to get the data
	function fetch_data()
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
			$data = file_get_contents($this->url);
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
		$this->setData($data);
	}
}
?>