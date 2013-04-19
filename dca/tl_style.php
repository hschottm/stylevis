<?php

/**
 * @copyright  Helmut Schottmüller 2010-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/tabindex>
 * @package    stylevis
 * @license    LGPL
 */

function removenastycss($element)
{
	if (strcmp($element, 'visibility:hidden') == 0 || strcmp($element, 'display:none') == 0 || strpos($element, 'float:') !== FALSE || strpos($element, 'display:') !== FALSE || strpos($element, 'text-align:') !== FALSE)
	{
		return false;
	}
	else
	{
		return true;
	}
}

class StyleSheetVisualizer extends Backend
{
	/**
	 * Compile format definitions and return them as string
	 * @param array
	 * @param boolean
	 * @return string
	 */
	public function compileDefinition($row, $blnWriteToFile=false)
	{
		$this->import("StyleSheets");
		$result = $this->StyleSheets->compileDefinition($row, $blnWriteToFile);
		if (preg_match("/>(.*?)\\{(.*?)\\}/is", $result, $matches))
		{
			$attrib = ($GLOBALS['TL_CONFIG']['showSingleStyles']) ? 'class' : 'style';
			$styles = array_filter(trimsplit(";", $matches[2]), 'strlen');
			$inline = array_filter($styles, 'removenastycss');
			$names = trimsplit(",", $matches[1]);
			$result = "";
			if (count($inline))
			{
				$i = 1;
				$result .= '<div id="id' . $row['id'] . '">';
				foreach ($names as $name)
				{
					$result .= '<div ' . $attrib . '="' . str_replace("\"", "", join($inline, '!important;')) . '">' . $name . (($i < count($names)) ? ',' : '') . '</div>';
					$i++;
				}
				$result .= '</div>';
			}
			else
			{
				$i = 1;
				$result .= '<div id="id' . $row['id'] . '">';
				foreach ($names as $name)
				{
					$result .= '<div>' . $name . (($i < count($names)) ? ',' : '') . '</div>';
					$i++;
				}
				$result .= '</div>';
			}
			$result .= '<pre>{' . "\n  " . join($styles, "\n  ") . "\n}</pre>";
			$result = str_replace("!important!important", "!important", $result);
		}
		return $result;
	}
}

/**
 * Table tl_style
 */
$GLOBALS['TL_DCA']['tl_style']['list']['sorting']['child_record_callback'] = array('StyleSheetVisualizer', 'compileDefinition');
if ($GLOBALS['TL_CONFIG']['showSingleStyles'])
{
	array_insert($GLOBALS['TL_DCA']['tl_style']['list']['operations'], 1, array(
		'css' => array
		(
			'label'               => &$GLOBALS['TL_LANG']['tl_style']['cssshow'],
			'icon'                => 'system/modules/styleVis/assets/css_add.png',
			'attributes'          => 'onclick="return styleVisClicked(this, \'' . $GLOBALS['TL_LANG']['tl_style']['csshide'][0] . '\', \'' . $GLOBALS['TL_LANG']['tl_style']['csshide'][1] . '\', \'' . $GLOBALS['TL_LANG']['tl_style']['cssshow'][0] . '\', \'' . $GLOBALS['TL_LANG']['tl_style']['cssshow'][1] . '\'); Backend.getScrollOffset();"'
		)
	));
}

?>