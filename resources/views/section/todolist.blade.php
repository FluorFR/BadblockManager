@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="content-page">
            <!-- Start content -->
        <div class="content">
            <div class="container">

                <h1>Gestion des todo-list</h1>
                <br />


                <h3>Quelle type de todolist souhaitez-vous manager ?</h3>

                <select id="todolists_typeSelector" class="form-control" onchange="changeTodoManagement()">
                    <option value="todolists_personal">Todolists personnelles</option>
                    <option value="todolists_section">Todolists de section</option>
                </select>

                <br /><br />

                <div id="todolists_personal">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todolists_personal_modal_create">Créer une todolist personnelle</button>

                    <div class="modal fade" id="todolists_personal_modal_create" tabindex="-1" role="dialog" aria-labelledby="Modal_create" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Créer la todolist</h5>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="todolists_personal_todo_title">Titre :</label>
                                            <input type="text" class="form-control" id="todolists_personal_todo_create_title" placeholder="Titre">
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_personal_todo_create_receiversList">Qui est concerné :</label>
                                            <select class="form-control" multiple="multiple" id="todolists_personal_todo_create_receiversList">
                                                @foreach($Users as $user)
                                                    <option value="{{ $user }}">{{ $user }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_personal_todo_create_content">Contenu :</label>
                                            <textarea class="form-control" id="todolists_personal_todo_create_content" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_personal_todo_create_deadline">Deadline (DD/MM/YYYY) :</label>
                                            <input type="date" class="form-control" id="todolists_personal_todo_create_deadline" />
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_personal_todo_create_priority">Priorité (entre 1 et 100) : </label><br />
                                            <input type="number" class="number" id="todolists_personal_todo_create_priority" min="0" max="100" value="1" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetCreateValues('personal');">Annuler</button>
                                    <button type="button" class="btn btn-primary" id="todolists_personal_todo_button_valid" data-dismiss="modal" onclick="updateOrCreateTodo('create', 'personal')">Créer la todolist</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br />
                    <br />

                    <div class="card-columns">
                        @foreach(array_slice($Todolists_Personal, 0, $MaxEntries_Personal) as $i => $row)

                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h3 class="card-title" id="todolists_personal_card_{{ $i }}_title">{{ $row['title'] }}</h3>
                                    <p class="card-text" id="card_{{ $i }}_content_display">{{ substr($row['content'], 0, $MaxCharactersLength) }}
                                        @if($row['content'] != substr($row['content'], 0, $MaxCharactersLength))
                                            ...
                                        @endif
                                    </p>
                                    <div style="display: none" id="todolists_personal_card_{{ $i }}_started_at">{{ $row['started_at'] }}</div>
                                    <h5 class="card-text" id="todolists_personal_card_{{ $i }}_priority">Deadline : {{ $row['deadline'] }}</h5>
                                    <h5 class="card-text" id="todolists_personal_card_{{ $i }}_priority">Priorité : {{ $row['priority'] }}</h5>

                                    <button class="btn btn-info"  data-toggle="modal" data-target="#todolists_personal_modal_edit_{{ $i }}">Modifier</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#todolists_personal_modal_{{ $i }}_deleteConfirm">Supprimer</button>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted" id="todolists_personal_card_{{ $i }}_author">Créateur : {{ $row['author'] }}</small><br />
                                    <small class="text-muted" id="todolists_personal_card_{{ $i }}_receivers">Personnes concernées :
                                    @foreach($row['receivers'] as $j => $receiver)
                                            {{ $receiver }}
                                            @if($j != count($row['receivers'])-1)
                                                ,
                                            @endif
                                    @endforeach
                                    </small>
                                </div>
                            </div>

                            <div class="modal fade" id="todolists_personal_modal_edit_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="todolists_personal_Modal_{{ $i }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier la todolist</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div id="todolists_personal_todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                <div class="form-group">
                                                    <label for="todolists_personal_todo_{{ $i }}_title">Titre :</label>
                                                    <input type="text" class="form-control" id="todolists_personal_todo_{{ $i }}_title" value="{{ $row['title'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_personal_{{ $i }}_receiversList">Qui est concerné :</label>
                                                    <select class="form-control" multiple="multiple" id="todolists_personal_todo_{{ $i }}_receiversList">
                                                        @foreach($Users as $user)
                                                            @if(in_array($user, $row['receivers']))
                                                                <option value="{{ $user }}" selected="selected">{{ $user }}</option>
                                                            @else
                                                                <option value="{{ $user }}">{{ $user }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_personal_todo_{{ $i }}_content">Contenu :</label>
                                                    <textarea class="form-control" id="todolists_personal_todo_{{ $i }}_content" rows="3">{{ $row['content'] }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_personal_todo_{{ $i }}_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                    <input type="date" class="form-control" id="todolists_personal_todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_personnal_todo_{{ $i }}_deadline">Deadline (DD/MM/YYYY) :</label>
                                                    <input type="date" class="form-control" id="todolists_personal_todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_personnal_todo_{{ $i }}_priority">Priorité (entre 1 et 100) : </label><br />
                                                    <input type="number" class="number" id="todolists_personal_todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-primary" id="todolists_personal_todo_button_valid" data-dismiss="modal" onclick="updateOrCreateTodo('{{ $i }}', 'personal')">Modifier la todolist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="todolists_personal_modal_{{ $i }}_deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="todolists_personal_Modal_{{ $i }}_deleteConfirm" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Supprimer la todolist</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Êtes-vous sûr ?</h3>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="todolists_personal_todo_button_delete" onclick="deleteTodo('{{ $row['id'] }}', 'personal')">Supprimer la todolist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    </div>

                </div>

                <div id="todolists_section" style="display: none">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todolists_section_modal_create">Créer une todolist de section</button>

                    <div class="modal fade" id="todolists_section_modal_create" tabindex="-1" role="dialog" aria-labelledby="todolists_section_Modal_create" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Créer la todolist</h5>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="todolists_section_todo_create_title">Titre :</label>
                                            <input type="text" class="form-control" id="todolists_section_todo_create_title" placeholder="Titre">
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_section_todo_create_receiversList">Qui est concerné :</label>
                                            <select class="form-control" multiple="multiple" id="todolists_section_todo_create_receiversList">
                                                @foreach($Sections as $section)
                                                    <option value="{{ $section }}">{{ $section }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_section_todo_create_content">Contenu :</label>
                                            <textarea class="form-control" id="todolists_section_todo_create_content" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_section_todo_create_deadline">Deadline (DD/MM/YYYY) :</label>
                                            <input type="date" class="form-control" id="todolists_section_todo_create_deadline" />
                                        </div>
                                        <div class="form-group">
                                            <label for="todolists_section_todo_create_priority">Priorité (entre 1 et 100) : </label><br />
                                            <input type="number" class="number" id="todolists_section_todo_create_priority" min="0" max="100" value="1" />
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetCreateValues('section');">Annuler</button>
                                    <button type="button" class="btn btn-primary" id="todo_button_valid" data-dismiss="modal" onclick="updateOrCreateTodo('create', 'section')">Créer la todolist</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br />
                    <br />

                    <div class="card-columns">
                        @foreach(array_slice($Todolists_Section, 0, $MaxEntries_Section) as $i => $row)

                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h3 class="card-title" id="todolists_section_card_{{ $i }}_title">{{ $row['title'] }}</h3>
                                    <p class="card-text" id="todolists_section_card_{{ $i }}_content_display">{{ substr($row['content'], 0, $MaxCharactersLength) }}
                                        @if($row['content'] != substr($row['content'], 0, $MaxCharactersLength))
                                            ...
                                        @endif
                                    </p>
                                    <div style="display: none" id="todolists_section_card_{{ $i }}_started_at">{{ $row['started_at'] }}</div>
                                    <h5 class="card-text" id="todolists_section_card_{{ $i }}_priority">Deadline : {{ $row['deadline'] }}</h5>
                                    <h5 class="card-text" id="todolists_section_card_{{ $i }}_priority">Priorité : {{ $row['priority'] }}</h5>

                                    <button class="btn btn-info"  data-toggle="modal" data-target="#todolists_section_modal_edit_{{ $i }}">Modifier</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#todolists_section_modal_{{ $i }}_deleteConfirm">Supprimer</button>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted" id="todolists_section_card_{{ $i }}_author">Créateur : {{ $row['author'] }}</small><br />
                                    <small class="text-muted" id="todolists_section_card_{{ $i }}_receivers">Sections concernées :
                                        @foreach($row['receivers'] as $j => $receiver)
                                            {{ $receiver }}
                                            @if($j != count($row['receivers'])-1)
                                                ,
                                            @endif
                                        @endforeach
                                    </small>
                                </div>
                            </div>

                            <div class="modal fade" id="todolists_section_modal_edit_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="todolists_section_Modal_edit_{{ $i }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier la todolist</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div id="todolists_section_todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_title">Titre :</label>
                                                    <input type="text" class="form-control" id="todolists_section_todo_{{ $i }}_title" value="{{ $row['title'] }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_receiversList">Qui est concerné :</label>
                                                    <select class="form-control" multiple="multiple" id="todolists_section_todo_{{ $i }}_receiversList">
                                                        @foreach($Sections as $section)
                                                            @if(in_array($section, $row['receivers']))
                                                                <option value="{{ $section }}" selected="selected">{{ $section }}</option>
                                                            @else
                                                                <option value="{{ $section }}">{{ $section }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_content">Contenu :</label>
                                                    <textarea class="form-control" id="todolists_section_todo_{{ $i }}_content" rows="3">{{ $row['content'] }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                    <input type="date" class="form-control" id="todolists_section_todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_deadline">Deadline (DD/MM/YYYY) :</label>
                                                    <input type="date" class="form-control" id="todolists_section_todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="todolists_section_todo_{{ $i }}_priority">Priorité (entre 1 et 100) : </label><br />
                                                    <input type="number" class="number" id="todolists_section_todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" />
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-primary" id="todolists_section_todo_button_valid" data-dismiss="modal" onclick="updateOrCreateTodo('{{ $i }}', 'section')">Modifier la todolist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="todolists_section_modal_{{ $i }}_deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="todolists_section_Modal_{{ $i }}_deleteConfirm" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Supprimer la todolist</h5>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Êtes-vous sûr ?</h3>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="todolists_section_todo_button_delete" onclick="deleteTodo('{{ $row['id'] }}', 'section')">Supprimer la todolist</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section("after_scripts")

    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>

        /**
        id INT 255 PRIMARY AUTO_INCREMENT
         author VARCHAR 255
         title VARCHAR 255
         content LONGTEXT
         started_at DATE
         deadline DATE
         priority INT 255
         receivers LONGTEXT
         **/

        function changeTodoManagement(){

            var div_todolists_personal = $("#todolists_personal");
            var div_todolists_section = $('#todolists_section');

            div_todolists_personal.css('display', 'none');
            div_todolists_section.css('display', 'none');

            if($('#todolists_typeSelector').val() == "todolists_personal"){
                div_todolists_personal.css('display', 'block');
            }
            else {
                div_todolists_section.css('display', 'block');
            }
        }

        function resetCreateValues(Personal_Or_Section){
                $("#todolists_"+Personal_Or_Section+"_todo_create_title").val("");
                $("#todolists_"+Personal_Or_Section+"_todo_create_content").val("");
                $("#todolists_"+Personal_Or_Section+"_todo_create_deadline").val("");
                $("#todolists_"+Personal_Or_Section+"_todo_create_priority").val("");
                $("#todolists_"+Personal_Or_Section+"_todo_create_receiversList").val("");
        }

        function updateOrCreateTodo(id, Personal_Or_Section) {

            var title, content, deadline, priority, receivers, comesFrom, todoID;

            title = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_title").val();
            content = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_content").val();
            deadline = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_deadline").val();
            priority = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_priority").val();
            receivers = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_receiversList").val();
            todoID = $("#todolists_"+Personal_Or_Section+"_todo_"+id+"_id").html();

            comesFrom = "modify";

            if(id == "create"){
                comesFrom = id;
            }

            if(title != "" && content != "" && deadline != "" && priority != "" && receivers != "" && receivers != "undefined") {

                $.ajax({
                    type: "POST",

                    url: "/section/todo-management",

                    data: {
                        'title': title,
                        'content': content,
                        'deadline': deadline,
                        'priority': priority,
                        'receivers': receivers,
                        'todoID': todoID,
                        'personalOrSection': Personal_Or_Section,
                        'comesFrom': comesFrom
                    },

                    success: function () {
                        var successMessage = "";
                        if(comesFrom == "create") {
                            successMessage = "créé";
                        }
                        else {
                            successMessage = "modifié";
                        }

                        toastr.success('Vous avez bien '+successMessage+' la todolist', "Succès !");
                    },

                    error: function (jqxhr, status, exception) {
                        toastr.error("Erreur lors de l'envoi, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                    }
                });
            }

            else {
                toastr.error("Merci de remplir tout le formulaire", "Erreur");
            }
        }

        function deleteTodo(todoID, PersonalOrSection){
            $.ajax({
                type: 'POST',

                url: "/section/todo-management",

                data: {
                    'todoID': todoID,
                    'personalOrSection': PersonalOrSection,
                    'comesFrom': "delete"
                },

                success: function(){
                    toastr.success('Vous avez bien supprimé la todolist', "Succès !");
                },

                error: function (jqxhr, status, exception) {
                    toastr.error("Erreur lors de la suppression, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                }
            })
        }
    </script>

@endsection