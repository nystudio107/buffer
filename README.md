# Buffer plugin for Craft CMS

A simple plugin for integrating [Buffer](https://buffer.com) into [Craft CMS](http://buildwithcraft.com) websites, for sending out social updates from Twig templates, via a trigger URL, or from other plugins.

**Installation**

1. Unzip file and place `buffer` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/khalwat/buffer.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins

## Configuring Buffer###

First, make sure you have [set up a Buffer account](https://buffer.com/) and see the [Buffer API](https://buffer.com/developers/api/) for details on how to set up your Buffer app for API access.

Next in the Craft Admin CP, go to Settings->Plugins->Buffer and enter your Buffer Access Token, Buffer Client ID, Buffer Client Secret, and Buffer Redirect URI.

Fill in the Profile IDs for your social media accounts. You can find out each profile’s id from your dashboard, click on each social profile tab and notice the URL in browser, it will be something like this:

`https://bufferapp.com/app/profile/SOCIALPROFILEID/buffer`

The string between “/profile/” & “/buffer/” is the social profile id.  If you don't have a Profile ID for a given service, just leave it blank.

Currently Pinterest is unsupported, as the Buffer team has not provided the appropriate API access, but they say they will soon.

## Using the Buffer plugin in your templates

### sendBufferUpdate

`sendBufferUpdate` sends the social update to Buffer immediately.  In most cases, it's better to use `queueBufferUpdate` instead, since that spins off a Craft Task that handles the update sending in the background (it can sometimes be lengthy).

Both of these methods accomplish the same thing:

	{# Send an update to Buffer using the 'sendBufferUpdate' function #}
    {{ sendBufferUpdate(UPDATE_TEXT, UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL) }}
    
	{# Send an update to Buffer using the 'sendBufferUpdate' filter #}
    {{ UPDATE_TEXT | sendBufferUpdate(UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL) }}

All of the parameters except for `UPDATE_TEXT` are optional.  For more information on what these parameters are, please see [POST/updates/create](https://buffer.com/developers/api/updates)

### queueBufferUpdate

`queueBufferUpdate` works much like `sendBufferUpdate`, except that it spins off the social update to Buffer into a Craft Task.  Since the update process can be lengthy, this the preferred way to send updates to Buffer.

Both of these methods accomplish the same thing:

	{# Send an update to Buffer using the 'queueBufferUpdate' function #}
    {{ queueBufferUpdate(UPDATE_TEXT, UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL) }}
    
	{# Send an update to Buffer using the 'sendBufferUpdate' filter #}
    {{ UPDATE_TEXT | queueBufferUpdate(UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL) }}

All of the parameters except for `UPDATE_TEXT` are optional.  For more information on what these parameters are, please see [POST/updates/create](https://buffer.com/developers/api/updates)

## Triggering the Buffer via URL

You can also trigger buffer updates via URL to the Buffer controller:

	http://YOURSITE.com/buffer/buffer/update?text=UPDATE_TEXT&now=UPDATE_NOW&link=UPDATE_LINK&picture=UPDATE_PICTURE&thumbnail=UPDATE_THUMBNAIL

All of the parameters except for `UPDATE_TEXT` are optional.  For more information on what these parameters are, please see [POST/updates/create](https://buffer.com/developers/api/updates)

## Using the Buffer service in your plugins

You can send updates to Buffer via your plugins as well.

### craft()->buffer_utils->sendBufferUpdate()

`craft()->buffer_utils->sendBufferUpdate()` sends the social update to Buffer immediately.  In most cases, it's better to use `craft()->buffer_utils->queueBufferUpdate()` instead, since that spins off a Craft Task that handles the update sending in the background (it can sometimes be lengthy).

	/* -- Send an update to Buffer using the 'sendBufferUpdate' service */
    craft()->buffer_utils->sendBufferUpdate(UPDATE_TEXT, UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL )
    
All of the parameters except for `UPDATE_TEXT` are optional.  For more information on what these parameters are, please see [POST/updates/create](https://buffer.com/developers/api/updates)

### craft()->buffer_utils->queueBufferUpdate()

`craft()->buffer_utils->queueBufferUpdate()` works much like `craft()->buffer_utils->sendBufferUpdate()`, except that it spins off the social update to Buffer into a Craft Task.  Since the update process can be lengthy, this the preferred way to send updates to Buffer.

Both of these methods accomplish the same thing:

	/* -- Send an update to Buffer using the 'queueBufferUpdate' service */
    craft()->buffer_utils->queueBufferUpdate(UPDATE_TEXT, UPDATE_NOW, UPDATE_LINK, UPDATE_PICTURE, UPDATE_THUMBNAIL )

All of the parameters except for `UPDATE_TEXT` are optional.  For more information on what these parameters are, please see [POST/updates/create](https://buffer.com/developers/api/updates)

## Example Plugin

Here's an example plugin that you can modify to post updates when someone posts to the "blog" channel:

	<?php
	namespace Craft;
	
	class ImawhalePlugin extends BasePlugin
	{
	    function getName()
	    {
	        return Craft::t('Imawhale');
	    }
	
	    function getVersion()
	    {
	        return '1.0.0';
	    }
	
	    function getDeveloper()
	    {
	        return 'nystudio107';
	    }
	
	    function getDeveloperUrl()
	    {
	        return 'http://nystudio107.com';
	    }
	
	    public function hasCpSection()
	    {
	        return false;
	    }
	
		public function init()
		{
		    parent::init();
		
		    craft()->on('entries.onBeforeSaveEntry', function(Event $event) 
		    {
		        $entry = $event->params['entry'];
		        if ($entry->section == 'Blog Entry') 
		        {
					$siteUrl = craft()->siteUrl;
					$hashTag = " #imawhale";
				    $user = craft()->users->getUserById($entry->authorId);
				    $userName = "";
					if ($user)
					{
				        $userName = $user->getFullName();
					}
					
					if ($userName)
						$userName = " " . $userName;
						
		            if ($event->params['isNewEntry']) 
		            {
						$updateString = "New Imawhale blog post “" . $entry->title . "” by" . $userName . " " . $siteUrl . "/blog/" . $entry->slug . $hashTag;
						
						ImawhalePlugin::log('A new blog entry has been posted: ' . $entry->title, LogLevel::Info, true);
		
						craft()->buffer_utils->queueBufferUpdate($updateString, true);
		            } 
		            else 
		            {
	
		            }
		        }
		    }); // edited
		}
		
	}

## Changelog

### 1.0.2 -- 2015.11.23

* Added support for Craft 2.5 new plugin features

### 1.0.1 -- 2015.11.08

* Updated the README with an example plugin

### 1.0.0 -- 2015.09.27

* Initial release
