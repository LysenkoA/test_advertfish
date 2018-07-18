<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 *
 * @property RelNewsCategory[] $relNewsCategories
 * @property News[] $news
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
            'imageFile' => 'Image file',
        ];
    }

    /**
     *
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->deleteImage();
    }

    /**
     * delete image
     */
    public function deleteImage()
    {
        // delete image
        if ($this->image != '' && file_exists (Yii::getAlias('@frontend').'/web' . $this->image)) {
            unlink(Yii::getAlias('@frontend').'/web' . $this->image);
        }
    }

    /**
     * upload image
     * @return string
     */
    public function upload()
    {
        if ($this->validate() && $this->imageFile) {
            if ($this->imageFile && $this->image != '') {
                $this->deleteImage();
            }
            $image = uniqid();
            $this->imageFile->saveAs(Yii::getAlias('@frontend').'/web/uploads/' . $image . '.' . $this->imageFile->extension);
            return '/uploads/'.$image.'.'.$this->imageFile->extension;
        } else {
            return $this->image;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelNewsCategories()
    {
        return $this->hasMany(RelNewsCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('rel_news_category', ['category_id' => 'id']);
    }
}
