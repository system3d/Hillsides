<?php

if (! function_exists('isAllowed')) {
    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function isAllowed($permission)
    {
        if(!access()->user()->allow($permission)){
            return false;
        }else{
            return true;
        }
    }
}

/**
 * Global helpers file with misc functions
 *
 */

if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('app_version')) {
    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function app_version()
    {
        return config('app.version');
    }
}

if (! function_exists('app_real')) {
    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function app_real()
    {
        return config('app.real');
    }
}

if (! function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access()
    {
        return app('access');
    }
}

if (! function_exists('javascript')) {
    /**
     * Access the javascript helper
     */
    function javascript()
    {
        return app('JavaScript');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('getFallbackLocale')) {
    /**
     * Get the fallback locale
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    function getFallbackLocale()
    {
        return config('app.fallback_locale');
    }
}

if (! function_exists('getLanguageBlock')) {

    /**
     * Get the language block with a fallback
     *
     * @param $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function getLanguageBlock($view, $data = [])
    {
        $components = explode("lang", $view);
        $current  = $components[0]."lang.".app()->getLocale().".".$components[1];
        $fallback  = $components[0]."lang.".getFallbackLocale().".".$components[1];

        if (view()->exists($current)) {
            return view($current, $data);
        } else {
            return view($fallback, $data);
        }
    }
}

if (! function_exists('formatBytes')) {
    /**
     * Helper to grab the application name
     *
     * @return mixed
     */
    function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
     $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
}

if (!function_exists('diffForHumans')) {
    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function diffForHumans($data, $format = null) {
        if($format == null)
            return date('d/m/Y',strtotime($data));
        else
            return date($format,strtotime($data));
    }
}

if (! function_exists('timeDiff')) {
    /**
     * Get the fallback locale
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    function timeDiff($time)
    {
        $to_time = strtotime(date('Y-m-d H:i:s'));
        $from_time = strtotime($time);
        $time = $to_time - $from_time;
        return secondsToTime($time);
    }
}

if (! function_exists('secondsToTime')) {

function secondsToTime($inputSeconds) {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // return the final array
    $obj = array(
        'd' => (int) $days,
        'h' => (int) $hours,
        'm' => (int) $minutes,
        's' => (int) $seconds,
        't' => (int) $inputSeconds
    );
    return $obj;
}
}

if (! function_exists('datePtFormat')) {
    /**
     * Get the fallback locale
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    function datePtFormat($time)
    {
        $resp = date('j M, H:i',strtotime($time));
        $nmeng = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $nmpt = array('Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez');
        $r = str_ireplace($nmeng, $nmpt, $resp);
        return $r;
    }
}

if (! function_exists('datePtFormatFull')) {
    /**
     * Get the fallback locale
     *
     * @return \Illuminate\Foundation\Application|mixed
     */
    function datePtFormatFull($time)
    {
        $resp = date('j \d\e M, H:i',strtotime($time));
        $nmeng = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $nmpt = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
        $r = str_ireplace($nmeng, $nmpt, $resp);
        return $r;
    }
}

if (! function_exists('getLastMessages')) {

    function getLastMessages()
    {
        $userModel = new App\Models\Access\User\User;
        $msgModel = new App\Mensagem;
        $user = access()->user();
        $senders = $msgModel->select('sender_id')->where('receiver_id',$user->id)->groupBy('sender_id')->get();
        $lastMessages = array();
        foreach($senders as $sender){
            $lastMessages[] = $msgModel->where('sender_id',$sender->sender_id)->where('receiver_id',$user->id)->orderBy('status')->orderBy('created_at','desc')->first();
        }
        $response = array();
        $unreadN = array();
        $unread = 0;
        $total = $msgModel->where('receiver_id',$user->id)->where('status',0)->count();
        foreach($lastMessages as $lst){
            if($lst->status == 0){
                $response[] = $lst;
                $unread++;
                $unreadN[$lst->sender_id] = $msgModel->select('id')->where('sender_id',$lst->sender_id)->where('receiver_id',$user->id)->where('status',0)->count();
            }
        }
        foreach($lastMessages as $lst){
            if($lst->status == 1){
                $response[] = $lst;
            }
        }
        $response['msgs']   = collect($response);
        $response['unread'] = $unread;
        $response['num'] = $unreadN;
        $response['total'] = $total;
        return $response;

    }
}
