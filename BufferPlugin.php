<?php
namespace Craft;

class BufferPlugin extends BasePlugin
{		
    function getName()
    {
        return Craft::t('Buffer');
    }

    function getVersion()
    {
        return '1.0.0';
    }

    function getDeveloper()
    {
        return 'Megalomaniac';
    }

    function getDeveloperUrl()
    {
        return 'http://www.megalomaniac.com';
    }

    public function hasCpSection()
    {
        return false;
    }

    public function addTwigExtension()
    {
        Craft::import('plugins.buffer.twigextensions.BufferTwigExtension');

        return new BufferTwigExtension();
    }

	protected function defineSettings()
	{
		return array(
			'bufferAccessToken' => array(AttributeType::String, 'label' => 'Buffer Access Token', 'default' => ''),
			'bufferClientId' => array(AttributeType::String, 'label' => 'Buffer Client ID', 'default' => ''),
			'bufferClientSecret' => array(AttributeType::String, 'label' => 'Buffer Client Secret', 'default' => ''),
			'bufferRedirectUri' => array(AttributeType::String, 'label' => 'Buffer Redirect URI', 'default' => ''),
			'twitterProfileId' => array(AttributeType::String, 'label' => 'Twitter Profile ID', 'default' => ''),
			'facebookProfileId' => array(AttributeType::String, 'label' => 'Facebook Profile ID', 'default' => ''),
			'googlePlusProfileId' => array(AttributeType::String, 'label' => 'Google+ Profile ID', 'default' => ''),
			'pinterestProfileId' => array(AttributeType::String, 'label' => 'Pinterest Profile ID', 'default' => ''),
			'linkedInProfileId' => array(AttributeType::String, 'label' => 'LinkedIn Profile ID', 'default' => ''),
		);
	}

    public function getSettingsHtml()
	{
       return craft()->templates->render('buffer/settings', array(
           'settings' => $this->getSettings()
       ));
	}
	
}