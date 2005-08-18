<?php
/**
 * An example of Listener usage with HTTP_Request and HTML_Progress2.
 * Will download and save the file[1] displaying the progress bar in the process.
 * [1] qarbon shockwave flash presentation of SW4P (411 Kb)
 *
 * Credit:     Alexey Borzov <avb@php.net>
 *             for his download-progress.php pattern in HTTP_Request package
 *
 * @version    $Id$
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    HTML_Progress2
 * @subpackage Examples
 * @link       http://www.qarbon.com
 * @access     public
 * @example    examples/preload/swf.php
 *             swf source code
 */
require_once 'HTTP/Request.php';
require_once 'HTTP/Request/Listener.php';
require_once 'HTML/Progress2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

/**
 * @ignore
 */
class HTTP_Request_DownloadListener extends HTTP_Request_Listener
{
   /**
    * Handle for the target file
    * @var int
    */
    var $_fp;

   /**
    * ProgressBar intance used to display the indicator
    * @var object
    */
    var $_bar;

   /**
    * Name of the target file
    * @var string
    */
    var $_target;

   /**
    * Number of bytes received so far
    * @var int
    */
    var $_size = 0;

    function HTTP_Request_DownloadListener()
    {
        $this->HTTP_Request_Listener();
    }

   /**
    * Opens the target file
    * @param string Target file name
    * @throws PEAR_Error
    */
    function setTarget($target)
    {
        $this->_target = $target;
        $this->_fp = @fopen($target, 'wb');
        if (!$this->_fp) {
            PEAR::raiseError("Cannot open '{$target}'");
        }
    }

    function update(&$subject, $event, $data = null)
    {
        switch ($event) {
            case 'sentRequest':
                $this->_target = basename($subject->_url->path);
                break;

            case 'gotHeaders':
                if (isset($data['content-disposition']) &&
                    preg_match('/filename="([^"]+)"/',
                               $data['content-disposition'],
                               $matches))
                {
                    $this->setTarget(basename($matches[1]));
                } else {
                    $this->setTarget($this->_target);
                }
                $this->_bar =& new HTML_Progress2();
                if (isset($data['content-length'])) {
                    $inc = round($data['content-length'] / 100);
                } else {
                    $inc = 1;
                }
                $this->_bar->setIncrement(intval($inc));
                echo '<style type="text/css">'
                     . $this->_bar->getStyle()
                     . '</style>';
                echo '<script type="text/javascript">'
                     . $this->_bar->getScript()
                     . '</script>';
                $this->_bar->display();
                $this->_size = 0;
                break;

            case 'tick':
                $this->_size += strlen($data);
                $val = round($this->_size / $this->_bar->getIncrement());
                $this->_bar->moveStep(intval($val));
                fwrite($this->_fp, $data);
                break;

            case 'gotBody':
                $this->_bar->hide();
                fclose($this->_fp);
                break;

            default:
                PEAR::raiseError("Unhandled event '{$event}'");
        }
    }
}

$movie = 'sw4p.swf';
$url   = 'http://pear.laurent-laville.org/HTML_Progress/examples/viewlet/'
       . $movie;

$req =& new HTTP_Request($url);

$download =& new HTTP_Request_DownloadListener();
$req->attach($download);
$req->sendRequest(false);


$codeBase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab'
          . '#version=5,0,0,0';
$pluginsPage = 'http://www.macromedia.com/shockwave/download/index.cgi'
             . '?P1_Prod_Version=ShockwaveFlash';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Setup Wizard for PHP</title>
<meta name="Keywords" content="viewlet, qarbon, sw4p, HTML_SetupWizard">
<meta name="Description" content="a presentation to SW4P (Setup Wizard for PHP)">
</head>

<body bgcolor="#ffffff">

<div align="center">
<object
  classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
  codebase="<?php echo $codeBase; ?>"
  width="530"
  height="416">
  <param name="movie" value="<?php echo $movie; ?>">
  <param name="quality" value="high">
  <param name="bgcolor" value="#ffffff">
  <embed src="<?php echo $movie; ?>"
      quality="high"
      bgcolor="#ffffff"
      width="530"
      height="416"
      type="application/x-shockwave-flash"
      pluginspage="<?php echo $pluginsPage; ?>">
</object>
</div>

</body>
</html>