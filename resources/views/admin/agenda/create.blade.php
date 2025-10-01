@extends('admin.layout.master')
          @section('tittle', 'Tambah Agenda')

          @section('content')
<div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Data Agenda</h3>
                <p class="text-subtitle text-muted">Silahkan isi data agenda yang ingin ditambahkan </p>
            </div>
        </div>
</div>
          <div class="card">
            <div class="card-body">
                <form class="form" action="{{route('agenda.store')}}" enctype="multipart/form-data">
                <div class="form body">
        <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">Basic Input</label>
                            <input type="text" class="form-control" id="basicInput" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <label for="helpInputTop">Input text with help</label>
                            <small class="text-muted">eg.<i>someone@example.com</i></small>
                            <input type="text" class="form-control" id="helpInputTop">
                        </div>

                        <div class="form-group">
                            <label for="helperText">With Helper Text</label>
                            <input type="text" id="helperText" class="form-control" placeholder="Name">
                            <p><small class="text-muted">Find helper text here for given textbox.</small></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="disabledInput">Disabled Input</label>
                            <input type="text" class="form-control" id="disabledInput" placeholder="Disabled Text" disabled="">
                        </div>
                        <div class="form-group">
                            <label for="readonlyInput">Readonly Input</label>
                            <input type="text" class="form-control" id="readonlyInput" readonly="readonly" value="You can't update me :P">
                        </div>

                        <div class="form-group">
                            <label for="disabledInput">Static Text</label>
                            <p class="form-control-static" id="staticInput">email@mazer.com</p>
                        </div>
                    </div>
                </div>
                </div>
                </form>

            </div>
        </div>
          @endsection
