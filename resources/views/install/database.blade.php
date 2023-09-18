@extends('install.layouts.install', [
    'class' => 'bg-secondary',
    'activeTab' => $tab
])

@section('content')

<form role="form" method="POST" action="{{ \Request::getRequestUri() }}">

{{ @csrf_field() }}


    <div class="card bg-white shadow border-0">
        <div class="card-header">
            <h4 class="text-uppercase ls-1 py-3 mb-0">Database</h4>
        </div>
        <div class="card-body">
        
        <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="app_name">Application Name:*</label>
                      <input type="text" class="form-control" name="APP_NAME" id="app_name" placeholder="HelpDesk" value="HelpDesk" required>
                  </div>
                </div>

                  
                  <h4 class="mt-2"> Database Details <small>Make sure to provide correct information</small></h4>
                  <hr/>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="db_host">Database Host:*</label>
                        <input type="text" class="form-control" id="db_host" name="DB_HOST" required placeholder="localhost / 127.0.0.1" value="localhost">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="db_port">Database Port:*</label>
                        <input type="text" class="form-control" id="db_port" name="DB_PORT" required value="3306">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="db_database">Database Name:*</label>
                        <input type="text" class="form-control" id="db_database" name="DB_DATABASE" value="helpdesk" required>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="db_username">Database Username:*</label>
                        <input type="text" class="form-control" id="db_username" name="DB_USERNAME" required>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="db_password">Database Password:</label>
                        <input type="password" class="form-control" id="db_password" name="DB_PASSWORD">
                    </div>
                  </div>

                  <div class="clearfix"></div>

                  <h4 class="mt-2">Email Configuration<small> Use for sending mails</small></h4>
                  <hr/>
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="MAIL_DRIVER">Send mails using:*</label>
                        <select class="form-control" name="MAIL_DRIVER" id="MAIL_DRIVER">
                          <option value="sendmail">PHP Mail</option>
                          <option value="smtp">SMTP</option>
                        </select>
                    </div>
                  </div>
                  <div class="clearfix"></div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="MAIL_FROM_ADDRESS">Default from address:*</label>
                        <input type="email" class="form-control" id="MAIL_FROM_ADDRESS" name="MAIL_FROM_ADDRESS" placeholder="admin@helpdesk.com" value="admin@helpdesk.com" required>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="MAIL_FROM_NAME">Default from name:</label>
                        <input type="text" class="form-control" id="MAIL_FROM_NAME" name="MAIL_FROM_NAME" placeholder="Ultimate Desk (Optional)">
                    </div>
                  </div>

                  <div class="col-md-12 smtp d-none">
                    <div class="form-group">
                        <label for="MAIL_HOST">SMTP Host:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_HOST" name="MAIL_HOST" required disabled>
                    </div>
                  </div>

                  <div class="col-md-12  smtp d-none">
                    <div class="form-group">
                        <label for="MAIL_PORT">SMTP Mail Port:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_PORT" name="MAIL_PORT" required disabled>
                    </div>
                  </div>

                  <div class="col-md-12  smtp d-none">
                    <div class="form-group">
                        <label for="MAIL_ENCRYPTION">SMTP Mail Encryption:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_ENCRYPTION" name="MAIL_ENCRYPTION" required disabled placeholder="tls or ssl">
                    </div>
                  </div>

                  <div class="col-md-12 smtp d-none">
                    <div class="form-group">
                        <label for="MAIL_USERNAME">SMTP Username:*</label>
                        <input type="text" class="form-control smtp_input" id="MAIL_USERNAME" name="MAIL_USERNAME" required disabled>
                    </div>
                  </div>

                  <div class="col-md-12 smtp d-none">
                    <div class="form-group">
                        <label for="MAIL_PASSWORD">SMTP Password:*</label>
                        <input type="password" class="form-control smtp_input" id="MAIL_PASSWORD" name="MAIL_PASSWORD" required disabled>
                    </div>
                  </div>
                
                  </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <a href="{{ url('install/permissions') }}" class="btn btn-secondary">Previous</a>
                </div>
                <div class="col text-right">
                    <button type="submit" class="btn btn-info">Next</a>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection

@push('js')

<script type="text/javascript">
    $(document).ready(function(){
      $('select#MAIL_DRIVER').change(function(){
        var driver = $(this).val();

        if(driver == 'smtp'){
          $('div.smtp').removeClass('d-none');
          $('input.smtp_input').attr('disabled', false);
        } else {
          $('div.smtp').addClass('d-none');
          $('input.smtp_input').attr('disabled', true);
        }
      })

      $('form#details_form').submit(function(){
        $('button#install_button').attr('disabled', true).text('Installing...');
        $('div.install_msg').removeClass('d-none');
        $('.back_button').hide();
      });

    })
  </script>

@endpush
