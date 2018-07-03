<?php

namespace app\models;

use batsg\models\BaseBatsgModel;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $data_status
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 * @property string $uuid
 * @property string $name
 */
class CompanyApi extends Company
{
	public function fields()
	{
		return [
			'uuid',
			'name',
		];
	}
}
