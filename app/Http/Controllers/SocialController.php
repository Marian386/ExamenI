<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Socialhub;
use App\Models\socialpost;
use App\Models\TwitterData;
use Abraham\TwitterOAuth\TwitterOAuth;

class SocialController extends Controller
{
    public function provider(){
        return Socialite::driver('linkedin')->redirect();
    }

    public function providerCallback(){
        $user = Socialite::driver('linkedin')->user();
        $save = Socialhub::query()->updateOrCreate(
            ['user_id'=>auth()->user()->id, 'linkedin_token'=>$user->token],
            ['linkedin_id'=>$user->id]
        );
        return redirect('/dashboard');
    }

    public function postRequest($post)
    {
        /*$socialhub = Socialhub::where('user_id', Auth()->user()->id)->first();*/
        $post_url = "https://api.linkedin.com/v2/ugcPosts?oauth2_access_token=".env('LINKEDIN_TOKEN') ;
        $request = [
            "author" => "urn:li:person:" .$post->social_auth_id,
            "lifecycleState" => "PUBLISHED",
            "specificContent" => [
                "com.linkedin.ugc.ShareContent" => [
                    "shareCommentary" => [
                        "text" => $post->comment
                    ],
                    "shareMediaCategory" => "NONE",
                ],
                
            ],
            "visibility" => [
                "com.linkedin.ugc.MemberNetworkVisibility" => 'PUBLIC',
            ]
        ];
        $post = $this->curl($post_url,json_encode($request), "application/json", true);
        return $post;
       
    }


    public function curl($url, $parameters, $content_type, $post = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        }
        curl_setopt($ch, CURLOPT_POST, $post);
        $headers = [];
        $headers[] = "Content-Type: {$content_type}";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        return $result;
    }
    
    public function cronjob(){
        echo date("Y-m-d H:i:s")."\n";
        $socialpost = socialpost::where('status','pending')->get();
        
        foreach ($socialpost as $post){
            $t = date('Y-m-d');
            $t = strtotime($t);
            
            $h = date('H:i');
            $h = strtotime($h);
            

            if($post->date === date('Y-m-d')){
                if(strtotime($post->hour) >= $h){
                    $post->status = 'published';
                    $post->save();
                    $this->postRequest($post);
                    
                }
            }else if (strtotime($post->date) === null && strtotime($post->hour) === null){
                $socialpost->update(['status'=>'published']);
                $this->postRequest($post);
            }
        }
        
    }

    public function savetypepost(){  
        if(request()->tipo === '1'){
            if(request()->redsocial === '1'){
                $socialhub = Socialhub::where('user_id', Auth()->user()->id)->first();
                $post_url = "https://api.linkedin.com/v2/ugcPosts?oauth2_access_token=".env('LINKEDIN_TOKEN') ;
                $request = [
                    "author" => "urn:li:person:" .$socialhub->linkedin_id,
                    "lifecycleState" => "PUBLISHED",
                    "specificContent" => [
                        "com.linkedin.ugc.ShareContent" => [
                            "shareCommentary" => [
                                "text" => request()->comentario
                            ],
                            "shareMediaCategory" => "NONE",
                        ],
                        
                    ],
                    "visibility" => [
                        "com.linkedin.ugc.MemberNetworkVisibility" => 'PUBLIC',
                    ]
                ];
                $post = $this->curl($post_url,json_encode($request), "application/json", true);
                return redirect('/dashboard'); 
            }
            else if(request()->redsocial === '2'){
                $this->post_twitter_comment(request()->comentario);
                return redirect('/dashboard');
                
            }
        }
        else if(request()->tipo === '2'){
            if (request()->redsocial === '1'){
                $socialhub = Socialhub::where('user_id', Auth()->user()->id)->first();
                $save = socialpost::query()->updateOrCreate(
                    ['social_auth_id'=>$socialhub->linkedin_id, 'user_id'=>Auth()->user()->id,
                     'comment'=>request()->comentario, 'redsocial'=>request()->redsocial,
                     'hour'=>request()->time, 'date'=>request()->date,
                    ]
                );  
                return redirect('/dashboard'); 
            }else if(request()->redsocial === '2'){
                $twitter = TwitterData::query()->where('user_id', auth()->user()->id)->first();
                $save = socialpost::query()->updateOrCreate(
                    ['social_auth_id'=> '', 'user_id'=>Auth()->user()->id,
                     'comment'=>request()->comentario, 'redsocial'=>request()->redsocial,
                     'hour'=>request()->time, 'date'=>request()->date,
                    ]
                );  
                return redirect('/dashboard'); 
            }
        }
        else{ 
            if (request()->redsocial === '1'){
                $socialhub = Socialhub::where('user_id', Auth()->user()->id)->first();
                $save = socialpost::query()->updateOrCreate(
                    ['social_auth_id'=>$socialhub->linkedin_id, 'user_id'=>Auth()->user()->id,
                     'comment'=>request()->comentario, 'redsocial'=>request()->redsocial,
                     'hour'=>request()->time, 'date'=>request()->date,
                    ]
                );  
                return redirect('/dashboard'); 
            }else if(request()->redsocial === '2'){
                 $twitter = TwitterData::query()->where('user_id', auth()->user()->id)->first();
                $save = socialpost::query()->updateOrCreate(
                    ['social_auth_id'=> '', 'user_id'=>Auth()->user()->id,
                     'comment'=>request()->comentario, 'redsocial'=>request()->redsocial,
                     'hour'=>request()->time, 'date'=>request()->date,
                    ]
                );  
                return redirect('/dashboard'); 
            }
        }
    }

    public function showpost(){
        $publicaciones = socialpost::query()->where('user_id', auth()->user()->id)->get();
        return view('dashboard', ['publicaciones' => $publicaciones]);
    }


    public function post_twitter_comment($comment){
        $twitter = TwitterData::query()->where('user_id', auth()->user()->id)->first();
        $push = new TwitterOAuth(env('TWITTER_ACCESS_TOKEN'), env('TWITTER_SECRET_TOKEN') , $twitter->user_access_token , $twitter->twitter_oauth_token_secret);
        $push->setTimeouts(10, 15);
        $push->post('statuses/update', ['status'=>$comment]);

        return $push;
    }
}   


