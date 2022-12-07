<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\TwitterData;


class MediaController extends Controller
{
    public function connect_twitter(Request $request){

        /** @var Callback URL @callback  */
        $callback = '';

        /** @var establishing twitter connection @_twitter_connect */

        $_twitter_connect = new TwitterOAuth(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_SECRET_TOKEN'));
        
        /** @var _access_token get access token */
         $_access_token = $_twitter_connect->oauth('oauth/request_token',['oauth_callback'=>$callback]);

         /** */
        $route = $_twitter_connect->url('oauth/authorize', ['oauth_token'=> $_access_token['oauth_token']]);
         
        return redirect($route);

    }

    public function twitter_cbk(Request $request){
        
        $response = $request->all();
        
        $oauth_token = $response['oauth_token'];
        $oauth_verifier = $response['oauth_verifier'];
        
        $connection = new TwitterOAuth(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_SECRET_TOKEN') , $oauth_token, $oauth_verifier); 
        
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);
        
        $twitter_oauth_token = $access_token['oauth_token'];
        
        $twitter_oauth_secret = $access_token['oauth_token_secret'];

       /*return $this->post_twitter_comment($twitter_oauth_token , $twitter_oauth_secret);
        $push = new TwitterOAuth('H4FuqWnOGLfGkddvKfpRh7dkZ', 'Tr99GbolZ70h9NzyektyZHOr0mS63CvID1HAvcaXoNyB2kMJIf',$twitter_oauth_token, $twitter_oauth_secret);
        $push->setTimeouts(10, 15);
        $push->post('statuses/update', ['status'=>'Funciona :(']);*/
        
        $save = TwitterData::query()->updateOrCreate(
            [
                
                'user_access_token' => $twitter_oauth_token,
                'twitter_oauth_token_secret' =>  $twitter_oauth_secret,
                'user_id' => Auth()->user()->id,
            ]
        );
        return redirect()->route('dashboard');
        
    }

    public function post_twitter_comment($oauth_token , $oauth_token_secret){

        $push = new  TwitterOAuth(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_SECRET_TOKEN') , $oauth_token , $oauth_token_secret);
        $push->setTimeouts(10, 15);
        $push->post('statuses/update', ['status'=>'Hello is a comment! ']);

        return redirect()->route('dashboard');

    }

    public function twitter_post(Request $request){

        $message = $request->input('message');
        $this->post_twitter_comment();

    }
}
