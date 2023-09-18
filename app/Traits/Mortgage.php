<?php

namespace App\Traits;
use DB; use Auth;  
use App\Models\SaleMortgage;
use App\Models\Client;
use App\Models\Project;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\CheckType;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
trait Mortgage {
    public function InsertSaleRecord($data){        
        $project = Project::with('client')->where('project_code',$data['clients'])->first(); 
        $Create = new SaleMortgage(); // echo "<pre>";print_r($project);exit;  
        $Create->project_code =  $project->project_code;
        $Create->client_code =  $project->client->client_code;
        $Create->campaign_id =  $project->client->campaign_id;
        $Create->record_id = $data['record_id']; 
        $Create->first_name = $data['first_name'];
        $Create->last_name = $data['last_name']; 
        $Create->title = $data['title']; 
        $Create->phone = $data['phone']; 
        $Create->work_phone = $data['work_phone']; 
        $Create->address = $data['address'];  
        $Create->zipcode = $data['zip'];
        $Create->age = $data['age'];
        $Create->city = $data['city'];
        $Create->state = $data['state'];
        $Create->email = $data['email'];  
        $Create->best_timing = ""; 
        $Create->current_amount = $data['current_amount']; 
        $Create->current_rate = $data['current_rate'];
        $Create->late_payment = $data['late_payment'];
        $Create->employment = $data['employment'];
        $Create->bankrupty = $data['bankrupty'];
        $Create->debt_amt_1 = $data['debt_amt_1'];
        $Create->house_value = $data['house_value'];
        $Create->cash_amount = $data['cash_amount'];
        $Create->debt_type = $data['debt_type'];
        $Create->debt = $data['debt'];
        $Create->income = $data['income']; 
        $Create->age_18_to_64 = $data['age_18_to_64'];
        $Create->medicare_medicaid = $data['medicare_medicaid'];
        $Create->annual_house = $data['annual_house'];
        $Create->property_value = $data['property_value']; 
        $Create->property_type = $data['property_type']; 
        $Create->monthly_payment = $data['monthly_payment']; 
        $Create->company = $data['company']; 
        $Create->total_debt = $data['total_debt']; 
        $Create->ltv = $data['ltv']; 
        $Create->credit_rating = $data['credit_rating']; 
        $Create->mortgage_balance = $data['mortgage_balance']; 
        $Create->cash_out = $data['cash_out']; 
        $Create->interest_rate = $data['interest_rate']; 
        $Create->loan_amount = $data['loan_amount']; 
        $Create->rate_type = $data['rate_type']; 
        $Create->loan_type = $data['loan_type']; 
        $Create->purpose_of_loan = $data['purpose_of_loan']; 
        $Create->age = $data['age']; 
        $Create->transfer_by = $data['transfer_by']; 
        $Create->call_transfer_status = $data['call_transfer_status']; 
        $Create->notes = $data['notes'];  
        $Create->loanofficername = $data['loanofficername']; 
        $Create->transferred_to = $data['transferred_to'];
        $Create->recieving_rep = $data['recieving_rep'];
        $Create->transferred_to_lb2417 = $data['transferred_to_lb2417'];
        $Create->r_transfer_to_1380 = $data['r_transfer_to_1380'];
        $Create->user_id = Auth::user()->HRMSID;          
         
        $Create->reporting_to_name = Auth::user()->reporting_to_name;         
        $Create->reporting_to =      Auth::user()->reporting_to_id;         
        $Create->designation =       Auth::user()->load('reporting')->designation;         
        $Create->campaign_name =     Auth::user()->campaign;        
        if($Create->save()){
            return $Create;
        }else{
            return false;
        }
    }
    use MortgagePosting;
    public function postingUrl($clients,$data, $res){
        // print_r($data);exit;
        if($clients == 'PRO0022'){ 
            //allied            
            if($res){
                $this->generalPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/afb06/liveleados");
            }
        }
        elseif($clients == 'PRO0024'){   
            // SRWCS          
            if($res){
                $this->generalPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/wedg01/live");
            }
        }
        elseif($clients == 'PRO0028'){     
            // LF        
            if($res){
                $this->generalPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/lfi02/touchdown");
            }
        }
        elseif($clients == 'PRO0100'){             
            if($res){
                $this->mkcPost($data,$res->id,"https://secure.setshape.com/postlead/11685/12127");
            }
        }
        elseif($clients == 'CHDEBT0004'){             
            if($res){
                $this->PakDebtPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0058' || $clients == 'PRO0059'){             
            if($res){
                $this->PAK_HWtPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'PRO0032'){             
            if($res){
                $this->camp8Post($data,$res->id,"https://livesubmissionleads.com/velocify20180123/index.php?");
            }
        }            
        elseif($clients == 'PRO0056'){             
            if($res){
                $this->CHREFREVLPost($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }
        elseif($clients == 'ALLIEDNC0016'){   
            // allied nc          
            if($res){
                $this->generalPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/afb08/touchstonebpo");
            }
        }
        elseif($clients == 'PRO0036'){
            // srwcs debt             
            if($res){
                $this->WarmDebtPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/afb08/touchstonebpo");
            }
        }
        elseif($clients == 'PRO0078'){             
            if($res){
                $this->generalPost($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/wedg01/live?");
            }
        }
        elseif($clients == 'QMS3610020'){             
            if($res){
                $this->Qms360Post($data,$res->id,"https://quotemysavings.net/panel/");
            }
        }
        elseif($clients == 'QMS3630024'){             
            if($res){
                $this->Qms363Post($data,$res->id,"https://quotemysavings.net/panel/process.php");
            }
        }
        elseif($clients == 'REVLB23740008'){             
            if($res){
                $this->Rev2374Post($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }
        elseif($clients == 'PRO0076'){             
            if($res){
                $this->Rev2408Post($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }
        elseif($clients == 'PRO0077'){             
            if($res){
                $this->Rev2409Post($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }
        elseif($clients == 'REVLB23970009'){             
            if($res){
                $this->Rev2397Post($data,$res->id,"www.google.com");
            }
        }
        elseif($clients == 'REVLB23980010'){             
            if($res){
                $this->Rev2398Post($data,$res->id,"www.google.com");
            }
        }
        elseif($clients == 'REVLB23990013'){             
            if($res){
                $this->Rev2399Post($data,$res->id,"www.google.com");
            }
        }
        elseif($clients == 'REVLB23440014'){             
            if($res){
                $this->Rev2344Post($data,$res->id,"www.google.com");
            }
        }
     
        elseif($clients == 'REVLB24050022'){             
            if($res){
                $this->REVLB2405Post($data,$res->id,"https://expertmediaresults.com/leadpanel/process.php");
            }
        }
        elseif($clients == 'REVLB24060023'){             
            if($res){
                $this->REVLB2406Post($data,$res->id,"https://expertmediaresults.com/leadpanel/process.php");
            }
        }  
		elseif($clients == 'PRO0096'){             
            if($res){
                $this->EMR_1378($data,$res->id,"https://expertmediaresults.com/leadpanel/process.php");
            }
        } 
        elseif($clients == 'PRO0094'){             
            if($res){
                $this->MTG_R($data,$res->id,"https://rasani.azurewebsites.net/api/rasanicall.ashx");
            }
        }  
        elseif($clients == 'PRO0102'){             
            if($res){
                $this->Rev2412Post($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }  
        
        elseif($clients == 'PRO0079'){             
            if($res){
                $this->RvQll($data,$res->id,"https://api.leadmailbox.com/v2/leads/add/qll02/touchstonelive");
            }
        } 
        elseif($clients == 'PRO0111'){             
            if($res){
                $this->Rev2414($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        } 
		elseif($clients == 'PRO0113'){             
            if($res){
                $this->Rev2415($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }  
        	elseif($clients == 'PRO0114'){             
            if($res){
                $this->CO_Debt_under_10k($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }  
        elseif($clients == 'PRO0115'){             
            if($res){
                $this->CO_Debt_over_10k($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }  
        elseif($clients == 'PRO0116'){             
            if($res){
                $this->CO_Debt_Over_18k($data,$res->id,"https://leadsordered.leadportal.com/new_api/api.php");
            }
        }  
        elseif($clients == 'PRO0127'){             
            if($res){
                $this->Rev2416($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }  
	   elseif($clients == 'PRO0080'){             
           if($res){
                $this->Rev2391Post($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
            }
        }
        elseif($clients == 'PRO0202'){             
            if($res){
                 $this->lb2441debt($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
             }
         }
         elseif($clients == 'PRO0202'){             
            if($res){
                 $this->lb2441debt_pay($data,$res->id,"https://login.debtpaypro.com/post/163a94226f0c6eb10aee0c745f6d8ad4794280e2");
             }
         }
         
        elseif($clients == 'PRO0150'){             
            if($res){
                $this->he_lend($data,$res->id,"https://secure.setshape.com/postlead/14767/15206");
                     $postData['LastName'] = $data['first_name'];
                     $postData['FirstName'] = $data['last_name'];
                     $postData['Email'] = $data['email'];
		             require base_path("vendor/autoload.php");
		    		 $mail = new PHPMailer(true);
		    		 $mail->IsSMTP();
		    		 $mail->Mailer = "smtp";
		    		 $mail->SMTPDebug  = 0;  
		    		 $mail->SMTPAuth   = TRUE;
		    		 $mail->SMTPSecure = "tls";
		    		 $mail->Port       = 587;
		    		 $mail->Host       = "smtp.googlemail.com";
		    		 $mail->Username   = "noreply@equity-tap.com";
		    		 $mail->Password   = "G00gleT@p";
                     
		    		 $mail->SMTPOptions = array(
		    		 	'ssl' => array(
		    		 		'verify_peer' => false,
		    		 		'verify_peer_name' => false,
		    		 		'allow_self_signed' => true
		    		 	)
		    		 );
		    		 $mail->IsHTML(true);
                     $mail->AddAddress($data['email'], $data['first_name']); 
                     $mail->SetFrom("noreply@equity-tap.com", "equity-tap");
                     $mail->addBCC('amohiuddin@touchstonebpo.com');
                     $mail->addBCC('steve@equitytapusa.com');
                     $mail->Subject = "Unlock Your Offer";
                     $content = "Hello ".$data['first_name'].",<br>";
                     $content .= "The process is very simple and best of all it will not affect your credit or cost you anything to unlock your preferred offer. Remember, we provide you a cash investment in exchange for a small percentage of your home's value. The best part is there are no monthly payments or interest. This program allows you to get the cash you need now and does not increase your monthly outgo. <br><br><br>"; 
                     $content .= "There is no cost or obligation and if you decide to move forward there are no out-of-pocket cost including the appraisal. This is the best possible way to access cash now and we look forward to helping you unlock the offer that is right for you.<br><br><br>";
                     $content .= "Unlock your offer by clicking the link below:  <a href='https://www.unlksite.com/8LJN3/GTSC3/'>Unlock your offer!</a>,<br><br><br>";
                     $content .= "Dalton Rosene Equity Specialist<br>";
                     $content .= "dalton@equitytapusa.com<br>";
                     $content .= "equitytapusa.com<br>";
                     $content .= "P (949) 209-0786<br>";
                     $content .= "P (949) 209-0745 <br>";
                     $mail->MsgHTML($content); 
                     $mail->Send();

             }
         }
         elseif($clients == 'PRO0151'){             
            if($res){
                 $this->fsd_105_debt($data,$res->id,"https://fastsavingsdirect.com/dashboard/process.php");
             }
         }
         elseif($clients == 'PRO0152'){             
            if($res){
                 $this->fsd_105_debt_ringba($data,$res->id,"https://display.ringba.com/enrich/2057718035677971619?/?");
             }
         }
         elseif($clients == 'PRO0175'){             
            if($res){
                 $this->LB2342($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
             }
         }
         elseif($clients == 'PRO0177'){             
            if($res){
                 $this->RevLB2420($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
             }
         }
         elseif($clients == 'PRO0178'){             
            if($res){
                 $this->RevLB2417($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
                }
         }
         elseif($clients == 'PRO0181'){             
            if($res){
                 $this->RevLB2432($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
                }
         }
         elseif($clients == 'PRO0198'){             
            if($res){
                 $this->lb2438debt($data,$res->id,"https://leadbalance.com/prospectpro/process.php");
                }
         }
         elseif($clients == 'PRO0205'){             
            if($res){
                 $this->emr_1380_debt($data,$res->id,"https://expertmediaresults.com/leadpanel/process.php");
             }
         }


    }  

    
}