<?php 
namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class BufferTwigExtension extends \Twig_Extension
{

/* --------------------------------------------------------------------------------
	Expose our filters and functions
-------------------------------------------------------------------------------- */

    public function getName()
    {
        return 'Buffer';
    }

/* -- Return our twig filters */

    public function getFilters()
    {
        return array(
            'sendBufferUpdate' => new \Twig_Filter_Method($this, 'sendBufferUpdate_filter'),
            'queueBufferUpdate' => new \Twig_Filter_Method($this, 'queueBufferUpdate_filter'),
        );
    } /* -- getFilters */

/* -- Return our twig functions */

    public function getFunctions()
    {
        return array(
            'sendBufferUpdate' => new \Twig_Function_Method($this, 'sendBufferUpdate_filter'),
            'queueBufferUpdate' => new \Twig_Function_Method($this, 'queueBufferUpdate_filter'),
       );
    } /* -- getFunctions */

/* --------------------------------------------------------------------------------
	Filters
-------------------------------------------------------------------------------- */

    function sendBufferUpdate_filter($text="", $now=true,  $link="", $picture="", $thumbnail="")
    {
		return craft()->buffer_utils->sendBufferUpdate($text, $now, $link, $picture, $thumbnail);
    } /* -- sendBufferUpdate_filter */

    function queueBufferUpdate_filter($text="", $now=true,  $link="", $picture="", $thumbnail="")
    {
		return craft()->buffer_utils->queueBufferUpdate($text, $now, $link, $picture, $thumbnail);
    } /* -- queueBufferUpdate_filter */

} /* -- BufferTwigExtension */
