<?php

// lets suppose the input_array is a 10K recipient list
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
//    include ('sendgrid/vendor/autoload.php');
//    $sendgrid = new SendGrid('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');
//    $input_array = array ();
//
//    for ( $i = 0; $i < 1000; ++$i ) {
//        $input_array[] = 'somnath.sarkar@esolzmail.com';
//    }
//
//
//    $number_of_emails_per_request = 1000;
//
//// email chunks
//    $recipient_chunks  = array_chunk($input_array, $number_of_emails_per_request);
//
//// the email body contains fname and openpixel custom tags
//    $body = "Hello user this is a test email";
//    $from = "nrideb.kundu@esolzmail.com";
//
//// process each chunk
//    for ( $i = 0; $i < count($recipient_chunks); $i++ ) {
//        // create a new instance of Email inside the loop
//        $emailmaster = new SendGrid\Email();
////        echo $emailmaster;die;
//        // add 1k recipients
//        $emailmaster->setSmtpapiTos($recipient_chunks[ $i ])
//            ->setFrom($from)
//            ->setSubject($subject)
//            ->setHtml($body);
////        // add first name as substitution tag
////        $emailmaster->addSubstitution('[first_name]', $fname_chunks[ $i ]);
////        // add open pixel as substitution tag
////        $emailmaster->addSubstitution('[open_pixel]', $open_pixel_chunks[ $i ]);
//        // send 1000 emails at once 
//        $sendgrid->send($emailmaster);
//    }






    $input_array = array ();

    for ( $i = 0; $i < 100; ++$i ) {
        $input_array[] = 'somnath.sarkar@esolzmail.com';
    }

    $user = "kaafoo";
    $pass = "esolz123456";


    $number_of_emails_per_request = 10;

// email chunks
    $recipient_chunks = array_chunk($input_array, $number_of_emails_per_request);

// the email body contains fname and openpixel custom tags
    $body = "Hello user this is a test email";
    $from = "nrideb.kundu@esolzmail.com";
    $url  = 'https://api.sendgrid.com/';

// process each chunk
    for ( $i = 0; $i < count($recipient_chunks); $i++ ) {
        // create a new instance of Email inside the loop
//        $emailmaster = new SendGrid\Email("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");
////        echo $emailmaster;die;
//        // add 1k recipients
//        $emailmaster->setSmtpapiTos($recipient_chunks[ $i ])
//            ->setFrom($from)
//            ->setSubject($subject)
//            ->setHtml($body);
////        // add first name as substitution tag
////        $emailmaster->addSubstitution('[first_name]', $fname_chunks[ $i ]);
////        // add open pixel as substitution tag
////        $emailmaster->addSubstitution('[open_pixel]', $open_pixel_chunks[ $i ]);
//        // send 1000 emails at once 
//        $sendgrid->send($emailmaster);
//$to = ['somnath.sarkar@esolzmail.com','krishna.das@esolzmail.com'];
        
        $to_array = array();
        foreach($recipient_chunks[ $i ] as $key => $val){
            $to_array['to['.$key.']']=$val;
        }
        echo "<pre>"; 
        
        $params = array (
                'api_user' => $user,
                'api_key'  => $pass,
                'subject'  => "test",
                'html'     => "hello user",
                'text'     => "This is test email",
                'from'     => "nrideb.kundu@esolzmail.com"
        );
//        print_r($to_array);
//        echo "<pre>";
//        print_r(array_merge($params,$to_array));die;
        
        
        $request = $url . 'api/mail.send.json';
        // Generate curl request
        $session = curl_init($request);

        // Tell curl to use HTTP POST
        curl_setopt($session, CURLOPT_POST, true);

        // Tell curl that this is the body of the POST
        curl_setopt($session, CURLOPT_POSTFIELDS, array_merge($params,$to_array));

        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        // Tell PHP not to use SSLv3 (instead opting for TLS)
        //curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // obtain response
        $response = curl_exec($session);
        //if($response->message)
        $response = json_decode($response);
        //echo $response->message ;
        //echo "<pre>";print_r($response);die;
        curl_close($session);
    }
    
//    echo "<pre>";
//    print_r($params);
?>