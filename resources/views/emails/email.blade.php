<!DOCTYPE html>
<html>
    <head>
        <title>{{ $subject }}</title>
    </head>
    <body>
        <p>{{ $emailmessage }}</p>

        <p>The above message is from {{ $sender }} who is in a group
            or event you're in at
            <a href="https://findlikeminded.com/">FindLikeMinded</a></p>

        <p>This email was sent by the application.  Replying to it will not reach the sender.</p>
    </body>
</html>
