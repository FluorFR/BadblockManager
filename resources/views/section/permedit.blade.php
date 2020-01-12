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
                <h1>Edition permissions group {{ $data['name'] }} :</h1>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-body">
                                <textarea id="json-input" autocomplete="off" style="display: none">
                                    {{ json_encode($data) }}
                                </textarea>

                                <pre id="json-display"></pre>
                                <button id="save" class="btn btn-icon waves-effect waves-light btn-danger m-b-5">
                                    Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("after_scripts")
    <script src="/assets/plugins/toastr/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="/assets/jquery.json-editor.min.js"></script>

    <script>
        function encodeJSONStr(str) {
            var encodeMap = {
                '"': '\\"',
                '\\': '\\\\',
                '\b': '\\b',
                '\f': '\\f',
                '\n': '\\n',
                '\r': '\\r',
                '\t': '\\t'
            };

            return str.replace(/["\\\b\f\n\r\t]/g, function (match) {
                return encodeMap[match];
            });
        }

        function encodeJSON(json) {
            if (typeof json === 'string') {
                return encodeJSONStr(json);
            } else if (typeof json === 'object') {
                for (var attr in json) {
                    json[attr] = encodeJSON(json[attr]);
                }
            } else if (Array.isArray(json)) {
                for (var i = 0; i < json.length; i++) {
                    json[i] = encodeJSON(json[i]);
                }
            }

            return json;
        }

        // get JSON
        function getJson() {
            try {
                return JSON.parse($('#json-input').val());
            } catch (ex) {
                alert('Wrong JSON Format: ' + ex);
            }
        }

        // initialize
        var editor = new JsonEditor('#json-display', getJson());

        editor.load(getJson());

        $('#save').on('click', function () {
            op = encodeJSON(editor.get());
            console.log(op);

            $.ajax({
                type: "POST",
                url: "/section/permission-serv/{{ $data['_id'] }}",
                data: {data : op},
                success: function(data)
                {
                    toastr.success("Envoie des modifications !", "Succès !");
                    console.log('Valider !');
                },
                error: function(data)
                {
                    toastr.error('Erreur de l\'envoie !', 'Erreur !');
                    console.log('Erreur !');
                }
            });

        });

    </script>

@endsection