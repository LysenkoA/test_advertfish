<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $body
 * @property string $image
 * @property string $date
 * @property int $status
 *
 * @property RelNewsAuthor[] $relNewsAuthors
 * @property Author[] $authors
 * @property RelNewsCategory[] $relNewsCategories
 * @property Category[] $categories
 */
class News extends \yii\db\ActiveRecord
{
    public $categoriesList = [];
    public $authorsList = [];
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description', 'body'], 'string'],
            [['date'], 'safe'],
            [['status'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            ['categoriesList', 'each', 'rule' => ['integer']],
            ['authorsList', 'each', 'rule' => ['integer']],
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
            'title' => 'Title',
            'description' => 'Description',
            'body' => 'Body',
            'image' => 'Image',
            'date' => 'Date',
            'status' => 'Status',
            'categoriesList' => 'Categories',
            'authorsList' => 'Authors',
            'imageFile' => 'Image file',
        ];
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        // add/delete category
        $categoriesIds = ($this->categoriesList) ? $this->categoriesList : [];
        $relCategories = $this->getRelNewsCategories()->all();
        foreach ($relCategories as $relCategory) {
            if (in_array($relCategory->category_id, $categoriesIds)) {
                unset($categoriesIds[array_search($relCategory->category_id, $categoriesIds)]);
            } else {
                $relCategory->delete();
            }
        }

        foreach ($categoriesIds as $catId) {
            $catagoryRel = new RelNewsCategory();
            $catagoryRel->news_id = $this->id;
            $catagoryRel->category_id = $catId;
            $catagoryRel->save();
        }

        // add/delete author
        $authorsIds = ($this->authorsList) ? $this->authorsList : [];
        $relAuthors = $this->getRelNewsAuthors()->all();
        foreach ($relAuthors as $relAuthor) {
            if (in_array($relAuthor->author_id, $authorsIds)) {
                unset($authorsIds[array_search($relAuthor->author_id, $authorsIds)]);
            } else {
                $relAuthor->delete();
            }
        }

        foreach ($authorsIds as $aId) {
            $nrelAuthor = new RelNewsAuthor();
            $nrelAuthor->news_id = $this->id;
            $nrelAuthor->author_id = $aId;
            $nrelAuthor->save();
        }

    }

    public function afterDelete()
    {
        parent::afterDelete();

        // delete rel categories
        RelNewsCategory::deleteAll(['news_id' => $this->id]);

        // delete rel authors
        RelNewsAuthor::deleteAll(['news_id' => $this->id]);

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
                if( file_exists (Yii::getAlias('@frontend').'/web' . $this->image) ) {
                    unlink(Yii::getAlias('@frontend').'/web' . $this->image);
                }
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
    public function getRelNewsAuthors()
    {
        return $this->hasMany(RelNewsAuthor::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])->viaTable('rel_news_author', ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelNewsCategories()
    {
        return $this->hasMany(RelNewsCategory::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('rel_news_category', ['news_id' => 'id']);
    }
}
