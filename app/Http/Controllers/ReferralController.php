<?php namespace App\Http\Controllers;

use Input;
use Auth;
use Response;

class ReferralController extends Controller
{
	public function index($id) {
		SetCookie("ref",$id,(int)time()+3600000, '/');
		return redirect('home');
	}


	public function MassMailing() {

		if(Auth::guest()) return false;

		$mails = Input::get('mails');
		$mails_valid = [];
		$invite = "Your invite: http://pimboo.com/ref/".Auth::user()->id;

		if(count($mails) != 0) {
			foreach ($mails as $key => $value) {
				if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$mails_valid[] = $value;
				}
			}

			if(count($mails_valid) != 0) {


				$request_body = '{
						  "personalizations": [
						    {
						      "to": [
						      ],
						      "subject": "Invite to Pimboo.com!"
						    }
						  ],
						  "from": {
						    "email": "pimboo@pimboo.com"
						  },
						  "content": [
						    {
						      "type": "text/plain",
						      "value": ""
						    }
						  ]
						}';

				$request_body = json_decode($request_body);

				foreach ($mails_valid as $key => $value) {
					$request_body->personalizations[0]->to[] = ['email' => $value];
				}
				
				$request_body->content[0]->value = $invite;

				$request_body = json_encode($request_body);


				$api_key = "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";
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: Bearer '.$api_key;

				if( $curl = curl_init() ) {
				    curl_setopt($curl, CURLOPT_URL, 'https://api.sendgrid.com/v3/mail/send');
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
				    curl_setopt($curl, CURLOPT_POST, true);
				    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
				    $out = curl_exec($curl);
				    curl_close($curl);
				}

				return Response::json(['success' => true]);
			} else {
				return Response::json(['success' => false]);
			}
		}
	}
}