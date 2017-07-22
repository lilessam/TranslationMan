<?php

namespace Lilessam\Translationman\Controllers;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lang;

class MainController extends Controller
{
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {

        $langs           = $this->getLangs();
        $files           = $this->getLangFiles($langs);
        $allTranslations = $this->allTranslations($langs);

        return view('translationman::index')->withLangs($langs)->withFiles($files)->withTranslations($allTranslations);
    }

    public function getLangs()
    {
        return $this->listFolders(App::langPath());
    }

    public function listFolders($dir)
    {
        $dh     = scandir($dir);
        $return = array();

        foreach ($dh as $folder) {
            if ($folder != '.' && $folder != '..') {
                if (is_dir($dir . '/' . $folder)) {
                    $return[] = $folder;
                }
            }
        }
        return $return;
    }

    public function allTranslations($langs)
    {
        $return = [];
        foreach ($langs as $lang) {
            $files = $this->getFilesWithoutEx(array_diff(scandir(App::langPath() . '/' . $lang), ['.', '..']));
            foreach ($files as $file) {
                if (is_array(Lang::get($file))) {
                    foreach (Lang::get($file) as $key => $value) {
                        $return[$lang][$file][$key] = $value;
                    }
                }
            }
        }

        return $return;
    }

    public function getFilesWithoutEx($array)
    {
        $return = [];
        foreach ($array as $file) {
            $return[] = explode('.', $file)[0];
        }

        return $return;
    }

    public function getLangFiles($langs)
    {
        $return = [];
        foreach ($langs as $lang) {
            $files = glob(App::langPath() . '/' . $lang . '/*');
            if (empty($files)) {
                continue;
            }

            $files = $this->getFilesWithoutEx(array_diff(scandir(App::langPath() . '/' . $lang), ['.', '..']));
            foreach ($files as $file) {
                $return[$lang][] = $file;
            }
        }

        return $return;
    }

    public function showLang($lang)
    {
        $langs = $this->getLangs();
        $files = $this->getLangFiles($langs);
        $files = isset($files[$lang]) ? $files[$lang] : null;

        return view('translationman::lang')->withLang($lang)->withFiles($files);
    }

    public function showFile($lang, $file)
    {
        $rows = $this->getRowsCode($lang, $file);
        return view('translationman::file')->withLang($lang)->withFile($file)->withRows($rows);
    }

    public function getRowsCode($lang, $file, $array = null, $baseKey = null)
    {
        $code = '';

        if (isset($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $code .= $this->getRowsCode($lang, $file, $value, $baseKey . '.' . $key);
                    continue;
                }

                //$code .= $baseKey.'.'.$key . ' => ' . $value.'<br>';
                $code .= '<tr class="input-row">';
                $code .= '<td><input class="form-control" type="text" name="keys[]" value="' . $baseKey . '.' . $key . '"></td>';
                $code .= '<td><input class="form-control" type="text" name="values[]" value="' . $value . '"></td>';
                $code .= '<td><button type="button" class="delete-row btn btn-danger">×</button></td>';
                $code .= '</tr>';

            }
            return $code;
        }

        if (is_array(Lang::get($file, [], $lang))):
            foreach (Lang::get($file, [], $lang) as $key => $value) {

                if (is_array($value)) {
                    $code .= $this->getRowsCode($lang, $file, $value, $key);
                    continue;
                }

                //$code .= $key . ' => ' . $value.'<br>';
                $code .= '<tr class="input-row">';
                $code .= '<td><input class="form-control" type="text" name="keys[]" value="' . $key . '"></td>';
                $code .= '<td><input class="form-control" type="text" name="values[]" value="' . $value . '"></td>';
                $code .= '<td><button class="delete-row btn btn-danger">×</button></td>';
                $code .= '</tr>';
            }

        endif;

        return $code;

    }

    public function saveFile($lang, $file, Request $request)
    {
        $array = $this->getFileArray($request->keys, $request->values);
        $this->setFileContent($lang, $file, $array);

        flash('The file has been saved !');
        return redirect()->back();
    }

    public function setFileContent($lang, $file, $array)
    {

        $content = "<?php return [
        ";
        $content .= $this->array2string($array);
        $content .= "];";

        file_put_contents(App::langPath() . '/' . $lang . '/' . $file . '.php', $content);
    }

    public function array2string($data)
    {
        $log_a = "";
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $log_a .= "'" . $key . "' => [
                \t" . $this->array2string($value) . "], \n";
            } else {
                $log_a .= "\t'" . $key . "' => '" . $value . "',\n";
            }

        }
        return $log_a;
    }

    public function getFileArray($keys, $values)
    {

        $array = [];
        foreach ($keys as $key => $value) {
            $array[$key]['key'] = $value;
        }
        foreach ($values as $key => $value) {
            $array[$key]['value'] = $value;
        }

        return $this->getFinalMDArray($array);
    }

    public function getFinalMDArray($array)
    {
        $return = [];
        foreach ($array as $value) {
            array_set($return, $value['key'], $value['value']);
        }

        return $return;
    }

    public function convertArrayToDots($exploded)
    {
        $return = '';
        foreach ($exploded as $key => $value) {
            $return = '.' . $value;
        }

        return $return;
    }

    public function getNewLang()
    {
        return view('translationman::newLang');
    }

    public function postNewLang(Request $request)
    {
        mkdir(App::langPath() . '/' . $request->name, 0777);
        return redirect()->route('translationman.index');
    }

    public function getNewFile($lang)
    {
        return view('translationman::newFile')->withLang($lang);
    }

    public function postNewFile($lang, Request $request)
    {
        $myfile = fopen(App::langPath() . '/' . $lang . '/' . $request->name . '.php', "w");
        $txt    = "<?php";
        fwrite($myfile, $txt);
        fclose($myfile);

        return redirect()->route('translationman.langFiles', ['lang' => $lang]);
    }

    public function postDeleteLang(Request $request)
    {
        $dir   = App::langPath() . DIRECTORY_SEPARATOR . $request->lang;
        $it    = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it,
            \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    public function postDeleteFile(Request $request)
    {
        $file = App::langPath() . DIRECTORY_SEPARATOR . $request->lang . DIRECTORY_SEPARATOR . $request->file . '.php';
        unlink($file);
    }

}
