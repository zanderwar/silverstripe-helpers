<?php

/**
 * Class SS_RelativeAssetsResponseExtension
 *
 * @property Controller $owner
 */
class SS_RelativeAssetsResponseExtension extends Extension
{

    function onBeforeInit()
    {
        if (is_a($this->owner, 'Controller')) {
            $this->owner->response = new SS_RelativeAssetsResponse();
        }
    }

}

class SS_RelativeAssetsResponse extends SS_HTTPResponse
{
    public function setBody($body)
    {
        $body = $body ? (string)$body : $body;

        $body = str_replace('"/assets/', '"assets/', $body);
        $body = str_replace('"assets/', '"/assets/', $body);
        
        json_decode($body);
        $bodyIsJson = json_last_error() === JSON_ERROR_NONE;


        if (!$bodyIsJson && class_exists('zz\Html\HTMLMinify')) {
            $this->body = zz\Html\HTMLMinify::minify($body, [
                'doctype' => zz\Html\HTMLMinify::DOCTYPE_HTML5,
                'optimizationLevel' => zz\Html\HTMLMinify::OPTIMIZATION_ADVANCED
            ]);
        } else {
            $this->body = $body;
        }
    }


}
