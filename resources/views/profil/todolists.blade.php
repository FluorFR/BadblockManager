@extends("layouts.app")

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


            <h3>Quelle type de todolist souhaitez-vous voir ?</h3>

            <select id="todolists_typeSelector" class="form-control" onchange="changeTodoManagement()">
                <option value="todolists_personal">Todolists personnelles</option>
                <option value="todolists_section">Todolists de section</option>
            </select>

                <br /><br />

                <div id="todolists_personal">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Mes todolists en cours :</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-20">
                                                <div class="card-columns">
                                                    @foreach(array_slice($Todolists_Personal, 0, $MaxTodolistsEntries_Personal) as $i => $row)

                                                        @if(in_array($UserID, $row['receivers']) && !in_array($UserID, $row['receivers_done']))

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

                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#todolists_personnal_inProgress_modal_{{ $i }}">Voir la todolist</button>

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

                                                            <div class="modal fade" id="todolists_personnal_inProgress_modal_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="Modal_{{ $i }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Voir la todolist</h5>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form>
                                                                                <div id="todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                                                <div class="form-group">
                                                                                    <label for="todo_title">Titre :</label>
                                                                                    <input type="text" class="form-control" id="todo_{{ $i }}_title" value="{{ $row['title'] }}" readonly>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="usernamesList">Qui est concerné :</label>
                                                                                    <h5 class="card-text">
                                                                                        @foreach($row['receivers'] as $i => $receiver)
                                                                                            {{ $receiver }}
                                                                                            @if($i != count($row['receivers'])-1)
                                                                                                ,
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="todo_content">Contenu :</label>
                                                                                    <textarea class="form-control" id="todo_{{ $i }}_content" rows="3" readonly>{{ $row['content'] }}</textarea>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="todo_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                                                    <input type="date" class="form-control" id="todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="todo_deadline">Deadline (DD/MM/YYYY) :</label>
                                                                                    <input type="date" class="form-control" id="todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" readonly />
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="todo_priority">Priorité (entre 1 et 100) : </label><br />
                                                                                    <input type="number" class="number" id="todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" readonly />
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title">Vos todolists terminées :</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-20">
                                            <div class="card-columns">
                                                @foreach($Todolists_Personal as $i => $row)
                                                    @if(in_array($UserID, $row['receivers']) && in_array($UserID, $row['receivers_done']))
                                                        <div class="card" style="width: 18rem;">
                                                            <div class="card-body">
                                                                <h3 class="card-title" id="card_{{ $i }}_title">{{ $row['title'] }}</h3>
                                                                <p class="card-text" id="card_{{ $i }}_content_display">{{ substr($row['content'], 0, $MaxCharactersLength) }}

                                                                    @if($row['content'] != substr($row['content'], 0, $MaxCharactersLength))
                                                                        ...
                                                                    @endif
                                                                </p>
                                                                <div style="display: none" id="card_{{ $i }}_started_at">{{ $row['started_at'] }}</div>
                                                                <h5 class="card-text d-inline" id="card_{{ $i }}_deadline">Lancée le <h6 class="d-inline">(YYYY/MM/DD)</h6> : {{ $row['started_at'] }}</h5>
                                                                <h5 class="card-text d-inline" id="card_{{ $i }}_deadline">Deadline <h6 class="d-inline">(YYYY/MM/DD)</h6> : {{ $row['deadline'] }}</h5>
                                                                <h5 class="card-text" id="card_{{ $i }}_priority">Priorité : {{ $row['priority'] }}</h5>

                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#todolists_personnal_done_modal_{{ $i }}">Voir la todolist</button>
                                                            </div>
                                                            <div class="card-footer">
                                                                <small class="text-muted" id="card_{{ $i }}_author">Créateur : {{ $row['author'] }}</small><br />
                                                                <small class="text-muted" id="card_{{ $i }}_author">Personnes concernées :
                                                                    @foreach($row['receivers'] as $j => $receiver)
                                                                        {{ $receiver }}
                                                                        @if($j != (count($row['receivers']))-1)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="todolists_personnal_done_modal_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="Modal_{{ $i }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Voir la todolist</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div id="todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                                            <div class="form-group">
                                                                                <label for="todo_title">Titre :</label>
                                                                                <input type="text" class="form-control" id="todo_{{ $i }}_title" value="{{ $row['title'] }}" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="usernamesList">Qui est concerné :</label>
                                                                                <h5 class="card-text">
                                                                                    @foreach($row['receivers'] as $i => $receiver)
                                                                                        {{ $receiver }}
                                                                                        @if($i != count($row['receivers'])-1)
                                                                                            ,
                                                                                        @endif
                                                                                    @endforeach
                                                                                </h5>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_content">Contenu :</label>
                                                                                <textarea class="form-control" id="todo_{{ $i }}_content" rows="3" readonly>{{ $row['content'] }}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_deadline">Deadline (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" readonly />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_priority">Priorité (entre 1 et 100) : </label><br />
                                                                                <input type="number" class="number" id="todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" readonly />
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="todolists_section" style="display: none">


                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title">Mes todolists en cours :</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-20">
                                            <div class="card-columns">
                                                @foreach(array_slice($Todolists_Section, 0, $MaxTodolistsEntries_Section) as $i => $row)

                                                    @if(in_array($UserSection, $row['receivers']) && !in_array($UserSection, $row['receivers_done']))

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

                                                            <button class="btn btn-primary" data-toggle="modal" data-target="#todolists_section_inProgress_modal_{{ $i }}">Voir la todolist</button>
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

                                                        <div class="modal fade" id="todolists_section_inProgress_modal_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="Modal_{{ $i }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Voir la todolist</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div id="todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                                            <div class="form-group">
                                                                                <label for="todo_title">Titre :</label>
                                                                                <input type="text" class="form-control" id="todo_{{ $i }}_title" value="{{ $row['title'] }}" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="usernamesList">Qui est concerné :</label>
                                                                                <h5 class="card-text">
                                                                                    @foreach($row['receivers'] as $i => $receiver)
                                                                                        {{ $receiver }}
                                                                                        @if($i != count($row['receivers'])-1)
                                                                                            ,
                                                                                        @endif
                                                                                    @endforeach
                                                                                </h5>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_content">Contenu :</label>
                                                                                <textarea class="form-control" id="todo_{{ $i }}_content" rows="3" readonly>{{ $row['content'] }}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_deadline">Deadline (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" readonly />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_priority">Priorité (entre 1 et 100) : </label><br />
                                                                                <input type="number" class="number" id="todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" readonly />
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title">Vos todolists terminées :</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-20">
                                            <div class="card-columns">
                                                @foreach($Todolists_Section as $i => $row)
                                                    @if(in_array($UserSection, $row['receivers']) && in_array($UserSection, $row['receivers_done']))
                                                        <div class="card" style="width: 18rem;">
                                                            <div class="card-body">
                                                                <h3 class="card-title" id="card_{{ $i }}_title">{{ $row['title'] }}</h3>
                                                                <p class="card-text" id="card_{{ $i }}_content_display">{{ substr($row['content'], 0, $MaxCharactersLength) }}

                                                                    @if($row['content'] != substr($row['content'], 0, $MaxCharactersLength))
                                                                        ...
                                                                    @endif
                                                                </p>
                                                                <div style="display: none" id="card_{{ $i }}_started_at">{{ $row['started_at'] }}</div>
                                                                <h5 class="card-text d-inline" id="card_{{ $i }}_deadline">Lancée le <h6 class="d-inline">(YYYY/MM/DD)</h6> : {{ $row['started_at'] }}</h5>
                                                                <h5 class="card-text d-inline" id="card_{{ $i }}_deadline">Deadline <h6 class="d-inline">(YYYY/MM/DD)</h6> : {{ $row['deadline'] }}</h5>
                                                                <h5 class="card-text" id="card_{{ $i }}_priority">Priorité : {{ $row['priority'] }}</h5>

                                                                <button class="btn btn-primary" data-toggle="modal" data-target="#todolists_section_done_modal_{{ $i }}">Voir la todolist</button>
                                                            </div>
                                                            <div class="card-footer">
                                                                <small class="text-muted" id="card_{{ $i }}_author">Créateur : {{ $row['author'] }}</small><br />
                                                                <small class="text-muted" id="card_{{ $i }}_author">Personnes concernées :
                                                                    @foreach($row['receivers'] as $j => $receiver)
                                                                        {{ $receiver }}
                                                                        @if($j != (count($row['receivers']))-1)
                                                                            ,
                                                                        @endif
                                                                    @endforeach
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="todolists_section_done_modal_{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="Modal_{{ $i }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Voir la todolist</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form>
                                                                            <div id="todo_{{ $i }}_id" style="display: none;">{{ $row['id'] }}</div>
                                                                            <div class="form-group">
                                                                                <label for="todo_title">Titre :</label>
                                                                                <input type="text" class="form-control" id="todo_{{ $i }}_title" value="{{ $row['title'] }}" readonly>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="usernamesList">Qui est concerné :</label>
                                                                                <h5 class="card-text">
                                                                                    @foreach($row['receivers'] as $i => $receiver)
                                                                                        {{ $receiver }}
                                                                                        @if($i != count($row['receivers'])-1)
                                                                                            ,
                                                                                        @endif
                                                                                    @endforeach
                                                                                </h5>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_content">Contenu :</label>
                                                                                <textarea class="form-control" id="todo_{{ $i }}_content" rows="3" readonly>{{ $row['content'] }}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_started_at">Lancé le (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_started_at" value="{{ $row['started_at'] }}" readonly  />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_deadline">Deadline (DD/MM/YYYY) :</label>
                                                                                <input type="date" class="form-control" id="todo_{{ $i }}_deadline" value="{{ $row['deadline'] }}" readonly />
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="todo_priority">Priorité (entre 1 et 100) : </label><br />
                                                                                <input type="number" class="number" id="todo_{{ $i }}_priority" min="0" max="100" value="{{ $row['priority'] }}" readonly />
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>

@endsection

@section('after_scripts')


    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script>

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

        function closeTodo(todoID){
            $.ajax({
                type: "POST",

                url: '/profil/todolists',

                data: {
                    'todoID': todoID
                },

                success: function () {
                    toastr.success('Vous avez bien fermé la todolist', "Succès !");
                },

                error: function (jqxhr, status, exception) {
                    toastr.error("Erreur lors de la validation, merci de contacter un administrateur. Intitulé de l'erreur : " + exception, 'Erreur');
                }
            })
        }

    </script>

@endsection