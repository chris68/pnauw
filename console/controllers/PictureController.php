<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Some internal commands to manage the pictures and users
 */
class PictureController extends Controller
{
    /**
     * Delete all guest users created more than 5 days ago but w/o public pictures
     */
    public function actionPurgeGuestUsers()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(
<<<SQL
        delete from
            tbl_user u
        where
            role = 11 and
            not exists (select 1 from tbl_picture p where p.owner_id = u.id and p.visibility_id='public') and
            create_time <= current_date - interval '5' day
SQL
        );

        $count = $command->execute();
        $this->stdout("$count guest users older than 5 days sucessfully purged\n", Console::FG_GREEN);
        return true;
    }

    /**
     * Hide all pics not modified since the last 3 years
     * Consolidate the larger formats to smaller ones (to small 1 year and to thumbnail 3 years after creation)
     */
    public function actionPurgePictures()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $connection = Yii::$app->getDb();

        try {
            $command1 = $connection->createCommand(
<<<SQL
        update
            tbl_picture p
        set
            visibility_id = 'private_hidden'
        where
            visibility_id != 'private_hidden' and
            modified_ts <= current_date - interval '3' year
SQL
            );

            $count1 = $command1->execute();

            $command2 = $connection->createCommand(
<<<SQL
        update
            tbl_picture p
        set
            original_image_id = small_image_id,
            medium_image_id = small_image_id,
            blurred_medium_image_id = blurred_small_image_id
        where
            created_ts <= current_date - interval '1' year and
            original_image_id != small_image_id
SQL
            );

            $count2 = $command2->execute();

            $command3 = $connection->createCommand(
<<<SQL
        update
            tbl_picture p
        set
            original_image_id = thumbnail_image_id,
            small_image_id  = thumbnail_image_id,
            medium_image_id = thumbnail_image_id,
            blurred_small_image_id = blurred_thumbnail_image_id,
            blurred_medium_image_id = blurred_thumbnail_image_id
        where
            created_ts <= current_date - interval '3' year and
            original_image_id != thumbnail_image_id
SQL
            );

            $count3 = $command3->execute();


            $command4 = $connection->createCommand(
<<<SQL
        delete from
            tbl_image i
        where
            not exists (
                select 1 from
                    tbl_picture p
                where
                    i.id = original_image_id or
                    i.id = small_image_id or
                    i.id = medium_image_id or
                    i.id = thumbnail_image_id or
                    i.id = blurred_small_image_id or
                    i.id = blurred_medium_image_id or
                    i.id = blurred_thumbnail_image_id
            )
SQL
            );

            $count4 = $command4->execute();



            $transaction->commit();

        } catch (Exception $ex) {
            $transaction->rollback();
            throw($ex);
        }
        
        $this->stdout("$count1 pictures not modified in the last 3 years sucessfully reset to visibility = 'private_hidden'\n", Console::FG_GREEN);
        $this->stdout("$count2 pictures created before 1 year sucessfully consolidated to size small\n", Console::FG_GREEN);
        $this->stdout("$count3 pictures created before 3 years sucessfully consolidated to size thumbnail\n", Console::FG_GREEN);
        $this->stdout("$count4 images no longer necessary sucessfully deleted\n", Console::FG_GREEN);
        return true;
    }
    
}