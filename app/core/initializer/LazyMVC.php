<?php

namespace App\core\initializer;

use App\Models\User;

class LazyMVC {

    private $template = 'twig';

    public function __constructor() {
        $this->template = $_ENV['sys_view'];
    }


    public static function controller($model_name, $table, $controller_name, $controller_path, array $db_columns) {
        $ControllerFile = fopen($controller_path, "a");


        $controller_content =
            "<?php

              namespace App\Controllers;
              use App\Controllers\Controller;
              use App\Models\\$model_name;
              class $controller_name extends Controller  {
                
                   public function index() {
                       " . '$values' . " = (new $model_name)->last(10);
                        echo " . '$this' . "->view('$table/index.twig', [
                        'title' => '$table',
                        '$table' => " . '$values' . "
                        ]);
                   }
                   
                   public function show()  {
                
                   }
                   public function create() {
                
                   }
                   public function save() {
                
                   }
                   public function edit() {
                   
                   }
                   public function update() {
                   
                   }
                   public function explode(){
                
                   }
                   
                
               }";


        fwrite($ControllerFile, "\n" . $controller_content);
        fclose($ControllerFile);

    }

    public static function model($model_name, $table, $model_path, array $db_columns) {
        $ModelFile = fopen($model_path, "a");

        $model_content =
            "<?php

              namespace App\Models;
              use App\Models\Model;
                
             
                class $model_name extends Model {
                protected " . '$table' . " = '$table';         
                protected array " . '$data' . " = " . json_encode(array_column($db_columns, 'COLUMN_NAME')) . ";
                           
                           }

               ";


        fwrite($ModelFile, "\n" . $model_content);
        fclose($ModelFile);

    }

    public function views($model_name, $table, $view_path, array $db_columns) {
        // Create main view directory if not exists
        if (!file_exists($view_path)) {
            mkdir($view_path, 0777, true);
        }
        // Index
        $ViewsFile = fopen($view_path . 'index.twig', "a");
        $BaseIndex = file_get_contents(__DIR__ . '/base/views/index.twig');

        $ConvertedIndex = $BaseIndex;

        $view_content = $ConvertedIndex;

        fwrite($ViewsFile, "\n" . $view_content);
        fclose($ViewsFile);

        // Show Single Item

        // Create form base on model data

        // Edit form based on single item and model data
    }
}