<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportPlant extends Model
{
    protected $fillable=['group','season','year','crop','gov','old_area','old_quantity','new_area','new_quantity'];
    public function getOldProductivityAttribute(){
        if ($this->old_area !=0)
            return round($this->old_quantity/$this->old_area,3);
        return 0;
    }
    public function getNewProductivityAttribute(){
        if ($this->new_area !=0)
            return round($this->new_quantity/$this->new_area,3);
        return 0;
    }
    public function getTotalAreaAttribute(){
        return $this->old_area+$this->new_area;
    }
    public function getTotalQuantityAttribute(){
        return $this->old_quantity+$this->new_quantity;
    }
    public function getTotalProductivityAttribute(){
        if ($this->total_area !=0)
            return round($this->total_quantity/$this->total_area,3);
        return 0;
    }

}
