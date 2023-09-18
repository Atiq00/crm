<?php

namespace App\Traits;
use DB; use Auth;  
use App\Models\SaleRecord;
use App\Models\Project;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\CheckType;

trait Solar {
    public function InsertSaleRecord($data){  
        $project = Project::with('client')->where('project_code',$data['clients'])->first(); 
        $Create = new SaleRecord(); 
        $Create->project_code =  $project->project_code;
        $Create->client_code =  $project->client->client_code;
        $Create->campaign_id =  $project->client->campaign_id;
        $Create->record_id = @$data['record_id'];
        $Create->first_name = @$data['first_name'];
        $Create->last_name = @$data['last_name'];
        $Create->agent_name = @$data['agent_name'];
        $Create->phone = @$data['phone']; 
        $Create->address = @$data['address'];  
        $Create->zipcode = @$data['zip_code'];
        $Create->housetype = @$data['housetype'];
        $Create->income = @$data['income'];
        $Create->monthly_payment = @$data['monthly_payment'];
        $Create->age = @$data['age'];
        $Create->city = @$data['city'];
        $Create->state = @$data['state'];
        $Create->email = @$data['email']; 
        $Create->street = @$data['street'];
        $Create->electric_provider = @$data['electric_provider']; 
        $Create->electric_bill = @$data['electric_bill']; 
        $Create->roof_shade = @$data['roof_shade']; 
        $Create->home_owner = @$data['homeowner']; 
        $Create->credit_score = @$data['credit_score']; 
        $Create->credit_rating = @$data['credit_rating']; 
        $Create->app_date_time = @$data['app_date_time']; 
        $Create->company = @$data['company']; 
        $Create->notes = @$data['notes']; 
        if(@$data['sol']){
            $Create->sol = @$data['sol']; 
        } 
        
        $Create->user_id =           Auth::user()->HRMSID; 
        $Create->reporting_to_name = Auth::user()->reporting_to_name;         
        $Create->reporting_to =      Auth::user()->reporting_to_id;         
        $Create->designation =       Auth::user()->load('reporting')->designation;         
        $Create->campaign_name =     Auth::user()->campaign;  
        // if(@$data['clients'] == "PRO0033" || @$data['clients']=="PRO0176")
        //     $Create->lead_id = @$data['lead_id'];

              
        if($Create->save()){
            return $Create;
        }else{
            return false;
        }
    }

    public function postingUrl($clients,$data,$res){
        // echo "<pre>";print_r($data);exit;
        $response='';
        if($clients == 'PRO0033'){
          if($res){
                 $response = $this->lgPost($data,$res->id,"https://api.leadgenesis.info/v1/leads/");
             }
        }
        if($clients == 'CS0002'){
            if($res){
                $response = $this->ChSolarPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'SS0003'){
            if($res){
                $response = $this->ChSunPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }

        elseif($clients == 'SN0004'){
            if($res){
                $response = $this->send_mial($data,$clients);
            }
        }

        elseif($clients == 'SE0005'){
            if($res){
                $response = $this->ESPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }

        elseif($clients == 'PP0008'){  

            if($res){
                $response = $this->PSPPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PE0009'){  

            if($res){
                $response = $this->PSEarthPost($data,$res->id,"www.google.com");
            }
        }
        elseif($clients == 'SB0010'){  
            if($res){
                $response = $this->PSBPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'LT0011'){  
            if($res){
                $response = $this->LGLTPost($data,$res->id,"https://api.leadgenesis.info/v1/leads/");
            }
        }

        elseif($clients == 'PRO0082'){  
            if($res){
                $response = $this->PSTAPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0104'){  
            if($res){
                $response = $this->PSWPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PR0014'){  
            if($res){
                $response = $this->PSRPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PT0015'){  
            if($res){
                $response = $this->PSTPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0097'){  
            if($res){
                $response = $this->SRWPost($data,$res->id,"https://secure.setshape.com/postlead/13684/13751");
            }
        }
        elseif($clients == 'PRO0098' || $clients == 'PRO0153'){   
            if($res && $clients == 'PRO0098'){
                $this->SolarT($data,$res->id,"https://trinitysolar.leadspediatrack.com/post.do");
            } 
        }
        elseif($clients == 'PRO0106'){   
            if($res){
                $response = $this->solar_bmj($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0109'){   
            if($res){
                $response = $this->solar_fam($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0112'){   
            if($res){
                $response = $this->LB_2411($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }
        elseif($clients == 'PRO0126'){   
            if($res){
                $response = $this->SolarGMS($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/emc50/touchstone");
            }
        }
        elseif($clients == 'PRO0141'){   
            if($res){
                $response = $this->SolarTA($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0154'){   
            if($res){
                $response = $this->Solarbaize($data,$res->id,"https://server2.sunbasedata.com/sunbase/portal/api/lead_post.jsp");
            }
        
        }
        elseif($clients == 'PRO0179'){   
            if($res){
                $response = $this->sunstone($data,$res->id,"https://secure.setshape.com/postlead/15785/15855");
            }
        
        }
        elseif($clients == 'PRO0176'){   
            if($res){
                $response = $this->Solarpoint($data,$res->id,"https://pointerleads.leadspediatrack.com/post.do");
            }

            
        } 
        elseif($clients == 'PRO0183'){   
            if($res){
                $response = $this->Solarpointer($data,$res->id,"https://pointerleads.leadspediatrack.com/post.do");
            }

            
        } 
        elseif($clients == 'PRO0187'){   
            if($res){
                $response = $this->solaresd($data,$res->id,"https://www.esdbooking.us/DSS/webhook.php");
            }    
        } 

        elseif($clients == 'PRO0206'){   
            if($res){
                $response = $this->solarlumiolt($data,$res->id,"https://hooks.zapier.com/hooks/catch/12677061/3uazxno/");
            }    
        } 


		elseif($clients == 'PRO0093'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Bcc: amohiuddin@touchstonebpo.com\r\n";  

			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Street</b>:$res->street</p>";		
			$message .= "<p><b>City</b>:$res->city</p>";
			$message .= "<p><b>State</b>:$res->state</p>";		
			$message .= "<p><b>Zipcode</b>:$res->zipcode</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>HomeOwner</b>:$res->home_owner</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			$message .= "<p><b>Credit</b>:$res->credit_score</p>";
			$message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
			$message .= "<p><b>Note</b>:$res->notes</p>";
			mail("solar@excelcg.com", $subject, $message, $headers);  
        }
		elseif($clients == 'PRO0095'){   
            if(@$data['sol']){
                // echo "<pre>"; print_r($data);exit;
                $message='SOL Leads From Austin and Phoenix';
                $subject = 'Test-Lead-'.date('Y-m-d H:i:s');

                $headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
                $headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
                $headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n";      
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $message .= "<p><b>FirstName:$res->first_name</b></p>";		
                $message .= "<p><b>LastName</b>:$res->last_name</p>";
                $message .= "<p><b>Phone</b>:$res->phone</p>";		
                $message .= "<p><b>Email</b>:$res->email</p>";
                $message .= "<p><b>Street</b>:$res->street</p>";		
                $message .= "<p><b>City</b>:$res->city</p>";
                $message .= "<p><b>State</b>:$res->state</p>";		
                $message .= "<p><b>Zipcode</b>:$res->zipcode</p>";
                $message .= "<p><b>Address</b>:$res->address</p>";		
                $message .= "<p><b>HomeOwner</b>:$res->home_owner</p>";
                $message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
                $message .= "<p><b>Credit</b>:$res->credit_score</p>";
                $message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
                $message .= "<p><b>Note</b>:$res->notes</p>";
                mail("myounus@touchstone.com.pk", $subject, $message, $headers);
            }else{
                $message='';
                $subject = 'New Lead-'.date('Y-m-d H:i:s');
                $headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
                $headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
                $headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n";  
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $message .= "<p>FirstName:$res->first_name</p>";		
                $message .= "<p><b>LastName</b>:$res->last_name</p>";
                $message .= "<p><b>Phone</b>:$res->phone</p>";		
                $message .= "<p><b>Email</b>:$res->email</p>";
                $message .= "<p><b>Street</b>:$res->street</p>";		
                $message .= "<p><b>City</b>:$res->city</p>";
                $message .= "<p><b>State</b>:$res->state</p>";		
                $message .= "<p><b>Zipcode</b>:$res->zipcode</p>";
                $message .= "<p><b>Address</b>:$res->address</p>";		
                $message .= "<p><b>HomeOwner</b>:$res->home_owner</p>";
                $message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
                $message .= "<p><b>Credit</b>:$res->credit_score</p>";
                $message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
                $message .= "<p><b>Note</b>:$res->notes</p>";
                mail("leads@independentsolar.com", $subject, $message, $headers);
            }
			
        }
        elseif($clients == 'PRO0156'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
            $headers .= "cc:"."Joshua.goldsholl@gmail.com"."\r\n";
			$headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>street</b>:$res->street</p>";
			$message .= "<p><b>City</b>:$res->city</p>";		
			$message .= "<p><b>State</b>:$res->state</p>";
			$message .= "<p><b>ZipCode</b>:$res->zipcode</p>";		
			$message .= "<p><b>Notes</b>:$res->notes</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			$message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
            // skyline.cheryl@gmail.com
			mail("skyline.cheryl@gmail.com", $subject, $message, $headers);    
        }

        elseif($clients == 'PRO0187'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
            $headers .= "cc:"."jack.tim@energysolutionsdirect.com"."\r\n";
			$headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>street</b>:$res->street</p>";
			$message .= "<p><b>City</b>:$res->city</p>";		
			$message .= "<p><b>State</b>:$res->state</p>";
			$message .= "<p><b>ZipCode</b>:$res->zipcode</p>";		
			$message .= "<p><b>Notes</b>:$res->notes</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			// $message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
            // skyline.cheryl@gmail.com
			mail("cassandra@energysolutionsdirect.com", $subject, $message, $headers);    
        }

        elseif($clients == 'PRO0180'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
            $headers .= "cc:"."cmchenry@asa.solar "."\r\n";
            $headers .= "cc:"."va@asa.solar    "."\r\n";
			$headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>street</b>:$res->street</p>";
			$message .= "<p><b>City</b>:$res->city</p>";		
			$message .= "<p><b>State</b>:$res->state</p>";
			$message .= "<p><b>ZipCode</b>:$res->zipcode</p>";		
			$message .= "<p><b>Notes</b>:$res->notes</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			$message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
            
			mail("sales@asa.solar ", $subject, $message, $headers);    
        }

        elseif($clients == 'PRO0208'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>street</b>:$res->street</p>";
			$message .= "<p><b>City</b>:$res->city</p>";		
			$message .= "<p><b>State</b>:$res->state</p>";
			$message .= "<p><b>ZipCode</b>:$res->zipcode</p>";		
			$message .= "<p><b>Notes</b>:$res->notes</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			$message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
            
			mail("kylecolony@yahoo.com", $subject, $message, $headers);    
            mail("donovan.kohls@invictushomesolutions.com", $subject, $message, $headers);   
        }


        elseif($clients == 'PRO0207'){   
			$message='';
			$subject = 'New Lead-'.date('Y-m-d H:i:s');
			$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
			$headers .= "Bcc: " . "amohiuddin@touchstonebpo.com" . "\r\n"; 
            $headers .= "Bcc: " . "sales@conversionmarketing.org" . "\r\n"; 
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			$message .= "<p>FirstName:$res->first_name</p>";		
			$message .= "<p><b>LastName</b>:$res->last_name</p>";
			$message .= "<p><b>Phone</b>:$res->phone</p>";		
			$message .= "<p><b>Email</b>:$res->email</p>";
			$message .= "<p><b>Address</b>:$res->address</p>";		
			$message .= "<p><b>street</b>:$res->street</p>";
			$message .= "<p><b>City</b>:$res->city</p>";		
			$message .= "<p><b>State</b>:$res->state</p>";
			$message .= "<p><b>ZipCode</b>:$res->zipcode</p>";		
			$message .= "<p><b>Notes</b>:$res->notes</p>";
			$message .= "<p><b>ElectricBill</b>:$res->electric_bill</p>";		
			$message .= "<p><b>AppointmentDate</b>:$res->app_date_time</p>";		
            
			mail("info@fusionsolarenergy.com ", $subject, $message, $headers);    
        }


        elseif($clients == 'PRO0155'){   
			if($res){
                $response = $this->EnactSolar($data,$res->id,"www.google.com");
            }
        }

        return $response;
    }
	
	public function send_mial($lastrecord,$to){ 
		$message='';
		$subject = 'New Lead-'.date('Y-m-d H:i:s');
		$headers  = "From: " . "noreply11999@gmail.com" . "\r\n";
		$headers .= "Reply-To: " . "noreply11999@gmail.com" . "\r\n";
		$headers .= "Bcc: amohiuddin@touchstonebpo.com\r\n"; 		
		$headers .= "Bcc: myounus@touchstonebpo.com\r\n"; 

		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
		$message .= "<p>FirstName:$lastrecord->first_name</p>";		
		$message .= "<p><b>LastName</b>:$lastrecord->last_name</p>";
		$message .= "<p><b>Phone</b>:$lastrecord->phone</p>";		
		$message .= "<p><b>Email</b>:$lastrecord->email</p>";
		$message .= "<p><b>Street</b>:$lastrecord->street</p>";		
		$message .= "<p><b>City</b>:$lastrecord->city</p>";
		$message .= "<p><b>State</b>:$lastrecord->state</p>";		
		$message .= "<p><b>Zipcode</b>:$lastrecord->zipcode</p>";
		$message .= "<p><b>Address</b>:$lastrecord->address</p>";		
		$message .= "<p><b>HomeOwner</b>:$lastrecord->home_owner</p>";
		$message .= "<p><b>ElectricBill</b>:$lastrecord->electric_bill</p>";		
		$message .= "<p><b>Credit</b>:$lastrecord->credit_score</p>";
		$message .= "<p><b>AppointmentDate</b>:$lastrecord->app_date_time</p>";		
		$message .= "<p><b>Note</b>:$lastrecord->notes</p>";
		mail($to, $subject, $message, $headers);         
    }

    
}