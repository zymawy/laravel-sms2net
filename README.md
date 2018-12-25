# Sms2Net GeteWay Package
| This Simple Package :package: Can Help You Interacting With [Net2SMS](https://www.net2sms.net/) API.
| So You Can Send Check Balance, Get All Messages You Saved. And Many More.
## Installtions

You Need To Require The Package In Order It To Work. 
```Shell 
    composer require zymawy\sms2net
```

Then Register The Service Provider To `config/app.php` Inside `providers array`
```php 
          /*
          * Package Service Providers...
          */
         Zymawy\Sms2Net\Sms2NetServiceProvider::class,`
```
In The Same File Place The Facade Inside `alias array`. 
```php
        'Sms2Net' => \Zymawy\Sms2Net\Facades\Sms2NetFacade::class,
```

Finally, You Need To Publish The Config File And The Lang File. 
So You Can Provide The Account Credentials.
`php artisan vendor:publish --provider="Zymawy\Sms2Net\Sms2NetServiceProvider"`

# Available Functions

---

##### ``sendToMany();`` 
### This Function Just If You Want To Send A Heavy array of numbers since it take time to process. Use `sendToOne` Instead For Preference. 
 || it take to arguments 
`$numbers`
And 
`$message`

```php
    $msg =  'In The Name Of Allah The Merciful';
    $numbers = [
    	'009665900000000',
    	'0540000000',
    	'+966550000000'
    ];
    
   $response = Sms2Net::sendToMany($numbers,$msg);
   
  //Success
      {
        "msg": "تم بنجاح ارسال الرسالة",
        "code": "Ok 000",
        "count_delivered_msg": "99",
        "full_massage": "Ok 000, Message Has Been Sent, [99] ID:9999"
      }
  // Errors 
  ERR: Error number
```
---

##### ``sendToOne();`` 
### This Function Just If You Want To Send A A Major Array Of Numbers. Use `sendToOne` Instead For heavy Array Of Numbers. 
 || it take to arguments 
`$numbers`
And 
`$message`

```php
    $msg =  'In The Name Of Allah Most Merciful';
    $user = App\User::first();
   $response = Sms2Net::sendToMany($user->phone_number,$msg);
```
On Success
   ```json
         {
           "msg": "تم بنجاح ارسال الرسالة",
           "code": "Ok 000",
           "count_delivered_msg": "99",
           "full_massage": "Ok 000, Message Has Been Sent, [99] ID:9999"
         }
   ```
On  // Errors 
 ```json
    ERR: Error number
 ```

---
#### `geBalance()`
This will return the number of credits available on this particular account. The account balance is returned
as a floating point value.
```php

  $balance = Sms2Net::geBalance();
   return $balance;
```
On Success 
```json
    {
      "msg": "النقاط المتوفرة ",
      "full_massage": "Credit = 232340",
      "points": "232340"
    }
```

---
#### `getMessages()`
This will return a list of all user messages in an XML format.
it returned XML Format
```php

    Sms2Net::getMessages();
    
```
On Success 
```xml
<?xml version="1.0" encoding="UTF-8"?>
<Messages>
    <MsgID>xxxx</MsgID>
        <MsgShortDesc>xxxx</MsgShortDesc>
    <MsgDesc>xxxx</ MsgDesc >
</Messages>
```

---
#### `contactUs()`
This function to email web service to contact us
it returned XML Format
```php
    Sms2Net::contactUs('test@gmail.com', 'A Test Message'); 
```
On Success 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<Ok>
    <Message>Your message was sent successfully. Thanks.</Message>
</Ok>
```

---
#### `getGroups()`
This will return a list of all groups for specific user in an XML format
--it returned XML Format
```php

    Sms2Net::getGroups();
    
```
On Success 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<Groups>
    <GroupID>xxxx</GroupID>
    <GroupName>xxxx</GroupName>
</Groups>
```

---
#### `getGroup()`
This will return a list of all groups for specific user in an XML format
--it returned XML Format
```php
    $groupID = 212312;
    Sms2Net::getGroup($groupID);
    
```
On Success 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<Members>
    <MemberID>xxxx</MemberID>
    <MemberName>xxxx</MemberName>
    <MemberMobile>xxxx</MemberMobile>
</Members>
```


---
#### `phoneBook()`
This will return a list of all groups & members for specific user and in an XML format
--it returned XML Format
```php
    Sms2Net::phoneBook();
```
On Success 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<PhoneBook>
    <Group>
        <GroupID>xxxx</GroupID>
        <GroupName>xxxx</GroupName>
        <Member>
        <MemberID>xxxx</MemberID>
        <MemberName>xxxx</MemberName>
        <MemberMobile>xxxx</MemberMobile>
        </Member>
    </Group>
</PhoneBook>
```

---
#### `sender()`
This will return a list of all Senders for specific user in an XML format
--it returned XML Format
```php
    Sms2Net::sender();
```
On Success 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<Senders>
    <SenderID>xxxx</ SenderID>
    <SenderName>xxxx</ SenderName>
    <SenderStatus>xxxx</ SenderStatus>
</Senders>
```

#License