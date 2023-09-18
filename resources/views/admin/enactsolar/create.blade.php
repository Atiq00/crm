@extends('admin.layouts.app', ['current_page' => 'enactsolar-submission'])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
            <a href="{{ route('enactsolar.index') }}" class="btn btn-sm btn-icon btn-neutral">
                <i data-feather="arrow-left" stroke-width="3" width="12"></i> Go Back</a>
        </div>
    @endpush
    @include('admin.layouts.headers.cards', ['title' => 'Enact Solar'])
    <div id='crmWebToEntityForm' class='zcwf_lblLeft crmWebToEntityForm' style='background-color: #DFE0DE;color: black;max-width: 600px;'>
         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
         <META HTTP-EQUIV ='content-type' CONTENT='text/html;charset=UTF-8'>
         <form action='https://crm.zoho.com/crm/WebToLeadForm' id="webform" name=WebToLeads3336373000018033001 method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatory3336373000018033001()' accept-charset='UTF-8'>
            <input type='text' style='display:none;' name='xnQsjsdp' value='debe1fc078fd83bbce7c9b0ed96c7a39e69bf207c16c6993b7fb4c05f70e2336'></input>
            <input type='hidden' name='zc_gad' id='zc_gad' value=''></input>
            <input type='text' style='display:none;' name='xmIwtLD' value='e93fe4d8a203a9ec885e669850df5b1058802d120a630f85b26b92240d1cbbad'></input>
            <input type='text'  style='display:none;' name='actionType' value='TGVhZHM='></input>
            <input type='text' style='display:none;' name='returnURL' value='http&#x3a;&#x2f;&#x2f;crm.touchstone-communications.com/admin/enactcreate' > </input>
            <!-- Do not remove this code. -->
            <input type='text' style='display:none;' id='ldeskuid' name='ldeskuid'></input>
            <input type='text' style='display:none;' id='LDTuvid' name='LDTuvid'></input>
            <!-- Do not remove this code. -->
            <style>
               html,body{
               margin: 0px;
               }
               #crmWebToEntityForm.zcwf_lblLeft {
               width:100%;
               padding: 25px;
               margin: 0 auto;
               box-sizing: border-box;
               }
               #crmWebToEntityForm.zcwf_lblLeft * {
               box-sizing: border-box;
               }
               #crmWebToEntityForm{text-align: left;}
               #crmWebToEntityForm * {
               direction: ltr;
               }
               .zcwf_lblLeft .zcwf_title {
               word-wrap: break-word;
               padding: 0px 6px 10px;
               font-weight: bold;
               }
               .zcwf_lblLeft .zcwf_col_fld input[type=text], .zcwf_lblLeft .zcwf_col_fld textarea {
               width: 60%;
               border: 1px solid #ccc !important;
               resize: vertical;
               border-radius: 2px;
               float: left;
               }
               .zcwf_lblLeft .zcwf_col_lab {
               width: 30%;
               word-break: break-word;
               padding: 0px 6px 0px;
               margin-right: 10px;
               margin-top: 5px;
               float: left;
               min-height: 1px;
               }
               .zcwf_lblLeft .zcwf_col_fld {
               float: left;
               width: 68%;
               padding: 0px 6px 0px;
               position: relative;
               margin-top: 5px;
               }
               .zcwf_lblLeft .zcwf_privacy{padding: 6px;}
               .zcwf_lblLeft .wfrm_fld_dpNn{display: none;}
               .dIB{display: inline-block;}
               .zcwf_lblLeft .zcwf_col_fld_slt {
               width: 60%;
               border: 1px solid #ccc;
               background: #fff;
               border-radius: 4px;
               font-size: 12px;
               float: left;
               resize: vertical;
               padding: 2px 5px;
               }
               .zcwf_lblLeft .zcwf_row:after, .zcwf_lblLeft .zcwf_col_fld:after {
               content: '';
               display: table;
               clear: both;
               }
               .zcwf_lblLeft .zcwf_col_help {
               float: left;
               margin-left: 7px;
               font-size: 12px;
               max-width: 35%;
               word-break: break-word;
               }
               .zcwf_lblLeft .zcwf_help_icon {
               cursor: pointer;
               width: 16px;
               height: 16px;
               display: inline-block;
               background: #fff;
               border: 1px solid #ccc;
               color: #ccc;
               text-align: center;
               font-size: 11px;
               line-height: 16px;
               font-weight: bold;
               border-radius: 50%;
               }
               .zcwf_lblLeft .zcwf_row {margin: 15px 0px;}
               .zcwf_lblLeft .formsubmit {
               margin-right: 5px;
               cursor: pointer;
               color: #333;
               font-size: 12px;
               }
               .zcwf_lblLeft .zcwf_privacy_txt {
               width: 90%;
               color: rgb(0, 0, 0);
               font-size: 12px;
               font-family: Arial;
               display: inline-block;
               vertical-align: top;
               color: #333;
               padding-top: 2px;
               margin-left: 6px;
               }
               .zcwf_lblLeft .zcwf_button {
               font-size: 12px;
               color: #333;
               border: 1px solid #ccc;
               padding: 3px 9px;
               border-radius: 4px;
               cursor: pointer;
               max-width: 120px;
               overflow: hidden;
               text-overflow: ellipsis;
               white-space: nowrap;
               }
               .zcwf_lblLeft .zcwf_tooltip_over{
               position: relative;
               }
               .zcwf_lblLeft .zcwf_tooltip_ctn{
               position: absolute;
               background: #dedede;
               padding: 3px 6px;
               top: 3px;
               border-radius: 4px;word-break: break-word;
               min-width: 100px;
               max-width: 150px;
               color: #333;
               z-index: 100;
               }
               .zcwf_lblLeft .zcwf_ckbox{
               float: left;
               }
               .zcwf_lblLeft .zcwf_file{
               width: 55%;
               box-sizing: border-box;
               float: left;
               }
               .clearB:after{
               content:'';
               display: block;
               clear: both;
               }
               @media all and (max-width: 600px) {
               .zcwf_lblLeft .zcwf_col_lab, .zcwf_lblLeft .zcwf_col_fld {
               width: auto;
               float: none !important;
               }
               .zcwf_lblLeft .zcwf_col_help {width: 40%;}
               }
            </style>
            <div class='zcwf_title' style='max-width: 600px;color: black;'>Touchstone</div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='First_Name'>First Name</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='First_Name' name='First Name' maxlength='40'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Last_Name'>Last Name<span style='color:red;'>*</span></label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='Last_Name' name='Last Name' maxlength='80'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Phone'>Phone</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='Phone' name='Phone' maxlength='30'></input>
                  <div class='zcwf_col_help'>
                     <span title='We will use your phone number to send you updates on your project.' style='cursor: pointer; width: 16px; height: 16px; display: inline-block; background: #fff; border: 1px solid #ccc; color: #ccc; text-align: center; font-size: 11px; line-height: 16px; font-weight: bold; border-radius: 50%;' onclick='tooltipShow3336373000018033001(this)'>?</span>
                     <div class='zcwf_tooltip_over' style='display: none;'><span class='zcwf_tooltip_ctn'>We will use your phone number to send you updates on your project.</span></div>
                  </div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Email'>Email<span style='color:red;'>*</span></label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' ftype='email' id='Email' name='Email' maxlength='100'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='LEADCF24'>What is your average electric bill&#x3f;</label></div>
               <div class='zcwf_col_fld'>
                  <select class='zcwf_col_fld_slt' id='LEADCF24' name='LEADCF24' multiple >
                     <option value='Under&#x20;&#x24;100'>Under &#x24;100</option>
                     <option value='&#x24;100-&#x24;200'>&#x24;100-&#x24;200</option>
                     <option value='&#x24;200-&#x24;300'>&#x24;200-&#x24;300</option>
                     <option value='Over&#x20;&#x24;300'>Over &#x24;300</option>
                  </select>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Street'>Street</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='Street' name='Street' maxlength='250'></input>
                  <div class='zcwf_col_help'>
                     <span title='This is to create your custom proposal. We will not share your data with any other company.' style='cursor: pointer; width: 16px; height: 16px; display: inline-block; background: #fff; border: 1px solid #ccc; color: #ccc; text-align: center; font-size: 11px; line-height: 16px; font-weight: bold; border-radius: 50%;' onclick='tooltipShow3336373000018033001(this)'>?</span>
                     <div class='zcwf_tooltip_over' style='display: none;'><span class='zcwf_tooltip_ctn'>This is to create your custom proposal. We will not share your data with any other company.</span></div>
                  </div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='City'>City</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='City' name='City' maxlength='100'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Zip_Code'>Zip Code</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='Zip_Code' name='Zip Code' maxlength='30'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='State'>State</label></div>
               <div class='zcwf_col_fld'>
                  <input type='text' id='State' name='State' maxlength='100'></input>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            @csrf
            <div class='zcwf_row wfrm_fld_dpNn'>
               <div class='zcwf_col_lab' style='font-size:12px; font-family: Arial;'><label for='Lead_Source'>Lead Source</label></div>
               <div class='zcwf_col_fld'>
                  <select class='zcwf_col_fld_slt' id='Lead_Source' name='Lead Source'  >
                     <option value='-None-'>-None-</option>
                     <option value='Engage&#x20;Website'>Engage Website</option>
                     <option value='Enact-System&#x20;Website'>Enact-System Website</option>
                     <option value='Solar&#x20;Lead&#x20;Factory'>Solar Lead Factory</option>
                     <option value='Clean&#x20;Energy&#x20;Experts'>Clean Energy Experts</option>
                     <option value='Nextdoor'>Nextdoor</option>
                     <option value='Property&#x20;Radar'>Property Radar</option>
                     <option value='Solar-Estimate.org'>Solar-Estimate.org</option>
                     <option value='Allied&#x20;Digital&#x20;Media'>Allied Digital Media</option>
                     <option value='Blue&#x20;Fire'>Blue Fire</option>
                     <option value='Employee&#x20;Referral'>Employee Referral</option>
                     <option value='Partner'>Partner</option>
                     <option value='Paid&#x20;Lead'>Paid Lead</option>
                     <option value='Customer&#x20;Referal'>Customer Referal</option>
                     <option value='Yelp'>Yelp</option>
                     <option value='DATABASE&#x20;USA'>DATABASE USA</option>
                     <option selected value='Touchstone'>Touchstone</option>
                  </select>
                  <div class='zcwf_col_help'></div>
               </div>
            </div>
            <div class='zcwf_row'>
               <div class='zcwf_col_lab'></div>
               <div class='zcwf_col_fld'><input type='submit' id='formsubmit' class='formsubmit zcwf_button' value='Submit' title='Submit'><input type='reset' class='zcwf_button' name='reset' value='Reset' title='Reset'></div>
            </div>
            <script>

                  $("#webform").submit(function (event) { 
                      
                     $.ajax({
                        url: "{{route('enactsolar.store')}}",
                        type: "Post", 
						      dataType: "JSON",
                        data: {  
                           '_token' :"{{ csrf_token() }}",
                           'first_name' :document.getElementById('First_Name').value,                           
							'record_id' :"{{rand(10000,100000)}}",
                           'last_name' :document.getElementById('Last_Name').value,
                           'phone' :document.getElementById('Phone').value,
                           'email' :document.getElementById('Email').value,
                           'electric_bill' :document.getElementById('LEADCF24').value,
                           'street' :document.getElementById('Street').value,
                           'city' :document.getElementById('City').value,
                           'state' :document.getElementById('State').value,
                           'zip_code' :document.getElementById('Zip_Code').value, 
                           'project_code' :"PRO0155",   
                           'client_code' :"CUS-100065",   
                           'clients' :"CUS-100065",   
                        } ,
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {   
							console.log(response)
                        },
                        
                     });
                  });
                function validateEmail3336373000018033001() {
					 
                    var form = document.forms['WebToLeads3336373000018033001'];
                    var emailFld = form.querySelectorAll('[ftype=email]');
                    var i;
                    for (i = 0; i < emailFld.length; i++) {
                        var emailVal = emailFld[i].value;
                        if ((emailVal.replace(/^\s+|\s+$/g, '')).length != 0) {
                            var atpos = emailVal.indexOf('@');
                            var dotpos = emailVal.lastIndexOf('.');
                            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= emailVal.length) {
                                alert('Please enter a valid email address. ');
                                emailFld[i].focus();
                                return false;
                            }
                        }
                    }
                    return true;
                }

                function checkMandatory3336373000018033001() {
                    //return false;
                    var mndFileds = new Array('Last Name', 'Email');
                    var fldLangVal = new Array('Last\x20Name', 'Email');
                    for (i = 0; i < mndFileds.length; i++) {
                        var fieldObj = document.forms['WebToLeads3336373000018033001'][mndFileds[i]];
                        if (fieldObj) {
                            if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length == 0) {
                                if (fieldObj.type == 'file') {
                                    alert('Please select a file to upload.');
                                    fieldObj.focus();
                                    return false;
                                }
                                alert(fldLangVal[i] + ' cannot be empty.');
                                fieldObj.focus();
                                return false;
                            } else if (fieldObj.nodeName == 'SELECT') {
                                if (fieldObj.options[fieldObj.selectedIndex].value == '-None-') {
                                    alert(fldLangVal[i] + ' cannot be none.');
                                    fieldObj.focus();
                                    return false;
                                }
                            } else if (fieldObj.type == 'checkbox') {
                                if (fieldObj.checked == false) {
                                    alert('Please accept  ' + fldLangVal[i]);
                                    fieldObj.focus();
                                    return false;
                                }
                            }
                            try {
                                if (fieldObj.name == 'Last Name') {
                                    name = fieldObj.value;
                                }
                            } catch (e) {}
                        }
                    }
                    trackVisitor3336373000018033001();
                    if (!validateEmail3336373000018033001()) {
                        return false;
                    }
                    document.querySelector('.crmWebToEntityForm .formsubmit').setAttribute('disabled', true);
                }

                function tooltipShow3336373000018033001(el) {
                    var tooltip = el.nextElementSibling;
                    var tooltipDisplay = tooltip.style.display;
                    if (tooltipDisplay == 'none') {
                        var allTooltip = document.getElementsByClassName('zcwf_tooltip_over');
                        for (i = 0; i < allTooltip.length; i++) {
                            allTooltip[i].style.display = 'none';
                        }
                        tooltip.style.display = 'block';
                    } else {
                        tooltip.style.display = 'none';
                    }
                }
            </script><script type='text/javascript' id='VisitorTracking'>var $zoho= $zoho || {salesiq:{values:{},ready:function(){}}};var d=document;s=d.createElement('script');s.type='text/javascript';s.defer=true;s.src='https://salesiq.zoho.com/shelly7/float.ls?embedname=null';t=d.getElementsByTagName('script')[0];t.parentNode.insertBefore(s,t);function trackVisitor3336373000018033001(){try{if($zoho){var LDTuvidObj = document.forms['WebToLeads3336373000018033001']['LDTuvid'];if(LDTuvidObj){LDTuvidObj.value = $zoho.salesiq.visitor.uniqueid();}var firstnameObj = document.forms['WebToLeads3336373000018033001']['First Name'];if(firstnameObj){name = firstnameObj.value +' '+name;}$zoho.salesiq.visitor.name(name);var emailObj = document.forms['WebToLeads3336373000018033001']['Email'];if(emailObj){email = emailObj.value;$zoho.salesiq.visitor.email(email);}}} catch(e){}}</script>
            <!-- Do not remove this --- Analytics Tracking code starts --><script id='wf_anal' src='https://crm.zohopublic.com/crm/WebFormAnalyticsServeServlet?rid=e93fe4d8a203a9ec885e669850df5b1058802d120a630f85b26b92240d1cbbadgiddebe1fc078fd83bbce7c9b0ed96c7a39e69bf207c16c6993b7fb4c05f70e2336gid885e3c1045bd9bdcc91bdf30f82b5696gid14f4ec16431e0686150daa43f3210513&tw=61690b96c1d0471b638f31426f38e68aa67fb7ed6da86f32dc10ad817fe55a0a'></script><!-- Do not remove this --- Analytics Tracking code ends. -->
         </form>
      </div>
     
    @include('admin.layouts.footers.auth')
    
@endsection
@push('js') 
@endpush
