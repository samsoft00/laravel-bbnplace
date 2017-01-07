<?php
/**
 * Created by PhpStorm.
 * User: WF-INNOVATION
 * Date: 1/7/2017
 * Time: 3:12 AM
 */

namespace Samsoft00\Bbnplace;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Samsoft00\Bbnplace\Libs\BSGateway;

class SmsMessenger
{
    //$myMessage, $flash = 0, $countrycode=null, $messageid=null
    /**
     * Sender's Name/Phone number
     */
    public $sender;

    /**
     * Recipient
     */
    public $recipient;

    /**
     * message
     */
    public $message;

    /**
     * flash
     */
    public $flash;

    /**
     * Country code
     */
    public $countrycode;

    /**
     * Message Id
     */
    public $messageid;

    protected $password;

    protected $username;
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var BSGateway
     */
    private $bbnplace;

    /**
     * SmsMessenger constructor.
     * @param ClientInterface $client
     * @param BSGateway $bbnplace
     */
    public function __construct(ClientInterface $client, BSGateway $bbnplace)
    {
        $this->client = $client;
        $this->bbnplace = $bbnplace;
        $this->getCredentials();
    }


    public function send($view, $data=[], $callback)
    {
        if($view instanceof SmsableContact){
            return $view->send();
        }

        list($view, $plain) = $this->parseView($view);
        $data['message'] = $sms = $this->bbnplace;

        call_user_func($callback, $sms);

        $this->addContent($sms, $data, $view, $plain);

        $sms->sendMessage();

    }

    public function checkBalance(){
        return $this->bbnplace->checkBalance($this->username, $this->password);
    }

    public function tryLogin(){
        return $this->bbnplace->tryLogin($this->username, $this->password);
    }

    public function schedule($view, $data=[], $callback){

        list($view, $plain) = $this->parseView($view);

        $data['message'] = $sms = $this->bbnplace;

        call_user_func($callback, $sms);

        $this->addContent($sms, $data, $view, $plain);

        $sms->scheduleMessage();

    }

    public function plain($text, $callback){
        $this->send(['plain' => $text], [], $callback);
    }

    private function parseView($view)
    {
        if(is_string($view)){
            return [$view, null];
        }

        if(is_array($view) && isset($view['plain'])){
            return [null, $view['plain']];
        }

        if (is_array($view)) {
            return [
                Arr::get($view, 'html'),
                Arr::get($view, 'text')
            ];
        }

    }

    private function addContent($sms, $data, $view, $plain, $schedule = false)
    {
        if(isset($view)){
            $sms->message = $this->renderView($view, $data) ;
        }else {
            $sms->message = $plain;
        }

        if($schedule){
            $sms->schedule = 1;
        }

        $sms->username = $this->username;
        $sms->password = $this->password;
    }

    protected function renderView($view, $data)
    {
        return $view instanceof HtmlString
            ? $view->toHtml()
            : view($view, $data)->render();
    }

    private function getCredentials()
    {
        $this->username = config('smsmessenger.email');

        $this->password = config('smsmessenger.password');
    }
}