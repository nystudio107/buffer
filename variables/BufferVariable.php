<?php
namespace Craft;

class BufferVariable
{

/* --------------------------------------------------------------------------------
	Variables
-------------------------------------------------------------------------------- */

    function sendBufferUpdate($text="", $now=true, $link="", $picture="", $thumbnail="")
    {
		return craft()->buffer_utils->sendBufferUpdate($text, $now, $link, $picture, $thumbnail);
    } /* -- sendBufferUpdate */

    function queueBufferUpdate($text="", $now=true, $link="", $picture="", $thumbnail="")
    {
		return craft()->buffer_utils->queueBufferUpdate($text, $now, $link, $picture, $thumbnail);
    } /* -- queueBufferUpdate */

}