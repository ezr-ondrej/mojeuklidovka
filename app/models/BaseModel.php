<?php
//use Carbon\Carbon;

class BaseModel extends Eloquent {

    public function getUpdatedAtAttribute($value) {
        //$carbon = Carbon::parse($value)->timezone('Europe/Prague');
        //return $carbon;

        // or default TZ as set in .env.php
        $timezone = ('Europe/Prague') ?: Config::get('app.timezone');

        // use Illuminate\Database\Eloquent\Model;
        $datetime = $this->asDateTime($value);

        // Carbon instance modified with TZ
        return $datetime->timezone($timezone)->format('Y/m/d H:i:s');
    }

}