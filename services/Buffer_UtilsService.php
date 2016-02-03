<?php

namespace Craft;

require_once(dirname(__FILE__).'/../library/bufferapp/class.bufferapp.php');

class Buffer_UtilsService extends BaseApplicationComponent
{

/* --------------------------------------------------------------------------------
    Send an update to Buffer.com
-------------------------------------------------------------------------------- */

    public function sendBufferUpdate($text="", $now=true,  $link="", $picture="", $thumbnail="")
    {
        $settings = craft()->plugins->getPlugin('buffer')->getSettings();

        $bufferAccessToken = $settings['bufferAccessToken'];
        $bufferClientId = $settings['bufferClientId'];
        $bufferClientSecret = $settings['bufferClientSecret'];
        $bufferRedirectUri = $settings['bufferRedirectUri'];

        $twitterProfileId = $settings['twitterProfileId'];
        $facebookProfileId = $settings['facebookProfileId'];
        $googlePlusProfileId = $settings['googlePlusProfileId'];
        $pinterestProfileId = $settings['pinterestProfileId'];
        $linkedInPlusProfileId = $settings['linkedInProfileId'];

        if ($bufferAccessToken)
        {
            $buffer = new \BufferPHP($bufferAccessToken);
            if ($buffer)
            {
                $data = array('text' => $text,
                                'now' => $now,
                                'client_id' => $bufferClientId,
                                'client_secret' => $bufferClientSecret,
                                'redirect_uri' => $bufferRedirectUri,
                                'profile_ids' => array(),
                                'media' => array());

                if ($twitterProfileId)
                    $data['profile_ids'][] = $twitterProfileId;

                if ($facebookProfileId)
                    $data['profile_ids'][] = $facebookProfileId;

                if ($googlePlusProfileId)
                    $data['profile_ids'][] = $googlePlusProfileId;

                if ($pinterestProfileId)
                    $data['profile_ids'][] = $pinterestProfileId;

                if ($linkedInPlusProfileId)
                    $data['profile_ids'][] = $linkedInPlusProfileId;

                if ($link)
                    $data['media']['link'] =  $link;

                if ($picture)
                {
                    $data['media']['picture'] =  $picture;
                    $data['media']['photo'] =  $picture;
                }

                if ($thumbnail)
                    $data['media']['thumbnail'] = $thumbnail;

                $ret = $buffer->post('updates/create', $data);
                BufferPlugin::log('sendBufferUpdate: ' . print_r($ret, 1) );
            }
        else
            BufferPlugin::log('new \BufferPHP() failed' );
        }
    } /* -- sendBufferUpdate */

/* --------------------------------------------------------------------------------
    Queue an update so it is sent "later" via a Task
-------------------------------------------------------------------------------- */

    public function queueBufferUpdate($text="", $now=true,  $link="", $picture="", $thumbnail="")
    {
        $task = craft()->tasks->createTask('Buffer', null, array(
                                            'bufferText' => $text,
                                            'bufferNow' => $now,
                                            'bufferLink' => $link,
                                            'bufferPicture' => $picture,
                                            'bufferThumbnail' => $thumbnail
                                            ));
    } /* -- queueBufferUpdate */

} /* -- Buffer_UtilsService */
