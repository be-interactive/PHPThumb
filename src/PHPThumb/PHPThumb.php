<?php

namespace PHPThumb;

/**
 * PhpThumb Base Class Definition File
 * 
 * This file contains the definition for the ThumbBase object
 * 
 * PHP Version 5 with GD 2.0+
 * PhpThumb : PHP Thumb Library <http://phpthumb.gxdlabs.com>
 * Copyright (c) 2009, Ian Selby/Gen X Design
 * 
 * Author(s): Ian Selby <ian@gen-x-design.com>
 * 
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @author Ian Selby <ian@gen-x-design.com>
 * @copyright Copyright (c) 2009 Gen X Design
 * @link http://phpthumb.gxdlabs.com
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 3.0
 * @package PhpThumb
 * @filesource
 */

/**
 * ThumbBase Class Definition
 * 
 * This is the base class that all implementations must extend.  It contains the 
 * core variables and functionality common to all implementations, as well as the functions that 
 * allow plugins to augment those classes.
 * 
 * @package PhpThumb
 * @subpackage Core
 */
abstract class PHPThumb
{
	/**
	 * All imported objects
	 * 
	 * An array of imported plugin objects
	 * 
	 * @var array
	 */
	protected $imported;
	
	/**
	 * All imported object functions
	 * 
	 * An array of all methods added to this class by imported plugin objects
	 * 
	 * @var array
	 */
	protected $importedFunctions;
	
	/**
	 * The last error message raised
	 * 
	 * @var string
	 */
	protected $errorMessage;
	
	/**
	 * Whether or not the current instance has any errors
	 * 
	 * @var bool
	 */
	protected $hasError;
	
	/**
	 * The name of the file we're manipulating
	 * 
	 * This must include the path to the file (absolute paths recommended)
	 * 
	 * @var string
	 */
	protected $fileName;
	
	/**
	 * What the file format is (mime-type)
	 * 
	 * @var string
	 */
	protected $format;
	
	/**
	 * Whether or not the image is hosted remotely
	 * 
	 * @var bool
	 */
	protected $remoteImage;
	
	/**
	 * An array of attached plugins to execute in order.
	 * @var array
	 */
	protected $plugins;
	
	/**
	 * Class constructor
	 * 
	 * @return ThumbBase
	 */
	public function __construct($fileName)
	{
		$this->imported				= array();
		$this->importedFunctions	= array();
		$this->errorMessage			= null;
		$this->hasError				= false;
		$this->fileName				= $fileName;
		$this->remoteImage			= false;
		
		$this->fileExistsAndReadable();
	}
	
	/**
	 * Checks to see if $this->fileName exists and is readable
	 * 
	 */
	protected function fileExistsAndReadable ()
	{
		if (preg_match('/https?:\/\//', $this->fileName) !== 0)
		{
			$this->remoteImage = true;
			return;
		}
		
		if (!file_exists($this->fileName))
		{
			$this->triggerError('Image file not found: ' . $this->fileName);
		}
		elseif (!is_readable($this->fileName))
		{
			$this->triggerError('Image file not readable: ' . $this->fileName);
		}
	}
	
	/**
	 * Sets $this->errorMessage to $errorMessage and throws an exception
	 * 
	 * Also sets $this->hasError to true, so even if the exceptions are caught, we don't
	 * attempt to proceed with any other functions
	 * 
	 * @param string $errorMessage
	 */
	protected function triggerError ($errorMessage)
	{
		$this->hasError 	= true;
		$this->errorMessage	= $errorMessage;
		
		throw new \Exception ($errorMessage);
	}

    /**
     * Returns $imported.
     * @see ThumbBase::$imported
     * @return array
     */
    public function getImported ()
    {
        return $this->imported;
    }
    
    /**
     * Returns $importedFunctions.
     * @see ThumbBase::$importedFunctions
     * @return array
     */
    public function getImportedFunctions ()
    {
        return $this->importedFunctions;
    }
	
	/**
	 * Returns $errorMessage.
	 *
	 * @see ThumbBase::$errorMessage
	 */
	public function getErrorMessage ()
	{
		return $this->errorMessage;
	}
	
	/**
	 * Sets $errorMessage.
	 *
	 * @param object $errorMessage
	 * @see ThumbBase::$errorMessage
	 */
	public function setErrorMessage ($errorMessage)
	{
		$this->errorMessage = $errorMessage;
	}
	
	/**
	 * Returns $fileName.
	 *
	 * @see ThumbBase::$fileName
	 */
	public function getFileName ()
	{
		return $this->fileName;
	}
	
	/**
	 * Sets $fileName.
	 *
	 * @param object $fileName
	 * @see ThumbBase::$fileName
	 */
	public function setFileName ($fileName)
	{
		$this->fileName = $fileName;
	}
	
	/**
	 * Returns $format.
	 *
	 * @see ThumbBase::$format
	 */
	public function getFormat ()
	{
		return $this->format;
	}
	
	/**
	 * Sets $format.
	 *
	 * @param object $format
	 * @see ThumbBase::$format
	 */
	public function setFormat ($format)
	{
		$this->format = $format;
	}
	
	/**
	 * Returns $hasError.
	 *
	 * @see ThumbBase::$hasError
	 */
	public function getHasError ()
	{
		return $this->hasError;
	}
	
	/**
	 * Sets $hasError.
	 *
	 * @param object $hasError
	 * @see ThumbBase::$hasError
	 */
	public function setHasError ($hasError)
	{
		$this->hasError = $hasError;
	} 
	

}
