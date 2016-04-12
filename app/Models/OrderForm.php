<?php

namespace Jcfk\Models;

use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    protected $appends = ['name', 'school_name'];

    protected $dates = ['start_date', 'end_date'];

    protected $table = 'order_form';

    public $primaryKey = 'order_form_id';

    public $timestamps = false;

    protected $fillable = ['start_date', 'end_date', 'school_id'];

    public function getSchoolNameAttribute()
    {
        return $this->school->name;
    }

    public function getNameAttribute()
    {
        return sprintf(
            '%s - %s',
            date('d-M-y', strtotime($this->start_date)),
            date('d-M-y', strtotime($this->end_date))
        );
    }

    public function school()
    {
        return $this->belongsTo('Jcfk\Models\School');
    }

    public function menuItems()
    {
        return $this->hasMany('Jcfk\Models\MenuItem');
    }

    public function toFormDataArray()
    {
        $orderFormArray = $this->toArray();

        $orderFormArray['start_date'] = $this->start_date->format('m/d/Y');
        $orderFormArray['end_date']   = $this->end_date->format('m/d/Y');

        return $orderFormArray;
    }

    public function publish()
    {
        $this->is_published = 1;

        return $this->save();
    }

    public function getFormsByIds(array $orderFormIds)
    {
        return $this->whereIn('order_form_id', $orderFormIds)
            ->get();
    }
}
