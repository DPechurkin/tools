<? 


/**
 * DCore 
 * developer tools for every day
 *
 * git clone https://github.com/DPechurkin/tools.git
 * include_once('DCore.php');
 * 
 */
class DCore
{	

	//функция сохранения файлов 
	// data - данные которые нужно сохранить , файл массив строка, что угодно
	// file - названиеп файла под которым будет сохраненны данные
	// serial - нужно ли серрилизовать переменную для записи в файл , полезно если сохраняешь массивы после чтения файла производишь обратную сериализацию и у тебя готовая переменная
	// file_append - нужно ли добавлять данные к файлу, можно делать что то типа логов 
	static function SaveData($data, $file='' ,$serial=false,$file_append=false){
		$flag=false;
		if($data) $flag=true;
		if($serial) $data = serialize($data);

		$pach=$_SERVER['DOCUMENT_ROOT'].ClassConfig::$path_files.$file;
		if($flag){
			if($file_append)
				file_put_contents($pach, $data, FILE_APPEND);
			else 
				file_put_contents($pach, $data);
		} 
	}

	//функция извлечение информации из файлов 
	static function GetData($file='',$serial=false){
		$pach=$_SERVER['DOCUMENT_ROOT'].ClassConfig::$path_files.$file;
		$data=file_get_contents($pach);
		if($serial) $data = unserialize($data);
		return $data;
	}

	// функция проверки главной страницы, если в параметр передана строка, то функция вернёт её если это главная страница
	public function TM($str = null){
		global $APPLICATION;
		if ($str =='') 
		   $str = true ; 
		if ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php')
		   return $str;
		else 
		   return false;
	}

	// функция проверки что страница не главная, если в параметр передана строка, то функция вернёт её если это не главная страница
	public function TNM($str = null){
		global $APPLICATION;
		if ($str =='') 
		   $str = true ; 
		if ($APPLICATION->GetCurPage(true) != SITE_DIR.'index.php')
		   return $str;
		else 
		   return false;
	}
}