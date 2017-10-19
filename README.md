# phishtank-url-checker
The simplest php code to check phishings with phishtank.com API



## 1 Pre-requisites: php5.6-cli php5.6-fpm php5.6-curl

A simple "apt-get install php5.6-cli php5.6-fpm php5.6-curl" shall solve it on debian



## 2 Quick start


**2.1 Create your account and get your API KEY at www.phishtank.com/**


**2.2 Edit the source code to insert your API KEY at the variable $phishtank_api_key.**

  Example: 
  
  >$phishtank_api_key = "437e0be6b4e56237651ecf84fd3d1c122376594eda1c9d8591252de231a23765";


**2.3 Call the script as php checkURL.php 'someurl'
  
  Example:
  
  >"php checkURL.php 'http://www.someurl.com'"
  
  >"php checkURL.php 'https://www.someurl.com'"
  
  
## 3 Possible outputs:
    "phishing": submitted to phishtank and verified as phishing
    "suspect": submitted to phishtank but not verified yet
    "safe": submitted to phishtank and verified as not phishing
    "unkown": not submitted to phishtank.
    "request-failed": for some reason the url could not be checked. It could be:
                        - malformed url: don't forget 'http://' or 'https://'. Invalid urls will also result in request-faild
                        - api offline: for some reason the api is indisponible.

