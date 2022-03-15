<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCropStructure extends Model
{
    protected $fillable=['year','gov','winter_old','winter_new','perennial_old','perennial_new','summer_old','summer_new','indigo_old','indigo_new'];
    public function getWinterOldNewAttribute(){
        return $this->winter_old+$this->winter_new;
    }
    public function getPerennialOldNewAttribute(){
        return $this->perennial_old+$this->perennial_new;
    }
    public function getSummerOldNewAttribute(){
        return $this->summer_old+$this->summer_new;
    }
    public function getIndigoOldNewAttribute(){
        return $this->indigo_old+$this->indigo_new;
    }
}
