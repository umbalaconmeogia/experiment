<?php
namespace app\models;

use yii\base\Model;

class Officer extends Model
{
    const OFFICER_TYPE_RULER  = 1;
    const OFFICER_TYPE_OFFICER = 2;
    
    const FACE_RULER_MALE_MIN = 231;
    const FACE_RULER_MALE_MAX = 238;
    const FACE_RULER_FEMALE_MIN = 239;
    const FACE_RULER_FEMALE_MAX = 246;
    
    const FACE_OFFICER_MALE_MIN = 247;
    const FACE_OFFICER_MALE_MAX = 276;
    const FACE_OFFICER_FEMALE_MIN = 277;
    const FACE_OFFICER_FEMALE_MAX = 306;
    
    const GENDER_FEMALE = 0;
    const GENDER_MALE = 1;
    
    public $face;
    
    public $gender;
    
    public $abilityArC = 0xFF;
    
    public $abilityNaC = 0xFF;
    
    public $abilityWar = 0xFF;
    
    public $abilityInt = 0xFF;
    
    public $abilityPol = 0xFF;
    
    public $abilityCha = 0xFF;
    
    public $birthMonth;
    
    public $birthDay;
    
    public $age;
    
    public $name;
 
    public function toByteString()
    {
        $result = '';
        $zero = pack('C', 0);
        // Byte 1-2: Face
        $result .= pack('S', $this->face);
        // Byte 3: Zero
        $result .= $zero;
        // Byte 4: Gender (0: Female, 1: Male)
        $result .= pack('C', $this->gender);
        // Byte 5: ArC
        $result .= pack('C', $this->abilityArC);
        // Byte 6: NaC
        $result .= pack('C', $this->abilityNaC);
        // Byte 7: Wa
        $result .= pack('C', $this->abilityWar);
        // Byte 8: Int
        $result .= pack('C', $this->abilityInt);
        // Byte 9: Pol
        $result .= pack('C', $this->abilityPol);
        // Byte 10: Cha
        $result .= pack('C', $this->abilityCha);
        // Byte 11: Birth month
        $result .= pack('C', $this->birthMonth);
        // Byte 12: Birth day
        $result .= pack('C', $this->birthDay);
        // Byte 13: Age
        $result .= pack('C', $this->age);
        // Byte 14-25 (12 bytes): Name
        $result .= str_pad($this->name, 12, $zero);
        // Byte 26-28: Zero.
        $result .= $zero . $zero . $zero;
        
        return $result;
    }
}