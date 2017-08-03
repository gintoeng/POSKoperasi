<!doctype html>
<html class="no-js" lang="">
<head>
  @include('templates.head')
</head>
<body>
  <div class="app horizontal-layout">
    @include('templates.menu')
    <section class="layout">
      <section class="main-content">
        <div class="content-wrap">
          <div class="wrapper">
            <ol class="breadcrumb">
              <li>
                <a href="javascript:;"><i class="ti-home mr5"></i></a>
              </li>
              <li class="active">Akun saya</li>
            </ol>
            <div class="row">
              <div class="col-md-12">
                  <div class="row">
                  <div class="col-md-6">

                  <div class="panel overflow-hidden no-b profile p15">
                  <div class="row mb25">
                  <div class="col-sm-12">
                  <div class="row">
                  <div class="col-xs-12 col-sm-8">
                  <h4 class="mb0">{{ $user->username }}</h4>
                  <ul class="user-meta">
                  <li>
                  <i class="ti-world mr5"></i>
                  <a href="javascript:;">Developer</a>
                  </li>
                  <li>
                  <i class="ti-settings mr5"></i>
                  <a href="javascript:;">Aktif</a>
                  </li>
                  </ul>
                  </div>
                  <div class="col-xs-12 col-sm-4 text-center">
                  <figure>
                  <img src="{{ url('foto/user'.'/'.$user->photo) }}" alt="{{ $user->username }}" class="avatar avatar-lg img-circle avatar-bordered">
                  <div class="small mt10">{{ $user->username }}</div>
                  </figure>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>

                  </div>
                  <div class="col-md-6">
                  <section class="panel" style="padding:10px">
                    @if(session('msg'))
                        <div class="alert alert-{!! session('msgclass') !!}">
                            {!! session('msg') !!}
                        </div>
                    @endif
                  <form action="{{ url('account/update') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                          <label for="username" class="col-sm-3 control-label">Username</label>
                          <div class="col-sm-9" style="margin-bottom:10px">
                            <input name="username" type="text" class="form-control" id="username" placeholder="Kode" value="{{ $user->username }}" required>
                          </div>
                        </div>
                        <div class="form-group">
          								<label for="password" class="col-sm-3 control-label">Password</label>
          								<div class="col-sm-9" style="margin-bottom:10px">
          									<input name="password" type="password" class="form-control" id="password" placeholder="Isi jika akan diganti">
          								</div>
          							</div>
          							<div class="form-group">
          								<label for="role" class="col-sm-3 control-label">Hak Akses</label>
          								<div class="col-sm-9" style="margin-bottom:10px">
          									<select name="role_id" class="form-control">
                              @foreach($roles as $role)
          										<option value="{{ $role->id }}" @if($role->id==$user->role_id) selected @endif>{{ $role->role_name }}</option>
                              @endforeach
                            </select>
          								</div>
          							</div>
          							<div class="form-group">
          								<label for="status" class="col-sm-3 control-label">Status</label>
          								<div class="col-sm-9" style="margin-bottom:10px">
          									<select name="status" class="form-control">
          										<option value="1"
                              @if($user->status==1)
                                selected
                              @endif
                              >AKTIF</option>
          										<option value="0"
                              @if($user->status==0)
                                selected
                              @endif
                              >NON AKTIF</option>
          									</select>
          								</div>
          							</div>
                        <div class="form-group">
                            <label for="foto" class="col-sm-3 control-label">Foto</label>
                            <div class="col-sm-9">
                                <img id="imgfoto" src="{{ url('foto/user'.'/'.$user->photo) }}" alt="{{ $user->username }}" width="100" />
                                <input name="foto" type="file" id="foto" placeholder="Foto">
                            </div>
                        </div>
          							<div class="form-group">
          								<label for="tanggal_lahir" class="col-sm-3 control-label"></label>
          								<div class="col-sm-2" style="margin-top:10px">
          									<input type="submit" class="btn btn-primary btn-block" name="save" value="Save">
          								</div>
          								<div class="col-sm-2" style="margin-top:10px">
          									<a href="{{ url('account') }}" class="btn btn-danger btn-block">Cancel</a>
          								</div>
          							</div>
                      </form>
                  </section>
                  </div>
                  </div>
                  </div>

                  </div>

                  <a class="exit-offscreen"></a>
              </div>
            </div>
            <a class="exit-offscreen"></a>
      </section>
    </section>
  </div>
  <script>
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function (e) {
                  $('#imgfoto').attr('src', e.target.result);
              }

              reader.readAsDataURL(input.files[0]);
          }
      }

      $("#foto").change(function(){
          readURL(this);
      });
  </script>
  @include('templates.foot')
</body>
</html>
