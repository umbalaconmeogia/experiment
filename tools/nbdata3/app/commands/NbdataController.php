<?php
namespace app\commands;

use app\models\Officer;
use Yii;
use yii\console\Controller;

class NbdataController extends Controller
{
 
    /**
     * @var integer[][]
     */
    private static $beautyFaces = [
        Officer::OFFICER_TYPE_RULER => [
            235,
            240,
            244,
        ],
        Officer::OFFICER_TYPE_OFFICER => [
            287,
            305,
            296,
            290,
            302,
            300,
            282,
            291,
            301,
        ],        
    ];
    
    /**
     * @var integer[][][]
     */
    private static $faceRangeDefinition = [
        Officer::OFFICER_TYPE_RULER => [
            Officer::GENDER_MALE => [Officer::FACE_RULER_MALE_MIN, Officer::FACE_RULER_MALE_MAX],
            Officer::GENDER_FEMALE => [Officer::FACE_RULER_FEMALE_MIN, Officer::FACE_RULER_FEMALE_MAX],
        ],
        Officer::OFFICER_TYPE_OFFICER => [
            Officer::GENDER_MALE => [Officer::FACE_OFFICER_MALE_MIN, Officer::FACE_OFFICER_MALE_MAX],
            Officer::GENDER_FEMALE => [Officer::FACE_OFFICER_FEMALE_MIN, Officer::FACE_OFFICER_FEMALE_MAX],
        ],
    ];
    
    private static $officerTypes = [
        Officer::OFFICER_TYPE_RULER,
        Officer::OFFICER_TYPE_OFFICER,
    ];
    
    private static $genders = [
        Officer::GENDER_MALE,
        Officer::GENDER_FEMALE,
    ];
    
    private $faceGenders = [
        Officer::OFFICER_TYPE_RULER => [],
        Officer::OFFICER_TYPE_OFFICER => [],
    ];

    public function init()
    {
        parent::init();
        $this->genFaceGenders();
    }
    
    private function genFaceGenders()
    {
        foreach (self::$officerTypes as $officerType) {
            // Create a list that map face => gender for this $officerType.
            $faceGenderMapping = [];
            foreach (self::$genders as $gender) {
                $faceRange = self::$faceRangeDefinition[$officerType][$gender];
                for ($face = $faceRange[0]; $face <= $faceRange[1]; $face++) {
                    $faceGenderMapping[$face] = $gender;
                }
            }
            // Set to $faceGenders.
            $this->faceGenders[$officerType] = $faceGenderMapping;
        }
    }
    
    /**
     * Syntax:
     * ./yii nbdata/gen-randomly
     */
    public function actionGenRandomly()
    {
        srand();
        $rulers = $this->createRulers();
        $officers = $this->createOfficers();
        
        $file = Yii::getAlias(Yii::$app->params['nbdataFile']);
        $f = fopen($file, 'w');
        foreach (array_merge($rulers, $officers) as $officer) {
            fwrite($f, $officer->toByteString());
        }
        fclose($f);
    }
    
    /**
     * @return \app\models\Officer[]
     */
    private function createRulers()
    {
        $results = [];
        for ($i = 1; $i <= 8; $i++) {
            $people = $this->genPeople(Officer::OFFICER_TYPE_RULER, $i);
            $results[] = $people;
        }
        return $results;
    }

    /**
     * @return \app\models\Officer[]
     */
    private function createOfficers()
    {
        $results = [];
        for ($i = 1; $i <= 60; $i++) {
            $people = $this->genPeople(Officer::OFFICER_TYPE_OFFICER, $i);
            $results[] = $people;
        }
        return $results;
    }
    
    /**
     * @param integer $officerType Officer_OFFICER_TYPE_SSS
     * @param integer $peopleIndex
     * @return \app\models\Officer
     */
    private function genPeople($officerType, $peopleIndex)
    {
        $result = new Officer();
        $result->name = $officerType == Officer::OFFICER_TYPE_RULER ? "Ruler $peopleIndex" : "Officer $peopleIndex";
        $result->birthMonth = rand(1, 12);
        $result->birthDay = rand(1, 31);
        $result->age = rand(1, 5);
        if (isset(self::$beautyFaces[$officerType][$peopleIndex - 1])) {
            $face = self::$beautyFaces[$officerType][$peopleIndex - 1];
        } else {
            $face = array_rand($this->faceGenders[$officerType]);
        }
        $result->gender = $this->faceGenders[$officerType][$face];
        $result->face = $face;

        return $result;
    }
}
