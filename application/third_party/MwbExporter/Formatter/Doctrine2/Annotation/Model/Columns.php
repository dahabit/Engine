<?php
/*
 *  The MIT License
 *
 *  Copyright (c) 2010 Johannes Mueller <circus2(at)web.de>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

namespace MwbExporter\Formatter\Doctrine2\Annotation\Model;

class Columns extends \MwbExporter\Core\Model\Columns
{
    public function __construct($data, $parent)
    {
        parent::__construct($data, $parent);
    }

    public function display()
    {
        $return = array();
        
        foreach($this->columns as $column){
            $return[] = $column->display();
        }

        return implode("\n", $return);
    }
    
    public function displayArrayCollections()
    {
        $return = array();
        
        foreach($this->columns as $column){
            if (true == $arrayCollection = $column->displayArrayCollection()){
                $return[] = $arrayCollection;
            }
        }
        
        return implode("\n", $return);
    }
    
    public function displayGetterAndSetter()
    {
        $return = array();

        foreach($this->columns as $column){
            $return[] = $column->displayGetterAndSetter();
        }
        
        return implode("\n", $return);
    }

	public function displayArrayGetterAndSetter()
    {
        $return = array();
		
		// Setter
		$return[] = $this->indentation() . 'public function setArray($array)';
		$return[] = $this->indentation() . '{';
		foreach($this->columns as $column)
		{
			$return[] = $this->indentation(2) . '$this->' . $column->config['name'] . ' = $array[\'' . $column->config['name'] . '\'];';
		}
		$return[] = $this->indentation(2) . 'return $this; // fluent interface';
		$return[] = $this->indentation() . '}';
		$return[] = '';
		// Getter
		$return[] = $this->indentation() . 'public function getArray()';
		$return[] = $this->indentation() . '{';
		$return[] = $this->indentation(2) . 'return array(';
		foreach($this->columns as $column)
		{
			if ($column == end($this->columns)) 
			{
				$return[] = $this->indentation(3) . "'" . $column->config['name'] . "'" . ' => $this->' . $column->config['name'];
			}
			else
			{
				$return[] = $this->indentation(3) . "'" . $column->config['name'] . "'" . ' => $this->' . $column->config['name'] . ",";
			}
		}
		$return[] = $this->indentation(2) . ');';
		$return[] = $this->indentation() . '}';
		
		return implode("\n", $return);
	}
}