@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="/assets/plugins/magnific-popup/dist/magnific-popup.css"/>
    <link href="/assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <a href="#" class="btn btn-icon btn-info waves-light" onclick="viewdocker();"> <i class="fas fa-network-wired"></i> Docker Console</a>
    <a href="#" class="btn btn-icon btn-info waves-light" onclick="viewmatchmaking();"> <i class="fas fa-server"></i> Matchmaking Console</a>
    <br>
    <br>

    <div id="docker-div">
        <div class="col-12">
            <div id="docker" class="form-control" rows="20" disabled style="background-color: #000000; height: 400px; overflow-y:scroll;"></div>
        </div>
        <br>
        <div class="col-12">
            <div class="input-group">
                <input type="text" id="dockerIn" class="form-control" placeholder="help" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-dark waves-effect waves-light" onclick="senddocker();" type="button">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

    <div id="matchmaking-div" style="display: none">
        <div class="col-12">
            <div id="matchmaking" class="form-control" rows="20" disabled style="background-color: #000000; height: 400px; overflow-y:scroll;"></div>
        </div>
        <br>
        <div class="col-12">
            <div class="input-group">
                <input type="text" id="matchIn" class="form-control" placeholder="help" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-dark waves-effect waves-light" onclick="sendmatch();" type="button">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('after_scripts')

    <script>
        var ws;
        ws = new WebSocket("ws://localhost:8080/docker");

        ws.onmessage=function(event) {
            data = term2html(event.data);
            $("#docker").append(data + "<br>");
        };
        ws.onopen = function() {
            ws.send("Ping !");
        };

        ws.onclose = function () {
            $("#docker").append("Connection closed !<br>");
        };

        var wss;
        wss = new WebSocket("ws://localhost:8080/matchmaking");

        wss.onmessage=function(event) {
            data = term2html(event.data);
            $("#matchmaking").append(data + "<br>");
        };
        wss.onopen = function() {
            ws.send("Ping !");
        };

        wss.onclose = function () {
            $("#matchmaking").append("Connection closed !<br>");
        };

        function viewdocker() {
            $('#matchmaking-div').hide();
            $('#docker-div').show();
        }

        function senddocker() {
            text = $('#dockerIn').val();
            ws.send(text);
        }

        viewdocker();


        function viewmatchmaking() {
            $('#docker-div').hide();
            $('#matchmaking-div').show();
        }

        function sendmatch() {
            text = $('#matchIn').val();
            wss.send(text);
        }

    </script>


    <script>
        'use strict';

        var defaultColors = [ '#000', '#D00', '#00CF12', '#C2CB00', '#3100CA',
            '#E100C6', '#00CBCB', '#C7C7C7', '#686868', '#FF5959', '#00FF6B',
            '#FAFF5C', '#775AFF', '#FF47FE', '#0FF', '#FFF' ];

        function term2html(text, options) {
            options = options || {};
            var colors = options.colors || defaultColors;

            // EL – Erase in Line: CSI n K.
            // Erases part of the line. If n is zero (or missing), clear from cursor to
            // the end of the line. If n is one, clear from cursor to beginning of the
            // line. If n is two, clear entire line. Cursor position does not change.
            text = text.replace(/^.*\u001B\[[12]K/mg, '');

            // CHA – Cursor Horizontal Absolute: CSI n G.
            // Moves the cursor to column n.
            text = text.replace(/^(.*)\u001B\[(\d+)G/mg, function(_, text, n) {
                return text.slice(0, n);
            });

            // SGR – Select Graphic Rendition: CSI n m.
            // Sets SGR parameters, including text color. After CSI can be zero or more
            // parameters separated with ;. With no parameters, CSI m is treated as
            // CSI 0 m (reset / normal), which is typical of most of the ANSI escape
            // sequences.
            var state = {
                bg: -1,
                fg: -1,
                bold: false,
                underline: false,
                negative: false
            };
            text = text.replace(/\u001B\[([\d;]+)m([^\u001B]+)/g, function(_, n, text) {
                // Update state according to SGR codes.
                n.split(';').forEach(function(code) {
                    code = code | 0;
                    if (code === 0) {
                        state.bg = -1;
                        state.fg = -1;
                        state.bold = false;
                        state.underline = false;
                        state.negative = false;
                    } else if (code === 1) {
                        state.bold = true;
                    } else if (code === 4) {
                        state.underline = true;
                    } else if (code === 7) {
                        state.negative = true;
                    } else if (code === 21) {
                        state.bold = false;
                    } else if (code === 24) {
                        state.underline = false;
                    } else if (code === 27) {
                        state.negative = false;
                    } else if (code >= 30 && code <= 37) {
                        state.fg = code - 30;
                    } else if (code === 39) {
                        state.fg = -1;
                    } else if (code >= 40 && code <= 47) {
                        state.bg = code - 40;
                    } else if (code === 49) {
                        state.bg = -1;
                    } else if (code >= 90 && code <= 97) {
                        state.fg = code - 90 + 8;
                    } else if (code >= 100 && code <= 107) {
                        state.bg = code - 100 + 8;
                    }
                });

                // Convert color codes to CSS colors.
                var bold = state.bold * 8;
                var fg, bg;
                if (state.negative) {
                    fg = state.bg | bold;
                    bg = state.fg;
                } else {
                    fg = state.fg | bold;
                    bg = state.bg;
                }
                fg = colors[fg] || '';
                bg = colors[bg] || '';

                // Create style element.
                var style = '';
                if (bg) {
                    style += 'background-color:' + bg + ';';
                }
                if (fg) {
                    style += 'color:' + fg + ';';
                }
                if (bold) {
                    style += 'font-weight:bold;';
                }
                if (state.underline) {
                    style += 'text-decoration:underline';
                }
                var html = text.
                replace(/&/g, '&amp;').
                replace(/</g, '&lt;').
                replace(/>/g, '&gt;');

                // Return HTML for this section of formatted text.
                if (style) {
                    return '<span style="' + style + '">' + html + '</span>';
                } else {
                    return html;
                }
            });

            return text.replace(/\u001B\[.*?[A-Za-z]/g, '');
        }

    </script>

@endsection
