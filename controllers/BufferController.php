<?php
namespace Craft;

/**
 * Buffer controller
 */
class BufferController extends BaseController
{
    protected $allowAnonymous = true;

	/**
	 * Send an update to Buffer.
	 */
	public function actionUpdate()
	{
		$text = craft()->request->getParam('text');
		$nowText = craft()->request->getParam('now');
		$link = craft()->request->getParam('link');
		$picture = craft()->request->getParam('picture');
		$thumbnail = craft()->request->getParam('thumbnail');

		$now = true;
		if ($nowText == "false")
			$now = false;
			
		craft()->buffer_utils->sendBufferUpdate($text, $now, $link, $picture, $thumbnail);

		craft()->end();
	}
}
