<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 09/02/2019
 * Time: 19:47
 */

namespace App\Http\Controllers\section;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TodoListController extends Controller
{

    private $tableName_todolists_personal = "todolists_personal";
    private $tableName_todolists_section = "todolists_section";

    public function index(){

        $users = DB::table('users')->select('name')->get()->toArray();
        $sections = DB::table('sections')->select('section_name')->orderBy('section_id', 'asc')->get()->toArray();

        $todolists_personal = $this->getTodolists($this->tableName_todolists_personal);
        $todolists_sections = $this->getTodolists($this->tableName_todolists_section);

        for($i = 0; $i < count($users); $i++) {
            $users[$i] = $users[$i]->name;
        }

        for($i = 0; $i < count($sections); $i++) {
            $sections[$i] = $sections[$i]->section_name;
        }

        usort($users, "strnatcasecmp");

        //Définit le maximum de caractères affichés dans un card
        $maxCharactersLength = 200;

        //Définit le nombre d'entrées maximales à afficher pour les todolists personnelles
        $maxTodolistsEntries_Personal = 20;

        //Définit le nombre d'entrées maximales à afficher pour les todolists de section
        $maxTodolistsEntries_Section = 20;

        //Utiliser la fonction explode() pour récupérer tous les utilisateurs à qui la todolist à été envoyée

        return view('section.todolist', [
            "Todolists_Personal" => $todolists_personal,
            "Todolists_Section" => $todolists_sections,
            "Users" => $users,
            "Sections" => $sections,
            "MaxCharactersLength" => $maxCharactersLength,
            "MaxEntries_Personal" => $maxTodolistsEntries_Personal,
            "MaxEntries_Section" => $maxTodolistsEntries_Section
            ]);
    }

    private function getTodolists($Personal_OR_Section){

        $todoLists = DB::table($Personal_OR_Section)->orderBy('id', 'desc')->get();

        $todoList = array();

        foreach ($todoLists as $i => $row) {
            $row->author = ConverterController::convertIDPseudo($row->author);
            $row->receivers = explode(',', $row->receivers);

            $todoList[$i]['id'] = $row->id;
            $todoList[$i]['author'] = $row->author;
            $todoList[$i]['title'] = $row->title;
            $todoList[$i]['content'] = $row->content;
            $todoList[$i]['started_at'] = $row->started_at;
            $todoList[$i]['deadline'] = $row->deadline;
            $todoList[$i]['priority'] = $row->priority;
            $todoList[$i]['receivers'] = $row->receivers;
            $todoList[$i]['receivers_done'] = $row->receivers_done;

            foreach($todoList[$i]['receivers'] as $j => $row2) {
                if ($Personal_OR_Section == $this->tableName_todolists_personal){
                    $row2 = ConverterController::convertIDPseudo($row2);
                }

                elseif($Personal_OR_Section == $this->tableName_todolists_section){
                    $row2 = ConverterController::convertIDSection($row2);
                }

                $todoList[$i]['receivers'][$j] = $row2;
            }
        }

        return $todoList;
    }
    /*
         id INT 255 PRIMARY AUTO_INCREMENT
         author VARCHAR 255
         title VARCHAR 255
         content LONGTEXT
         deadline DATE
         priority INT 255
         receivers LONGTEXT
         */

    public function createOrModifyTodo(){

        //Utiliser la fonction implode() pour créer un string à partir de l'array receivers

        if(isset($_POST['comesFrom'])){

            if(isset($_POST['receivers'])) {

                foreach ($_POST['receivers'] as $i => $receiver) {

                    if($_POST['personalOrSection'] == "personal"){
                        $_POST["receivers"][$i] = strip_tags(NotificationsController::convertPseudoId($receiver));
                    }

                    else {
                        $_POST["receivers"][$i] = strip_tags(ConverterController::convertSectionID($receiver));
                    }
                }
            }

            if($_POST['comesFrom'] == "create") {

                if($_POST['personalOrSection'] == "personal"){
                    $table = $this->tableName_todolists_personal;
                }

                else {
                    $table = $this->tableName_todolists_section;
                }

                DB::table($table)->insert([
                    'title' => substr(strip_tags($_POST['title']), 0, 254),
                    'author' => Auth::user()->id,
                    'content' => strip_tags($_POST['content']),
                    'started_at' => NOW(),
                    'deadline' => strip_tags($_POST['deadline']),
                    'priority' => strip_tags($_POST['priority']),
                    'receivers' => implode(",", $_POST["receivers"])
                ]);

                if($_POST['personalOrSection'] == "personal") {
                    foreach ($_POST["receivers"] as $receiver) {
                        DB::table('notifications')->insert([
                            'user_id' => $receiver,
                            'title' => "Todolist",
                            "text" => "Vous avez été affecté à une nouvelle todolist personnelle, allez voir votre panel",
                            "link" => "http://manager.badblock.fr/profil/todolists",
                            "created_at" => NOW(),
                            "active" => 1
                        ]);
                    }
                }

                elseif($_POST['personalOrSection'] == "section"){

                    foreach($_POST["receivers"] as $receiver){

                        $usersInReceivers = DB::table('section_users')->where('section_id', $receiver)->get();

                        foreach ($usersInReceivers as $user){
                            DB::table('notifications')->insert([
                                'user_id' => $user->user_id,
                                'title' => "Todolist",
                                "text" => "Vous avez été affecté à une nouvelle todolist de section, allez voir votre panel",
                                "link" => "http://manager.badblock.fr/profil/todolists",
                                "created_at" => NOW(),
                                "active" => 1
                            ]);
                        }

                    }

                }
            }

            elseif($_POST['comesFrom'] == "modify"){

                if($_POST['personalOrSection'] == "personal"){
                    $table = $this->tableName_todolists_personal;
                }

                else {
                    $table = $this->tableName_todolists_section;
                }

                DB::table($table)->where('id', strip_tags($_POST['todoID']))->update([
                    'title' => substr(strip_tags($_POST['title']), 0, 254),
                    'author' => Auth::user()->id,
                    'content' => strip_tags($_POST['content']),
                    'started_at' => NOW(),
                    'deadline' => strip_tags($_POST['deadline']),
                    'priority' => strip_tags($_POST['priority']),
                    'receivers' => implode(",", $_POST["receivers"])
                ]);
            }

            elseif($_POST['comesFrom'] == "delete"){

                if($_POST['personalOrSection'] == "personal"){
                    $table = $this->tableName_todolists_personal;
                }

                else {
                    $table = $this->tableName_todolists_section;
                }

                DB::table($table)->where('id', strip_tags($_POST['todoID']))->delete();
            }

        }

    }
}