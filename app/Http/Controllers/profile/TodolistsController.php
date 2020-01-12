<?php
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 13/02/2019
 * Time: 16:54
 */

namespace App\Http\Controllers\profile;


use App\Http\Controllers\ConverterController;
use App\Http\Controllers\section\NotificationsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodolistsController
{


    private $tableName_todolists_personal = "todolists_personal";
    private $tableName_todolists_section = "todolists_section";

    public function index(){

        $user_name = Auth::user()->name;
        $user_section = DB::table('section_users')->where('user_id', NotificationsController::convertPseudoId($user_name))->get();
        $user_section = ConverterController::convertIDSection($user_section[0]->section_id);

        $todolists_personal = $this->getTodolists($this->tableName_todolists_personal);
        $todolists_sections = $this->getTodolists($this->tableName_todolists_section);

        //Définit le maximum de caractères affichés dans un card
        $maxCharactersLength = 200;

        //Définit le nombre d'entrées maximales à afficher pour les todolists personnelles
        $maxTodolistsEntries_Personal = 20;

        //Définit le nombre d'entrées maximales à afficher pour les todolists de section
        $maxTodolistsEntries_Section = 20;

        return view('profil.todolists', [
            "Todolists_Personal" => $todolists_personal,
            "Todolists_Section" => $todolists_sections,
            "UserID" => $user_name,
            "UserSection" => $user_section,
            "MaxTodolistsEntries_Personal" => $maxTodolistsEntries_Personal,
            "MaxTodolistsEntries_Section" => $maxTodolistsEntries_Section,
            "MaxCharactersLength" => $maxCharactersLength
        ]);

    }

    private function getTodolists($Personal_OR_Section){

        $todoLists = DB::table($Personal_OR_Section)->orderBy('id', 'desc')->get();

        $todoList = array();

        foreach ($todoLists as $i => $row) {
            $row->author = ConverterController::convertIDPseudo($row->author);
            $row->receivers = explode(',', $row->receivers);
            $row->receivers_done = explode(',', $row->receivers_done);

            $todoList[$i]['id'] = $row->id;
            $todoList[$i]['author'] = $row->author;
            $todoList[$i]['title'] = $row->title;
            $todoList[$i]['content'] = $row->content;
            $todoList[$i]['started_at'] = $row->started_at;
            $todoList[$i]['deadline'] = $row->deadline;
            $todoList[$i]['priority'] = $row->priority;
            $todoList[$i]['receivers'] = $row->receivers;
            $todoList[$i]['receivers_done'] = $row->receivers_done;

            if($todoList[$i]['receivers_done'] == null){
                $todoList[$i]['receivers_done'][0] = 0;
            }

            foreach($todoList[$i]['receivers'] as $j => $row2) {
                if ($Personal_OR_Section == $this->tableName_todolists_personal){
                    $row2 = ConverterController::convertIDPseudo($row2);
                }

                elseif($Personal_OR_Section == $this->tableName_todolists_section){
                    $row2 = ConverterController::convertIDSection($row2);
                }

                $todoList[$i]['receivers'][$j] = $row2;
            }

            foreach($todoList[$i]['receivers_done'] as $j => $row3) {
                if ($Personal_OR_Section == $this->tableName_todolists_personal){
                    $row3 = ConverterController::convertIDPseudo($row3);
                }

                elseif($Personal_OR_Section == $this->tableName_todolists_section){
                    $row3 = ConverterController::convertIDSection($row3);
                }

                $todoList[$i]['receivers_done'][$j] = $row3;
            }
        }

        return $todoList;
    }

    public function done(){

        if(isset($_POST)){
            if(isset($_POST['todoID'])){

                $currentTodo = DB::table('todolists')->where('id', strip_tags($_POST['todoID']))->get();

                if(strlen($currentTodo[0]->receivers_done) == 0){
                    $doneReceiverToInsert = Auth::user()->id;
                }
                else {
                    $doneReceiverToInsert = $currentTodo[0]->receivers_done.", ".Auth::user()->id;
                }

                DB::table('todolists')->where('id', strip_tags($_POST['todoID']))->update([
                   "receivers_done" => $doneReceiverToInsert
                ]);

                DB::table('notifications')->insert([
                    "user_id" => $currentTodo[0]->author,
                    "title" => "Todolist",
                    "text" => Auth::user()->name." a annoncé avoir fini la tâche todolist que vous lui avez assigné",
                    "created_at" => NOW()
                ]);
            }
        }

    }
}
