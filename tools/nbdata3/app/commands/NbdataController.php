<?php
namespace app\commands;

use app\models\Officer;
use Yii;
use yii\console\Controller;

class NbdataController extends Controller
{
    /**
     * @var integer[]
     */
    private static $genders = [Officer::GENDER_FEMALE, Officer::GENDER_MALE];
    
    /**
     * @var integer[][][]
     */
    private static $faceRanges = [
        Officer::OFFICER_TYPE_RULER => [
            Officer::GENDER_MALE => [Officer::FACE_RULER_MALE_MIN, Officer::FACE_RULER_MALE_MAX],
            Officer::GENDER_FEMALE => [Officer::FACE_RULER_FEMALE_MIN, Officer::FACE_RULER_FEMALE_MAX],
        ],
        Officer::OFFICER_TYPE_OFFICER => [
            Officer::GENDER_MALE => [Officer::FACE_OFFICER_MALE_MIN, Officer::FACE_OFFICER_MALE_MAX],
            Officer::GENDER_FEMALE => [Officer::FACE_OFFICER_FEMALE_MIN, Officer::FACE_OFFICER_FEMALE_MAX],
        ],
    ];
    
    /**
     * Syntax:
     * ./yii nbdata/gen-randomly
     */
    public function actionGenRandomly()
    {
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
            $people = $this->genPeople(Officer::OFFICER_TYPE_RULER, "Rulers $i");
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
        for ($i = 1; $i <= 8; $i++) {
            $people = $this->genPeople(Officer::OFFICER_TYPE_OFFICER, "Officers $i");
            $results[] = $people;
        }
        return $results;
    }
    
    /**
     * @param integer $officerType Officer_OFFICER_TYPE_XXX
     * @param string $name
     * @param integer $gender
     * @param integer $face
     * @return \app\models\Officer
     */
    private function genPeople($officerType, $name, $gender = NULL, $face = NULL)
    {
        $result = new Officer();
        $result->name = $name;
        if (!$gender) {
            $result->gender = self::$genders[array_rand(self::$genders)];
        }
        if (!$face) {
            $faceRange = self::$faceRanges[$officerType][$result->gender];
            $result->face = rand($faceRange[0], $faceRange[1]);
        }
        return $result;
    }
}
