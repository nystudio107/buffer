<?php
namespace Craft;

/**
 * Buffer task -- do the actual posting to Buffer from here
 */
class BufferTask extends BaseTask
{
	/**
	 * Defines the settings.
	 *
	 * @access protected
	 * @return array
	 */
	
	protected function defineSettings()
	{
		return array(
			'bufferText' => AttributeType::String,
			'bufferNow' => AttributeType::Bool,
			'bufferLink' => AttributeType::String,
			'bufferPicture' => AttributeType::String,
			'bufferThumbnail' => AttributeType::String,
		);
	}

	/**
	 * Returns the default description for this task.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return 'Posting update to Buffer.com';
	}

	/**
	 * Gets the total number of steps for this task.
	 *
	 * @return int
	 */
	public function getTotalSteps()
	{
		return 1;
	}

	/**
	 * Runs a task step.
	 *
	 * @param int $step
	 * @return bool
	 */
	public function runStep($step)
	{
		BufferPlugin::log('Buffer Update sending: ' . $this->getSettings()->bufferText );
		craft()->buffer_utils->sendBufferUpdate($this->getSettings()->bufferText,
												$this->getSettings()->bufferNow,
												$this->getSettings()->bufferLink,
												$this->getSettings()->bufferPicture,
												$this->getSettings()->bufferThumbnail
												);
		BufferPlugin::log('Buffer Update sent: ' . $this->getSettings()->bufferText );
		return true;
	}
}
