<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class DownloadModel extends AppModel
{

    public function getCountFiles(): int
    {
        return R::count('digital');
    }

    public function getFiles($startID, $perPage, $lang): array
    {
        return R::getAll("SELECT d.*, dd.* FROM shop.digital d 
                        JOIN shop.digital_description dd on d.id = dd.digital_id
                        WHERE dd.language_id = ? ORDER BY d.id LIMIT ?,?", [$lang['id'], $startID, $perPage]);
    }

    public function validateFileUpload(): bool
    {
        $errors = '';
        foreach ($_POST['digital_description'] as $key => $item) {
            if (empty(trim($item['name']))) {
                $errors .= "Не заполнено Наименование №{$key}!<br>";
            }
        }

        if (empty($_FILES) || $_FILES['file']['error']) {
            $errors .= "Не выбран файл для загрузки!<br>";
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            return false;
        }
        return true;
    }

    public function saveFile(): bool
    {
        R::begin();
        try {
            $originalName = $_FILES["file"]["name"];
            $newFileName = $this->generateSecretUniqFilename($originalName);
            $pathTo = WWW . '/downloads/' . $newFileName;
//            debug($pathTo,1);
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $pathTo)) {
                throw new \Exception("Ошибка сохранения файла");
            }

            $digital = R::dispense('digital');
            $digital->filename = $newFileName;
            $digital->original_name = $originalName;
            $digital_id = R::store($digital);

            foreach ($_POST['digital_description'] as $langId => $item) {
                R::exec("INSERT INTO digital_description (digital_id, language_id, name) VALUES (?,?,?)",
                    [$digital_id, $langId, trim($item['name'])]);
            }

            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            return false;
        }
    }

    protected function generateSecretUniqFilename($filename): string
    {
        $newUniqName = $filename . '.' . uniqid();
        if (!$this->isUniq($newUniqName)) {
            $newUniqName = $this->generateSecretUniqFilename($filename);
        }
        return $newUniqName;
    }

    protected function isUniq($filename): bool
    {
        return !(bool)R::count('digital', 'filename = ?', [$filename]);
    }

    public function delete( $id):bool
    {
        R::begin();
        try {
            $product_id = R::getCell("SELECT product_id FROM shop.product_digital pd WHERE pd.digital_id = ?", [$id]);
            if($product_id){
                throw new \Exception("Данный цифровой товар прикреплен к товару с ID = {$product_id}");
            }

            $fileName = R::getCell("SELECT filename FROM shop.digital d WHERE d.id = ?", [$id]);
            $path = WWW . '/downloads/' . $fileName;
            if(!file_exists($path)){
                throw new \Exception("Файл по пути: {$path} не найден");
            }
            if(!unlink($path)){
                throw new \Exception('Ошибка удаления файла');
            }


            R::exec('DELETE FROM digital_description WHERE digital_id = ?', [$id]);
            R::exec('DELETE FROM digital WHERE id = ?', [$id]);


            R::commit();
            return true;
        } catch (\Exception $e) {
            R::rollback();
            $_SESSION['errors'] = $e->getMessage();
            return false;
        }
    }
}