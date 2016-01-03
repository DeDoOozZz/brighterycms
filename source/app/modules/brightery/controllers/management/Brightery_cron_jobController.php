<?php

class Brightery_cron_jobController extends Brightery_Controller {

    protected $interface = 'management';
    protected $layout = 'default';
    protected $auth = true;

    public function indexAction($id) {
        

        $res_month = $this->database->query("
             
            select  max(brightery_invoices.due_date) AS due_date  ,brightery_invoices.`status` AS status,brightery_products_subscriptions.period AS period,DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period MONTH) AS date_add,(DATEDIFF( DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period MONTH), NOW())) AS date_substract,
            `brightery_licenses`.`brightery_license_id`
             from brightery_invoices join `brightery_licenses` 
             ON `brightery_licenses`.`brightery_license_id`=`brightery_invoices`.`brightery_license_id`
             join brightery_products_subscriptions 
             ON brightery_licenses.brightery_products_subscription_id=brightery_products_subscriptions.brightery_products_subscription_id
            WHERE`brightery_licenses`.`brightery_products_subscription_id` NOT IN ('null')
             AND  `brightery_products_subscriptions`.`period_cycle` ='Month'
                AND brightery_invoices.`status` != 'canceled'
             GROUP BY  brightery_invoices.brightery_license_id  
             HAVING (DATEDIFF( DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period MONTH), NOW()))  <=4
    
            ")->result();

        $res_year = $this->database->query("
                    select  max(brightery_invoices.due_date) AS due_date  ,brightery_invoices.`status` AS status,brightery_products_subscriptions.period AS period,DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period year) AS date_add,(DATEDIFF( NOW() ,DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period year))) AS date_substract,
            `brightery_licenses`.`brightery_license_id`
             from brightery_invoices join `brightery_licenses` 
             ON `brightery_licenses`.`brightery_license_id`=`brightery_invoices`.`brightery_license_id`
             join brightery_products_subscriptions 
             ON brightery_licenses.brightery_products_subscription_id=brightery_products_subscriptions.brightery_products_subscription_id
            WHERE`brightery_licenses`.`brightery_products_subscription_id` NOT IN ('null')
             AND  `brightery_products_subscriptions`.`period_cycle` ='Year'
                AND brightery_invoices.`status` != 'canceled'
             GROUP BY  brightery_invoices.brightery_license_id  
             HAVING (DATEDIFF( DATE_ADD(MAX(brightery_invoices.due_date), INTERVAL brightery_products_subscriptions.period YEAR), NOW()))  <=30
    
             ")->result();
        print_r($res_year);
        $model = new \modules\brightery\models\brightery_invoices(FALSE);
        foreach ($res_month as $val) {
//
            echo $val->due_date . '<br>';
            echo $val->status . '<br>';
            echo $val->period . '<br>';
            echo $val->date_substract . '<br>';
            echo $val->brightery_license_id . '<br>';


            $model->attributes = [
                'brightery_license_id' => $val->brightery_license_id,
                'due_date' => $val->date_add,
                'status' => 'due'
            ];

            if ($model->save(true))
                echo 'yes';
        }
        
        
            foreach ($res_year as $val) {
                echo 'ojiji';
//
            echo $val->due_date . '<br>';
            echo $val->status . '<br>';
            echo $val->period . '<br>';
            echo $val->date_substract . '<br>';
            echo $val->brightery_license_id . '<br>';


            $model->attributes = [
                'brightery_license_id' => $val->brightery_license_id,
                'due_date' => $val->date_add,
                'status' => 'due'
            ];

            if ($model->save(true))
                echo 'yes';
        }
//        $to = 'someone@yahoo.com';
//        $subject = 'Sample Subject';
//        $message = 'Hi. This is a sample message.';
//        $headers = 'From: webmaster@royyuuki.elementfx.com' . "\r\n" .
//                'Reply-To: no-reply@royyuuki.elementfx.com' . "\r\n" .
//                'X-Mailer: PHP/' . phpversion();
//
//        echo (mail($to, $subject, $message, $headers)) ? 'Message sent!' : 'Message not sent!';
    }

}
