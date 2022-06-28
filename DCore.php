<?


/**
 * DCore 
 * developer tools for every day
 *
 * git clone https://github.com/DPechurkin/tools.git
 * include_once('tools/DCore.php');
 * 
 */
class DCore
{	
	static $path_files= '/files_log/';

    /**
     * функция сохранения данных в вайл , может перезаписывать или добавлять данные в файл
     * @param $data - object данные которые нужно записать в виде строки или обьекта
     * @param string $file - string путь и название файла относительно папки экспортов
     * @param bool $serial - boolean переводить обьект в строку посредство кодирования в json
     * @param bool $file_append - boolean добавлять данные в файл
     * @return string
     */
    static function saveData($data, $file = '', $serial = false, $file_append = false) {
        $file = $file == '' ? 'log_default.txt' : $file;
        if ($serial) $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $path = DCore::$path_files . $file;
        DCore::checkPath($path);
        if ($file_append)
            file_put_contents($path, $data . PHP_EOL, FILE_APPEND);
        else
            file_put_contents($path, $data);

        return 'data writed done';
    }

    /**
     * функция получения данных из файла
     * @param string $file - string путь до файла
     * @param bool $serial - boolean декодировать строку из json
     * @return false|mixed|string
     */
    static function getData($file = '', $serial = false) {
        $file = $file == '' ? 'log_default.txt' : $file;
        $path = DCore::$path_files . $file;
        $data = file_get_contents($path);
        if ($serial) $data = json_decode($data);
        return $data;
    }

    /**
     * функция проверяет и создаёт папки если их нет для сохранения данных в файл
     * @param $path - string относительный путь
     * @return bool
     */
    static function checkPath($path) {
        $arPath = explode('/', $path);
        $testPath = '';
        $end = count($arPath) - 1;
        foreach ($arPath as $level => $dir) {
            if ($testPath == '') {
                $testPath = $dir;
            } else {
                if ($end > $level)
                    $testPath .= '/' . $dir;
            }
        }
        if (!is_dir($testPath)) {
            mkdir($testPath, 0775, true);
        }
        return true;
    }

    /**
     * функция для вывода данных в командную строку для отображение хода выполнения скрипта
     * @param String $type - строка. служит для определения типа выводимового сообщения
     * @param String $message - служит для вывода сообщения
     * @param bool $rewrite - условный параметр для вывода символа перевода строки в конце сообщения или вывода символа очищения текущей строки от сообщения,
     *                        используется для вывода сообщений об ожидании ответа от запроса к апи
     */
    public function eLog($type,$message,$rewrite = false){
        echo date("Y.m.d H:i:s").' '.$type .' '.$message.($rewrite? "\r":PHP_EOL);
    }

    /**
     * функция генерации уникального строки
     * @param int $lenght - длинна уникальной строки
     * @return bool|string - возвращает уникальную строку которую можно использовать как уникальный индетификатор
     * @throws Exception - выдает ошибку в случае если нет необходимой библиотеки
     */
    public function uniqidReal($lenght = 13) {
        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}