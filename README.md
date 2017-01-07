# laravel-bbnplace
A Laravel 5 Package for BBN Place Sms Messenger <br/>
NOTE: This package is currently is development mode!

send SMS from Laravel blade template
```
return SmsMessenger::send('emails.sms', ['name' => 'Samuel'], function($sms){
    $sms->mobile = '07063317344';
    $sms->sender = 'Samsoft';
    $sms->isflash = false;//optional
    $sms->countryCode = +234;//optional

});
```

Send a plain sms
```
return SmsMessenger::plain('I am on my way now', function($sms){
    $sms->mobile = '07063317344';
    $sms->sender = 'Samsoft';
    $sms->isflash = false;//optional
    $sms->countryCode = +234;//optional
});
```

Schedule SMS
```
return SmsMessenger::schedule('emails.sms', ['name' => 'Samuel'], function($sms){

    $sms->sender = 'Samsoft';
    $sms->mobile = '07063317344';

    $sms->isflash = false;
    $sms->sendTime = Carbon\Carbon::createFromTimestamp(time())->addMinute(90)->getTimestamp();
    $sms->scheduleName = 'mySchedule';
    $sms->sendScheduleNotification = false;

});
```

Check SMS Balance
```
(int) SmsMessenger::checkBalance();
```
