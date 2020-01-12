@extends('layouts.app')
@section('content')
<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container">
      <h1>Paie de la section : {{ $name }}</h1>
      <h5>Paie la buraliste !!!!</h5>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel">
            <div class="panel-body">
              {{ Form::open(array('url' => "/section/paid/" . $name ,'class'=>'form_inline')) }}
              <div class="">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Pseudo</th>
                      <th>Point Boutique</th>
                      <th>Commentaire</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($user as $row)
                    <tr class="gradeX">
                      <td>{{ $row->username }}</td>
                      <td>
                        <input type="text" name="pb_{{ $row->user_id }}" class="form-control input-block" value="{{ $row->pb }}"> </td>
                      <td>
                        <input type="text" name="comment_{{ $row->user_id }}" class="form-control input-block" value=""> </td>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <center><button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-saved"></span> Valider</button></center>
              </div>
              {{ Form::close() }}
            </div>
            <!-- end: panel body -->

          </div> <!-- end panel -->
        </div> <!-- end col-->
      </div>
      <!-- end row -->

    </div>
  </div>
</div>
@endsection
@section("after_scripts")

<!-- Editable js -->
<script src="/assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="/assets/plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="/assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/assets/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="/assets/plugins/tiny-editable/numeric-input-example.js"></script>
<!-- init -->
<script src="/assets/pages/datatables.editable.init.js"></script>


@endsection
