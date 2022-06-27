<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Str;
class EnvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth()->user()->can('system.settings'))
        {
            abort(401);
        }    
        $countries= base_path('resources/lang/langlist.json');
        $countries= json_decode(file_get_contents($countries),true);

        return view('admin.settings.env',compact('countries'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth()->user()->can('system.settings'))
        {
            abort(401);
        }  
        
        $validated = $request->validate([
            'service_account_credentials' => 'mimes:json,txt|max:100',
        ]);
        
        if ($request->hasFile('service_account_credentials')) {
            $file      = $request->file('service_account_credentials');
            $name = 'service-account-credentials.json';
            $path = 'uploads/';
            $file->move($path, $name);
        } 

        if (!empty($request->FMC_SERVER_API_KEY)) {
          $apiKey=$request->FMC_CLIENT_API_KEY;
          $authDomain=$request->FMC_AUTH_DOMAIN;
          $projectId=$request->FMC_PROJECT_ID;
          $storageBucket=$request->FMC_STORAGE_BUCKET;
          $messagingSenderId=$request->FMC_MESSAGING_SENDER_ID;
          $appId=$request->FMC_APP_ID;
          $measurementId=$request->FMC_MEASUREMENT_ID;

             $file="
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: '".$apiKey."',
    authDomain: '".$authDomain."',
    projectId: '".$projectId."',
    storageBucket: '".$storageBucket."',
    messagingSenderId: '".$messagingSenderId."',
    appId: '".$appId."',
    measurementId: '".$measurementId."'
});
const messaging = firebase.messaging();
";

File::put('firebase-messaging-sw.js',$file);
        }

       $APP_URL_WITH_TENANT=$request->APP_URL.'/store/';

        $APP_URL_WITHOUT_WWW=str_replace('www.','', url('/'));
         $APP_NAME = Str::slug($request->APP_NAME);
$txt ="APP_NAME=".$APP_NAME."
APP_ENV=local
APP_KEY=base64:rKqQdziq59oSCoL7ZcLZCp3sJ3h6A5r74utiD7Jt6Pg=
APP_DEBUG=".$request->APP_DEBUG."
APP_URL=".$request->APP_URL."
SITE_KEY=".env('SITE_KEY')."
AUTHORIZED_KEY=".env('AUTHORIZED_KEY')."

CONTENT_EDITOR=".$request->CONTENT_EDITOR."
ANALYTICS_VIEW_ID=".$request->ANALYTICS_VIEW_ID."

DB_CONNECTION=".env("DB_CONNECTION")."
DB_HOST=".env("DB_HOST")."
DB_PORT=".env("DB_PORT")."
DB_DATABASE=".env("DB_DATABASE")."
DB_USERNAME=".env("DB_USERNAME")."
DB_PASSWORD=".env("DB_PASSWORD")."


QUEUE_MAIL=".$request->QUEUE_MAIL."
".$request->MAIL_DRIVER_TYPE."=".$request->MAIL_DRIVER."
MAIL_DRIVER_TYPE=".$request->MAIL_DRIVER_TYPE."
MAIL_HOST=".$request->MAIL_HOST."
MAIL_PORT=".$request->MAIL_PORT."
MAIL_USERNAME=".$request->MAIL_USERNAME."
MAIL_PASSWORD=".$request->MAIL_PASSWORD."
MAIL_ENCRYPTION=".$request->MAIL_ENCRYPTION."
MAIL_FROM_ADDRESS=".$request->MAIL_FROM_ADDRESS."
MAIL_TO=".$request->MAIL_TO."
MAIL_FROM_NAME='".$request->MAIL_FROM_NAME."'

MOJODNS_AUTHORIZATION_TOKEN=".$request->MOJODNS_AUTHORIZATION_TOKEN."
SERVER_IP=".$request->SERVER_IP."
CNAME_DOMAIN=".$request->CNAME_DOMAIN."
VERIFY_IP=".$request->VERIFY_IP."
VERIFY_CNAME=".$request->VERIFY_CNAME."

AUTO_SUBDOMAIN_APPROVE=".$request->AUTO_SUBDOMAIN_APPROVE."
AUTO_DB_CREATE=".$request->AUTO_DB_CREATE."
QUEUE_WORKER=".$request->QUEUE_WORKER."
AUTO_TENANT_APPROVE=".$request->AUTO_TENANT_APPROVE."
SUBDOMAIN_TYPE=".$request->SUBDOMAIN_TYPE."
TENENT_DB_PREFIX=".$request->TENENT_DB_PREFIX."
APP_URL_WITH_TENANT=".$request->APP_URL_WITH_TENANT."
APP_PROTOCOLESS_URL=".$request->APP_PROTOCOLESS_URL."
APP_PROTOCOL=".$request->APP_PROTOCOL."

MAILCHIMP_DRIVER=".$request->MAILCHIMP_DRIVER."
MAILCHIMP_APIKEY=".$request->MAILCHIMP_APIKEY."
MAILCHIMP_LIST_ID=".$request->MAILCHIMP_LIST_ID."

BROADCAST_DRIVER=".$request->BROADCAST_DRIVER."
CACHE_DRIVER=".$request->CACHE_DRIVER."
QUEUE_CONNECTION=".$request->QUEUE_CONNECTION."
SESSION_DRIVER=".$request->SESSION_DRIVER."
SESSION_LIFETIME=".$request->SESSION_LIFETIME."

MEMCACHED_HOST=".$request->MEMCACHED_HOST."
MEMCACHED_PORT=".$request->MEMCACHED_PORT."
MEMCACHED_PERSISTENT_ID=".$request->MEMCACHED_PERSISTENT_ID."
MEMCACHED_USERNAME=".$request->MEMCACHED_USERNAME."
MEMCACHED_PASSWORD=".$request->MEMCACHED_PASSWORD."

REDIS_HOST=".$request->REDIS_HOST."
REDIS_PORT=".$request->REDIS_PORT."
REDIS_PASSWORD=".$request->REDIS_PASSWORD."

STORAGE_TYPE=".$request->STORAGE_TYPE."

AWS_ACCESS_KEY_ID=".$request->AWS_ACCESS_KEY_ID."
AWS_SECRET_ACCESS_KEY=".$request->AWS_SECRET_ACCESS_KEY."
AWS_DEFAULT_REGION=".$request->AWS_DEFAULT_REGION."
AWS_BUCKET=".$request->AWS_BUCKET."


WAS_ACCESS_KEY_ID=".$request->WAS_ACCESS_KEY_ID."
WAS_SECRET_ACCESS_KEY=".$request->WAS_SECRET_ACCESS_KEY."
WAS_DEFAULT_REGION=".$request->WAS_DEFAULT_REGION."
WAS_BUCKET=".$request->WAS_BUCKET."
WAS_ENDPOINT=".$request->WAS_ENDPOINT."

IMAGE_COMPRESS_METHOD=".$request->IMAGE_COMPRESS_METHOD."
TINIFY_API_KEY=".$request->TINIFY_API_KEY."

FMC_SERVER_API_KEY=".$request->FMC_SERVER_API_KEY."
FMC_CLIENT_API_KEY=".$request->FMC_CLIENT_API_KEY."
FMC_AUTH_DOMAIN=".$request->FMC_AUTH_DOMAIN."
FMC_PROJECT_ID=".$request->FMC_PROJECT_ID."
FMC_STORAGE_BUCKET=".$request->FMC_STORAGE_BUCKET."
FMC_MESSAGING_SENDER_ID=".$request->FMC_MESSAGING_SENDER_ID."
FMC_APP_ID=".$request->FMC_APP_ID."
FMC_MEASUREMENT_ID=".$request->FMC_MEASUREMENT_ID."


LOG_CHANNEL=".$request->LOG_CHANNEL."
LOG_LEVEL=".$request->LOG_LEVEL."
TIMEZONE=".$request->TIMEZONE."
DEFAULT_LANG=".$request->DEFAULT_LANG."

";

  File::put(base_path('.env'),$txt);
       return response()->json("System Updated");
    }

   
}
