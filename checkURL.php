<?php
// USAGE: php checkURL.php 'http://example.com'
// POSSIBLE OUTPUTS:
//      "phshing": submitted to phishtank and verified as phishing
//      "suspect": submitted to phishtank but not verified yet
//      "safe": submitted to phishtank and verified as not phishing
//      "unkown": not submitted to phishtank.
//      "request-failed": for some reason the url could not be checked. It could be:
//                      - malformed url: don't forget 'http://' or 'https://'. Invalid urls will also result in request-faild
//                      - api offline: for some reason the api is indisponible.
$phishtank_api_url = 'https://phishtank.com/checkurl/';
$phishtank_api_key = "d67e5be6b9e56a67f01ecf84fd3d1c14d376594eda1c9d8591252ded31ae6918";
$url_to_check = $argv[1];
$request_data = ["format" => "json",
                 "app_key" => $phishtank_api_key,
                 "url" => $url_to_check,
                ];
$cu = curl_init();
curl_setopt_array($cu, [CURLOPT_URL => $phishtank_api_url,
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $request_data,
                        ]);
$json_response = curl_exec($cu);
if(curl_error($cu)){ $phishtank_analysis_result = "request-failed";}
else {
        $api_response = json_decode($json_response);
        if ($api_response->{'meta'}->{'status'} == "error") { $phishtank_analysis_result = "request-failed";}
        else {
                $phishtank_analysis_result = "";
                $is_in_database = $api_response->{'results'}->{'in_database'};
                if($is_in_database == '') { $phishtank_analysis_result = "unkown";}
                else {
                        $is_verified = $api_response->{'results'}->{'verified'};
                        $is_valid = $api_response->{'results'}->{'valid'};
                        if($is_verified == "" and $is_valid == "") { $phishtank_analysis_result = "suspect";}
                        if($is_verified == "1" and $is_valid == "") { $phishtank_analysis_result = "safe";}
                        if($is_verified == "1" and $is_valid == "1") { $phishtank_analysis_result = "phishing";}
                }
        }
}
echo $phishtank_analysis_result;
//Used in debuging of the api responses
//print_r($json_response);
?>
