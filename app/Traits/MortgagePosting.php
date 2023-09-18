<?php 
namespace App\Traits;
use DB; use Auth;  
use App\Models\SaleRecord;
use App\Models\Client;
use App\Models\Project;
use App\Models\ClientPosting;
use Maatwebsite\Excel\Facades\Excel; 
trait MortgagePosting{

    public function generalPost($data,$id,$url){
        // echo $id;exit;
        $postData = array();  
        $postData['Company'] = $data['company'];
        $postData['Title'] = $data['title'];
        $postData['LastName'] = $data['first_name'];
        $postData['FirstName'] = $data['last_name'];
        $postData['Email'] = $data['email'];
        $postData['MobilePhone'] = $data['phone']; 
        $postData['Mail_Address'] = $data['address'];  
        $postData['Mail_City'] = $data['city'];        
        $postData['Mail_State'] = $data['state'];        
        $postData['Mail_Zip'] = $data['zip'];        
        $postData['Best_Time'] = "";        
        $postData['Notes'] = $data['notes'];        
        $postData['cash_amount'] = $data['cash_amount'];        
        $postData['Current_Amount'] = $data['current_amount'];        
        $postData['Current_Rate'] = $data['current_rate'];        
        $postData['income'] = $data['income'];        
        $postData['Prop_Value'] = $data['property_value'];        
        $postData['credit_rating'] = $data['credit_rating'];        
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function mkcPost($data,$id,$url){
        $postData = array();  
        $postData["firstname"] = $data['first_name'];
        $postData["lastname"] = $data['last_name'];;
        $postData["email"] = $data['email'];;
        $postData["phone"] = $data['phone'];;
        $postData["city"] = $data['city'];;
        $postData["state"] = $data['state'];
        $postData["zip"] = $data['zip'];
        $postData["leadfulladdress"] = $data['address'];
       // $postData["leadsource"] = "TS";
        $postData["LoanAmount"] = $data['loan_amount'];
        $postData["bormortgageinterestRate"] = $data['interest_rate'];
        $postData["loncashOutAmt"] = $data['cash_amount'];
        //$postData["incmarketvalue"] = $data['first_name'];

        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function PakDebtPost($data,$id,$url){
        $postData = array();  
        $postData['SRC'] = "PAK_Debt";
        $postData['Key'] = "67ebafbf74bc2e8b0f7a508a862e5755080a524328477c244b49b9df0bbad350";
        $postData['API_Action'] = "pingPostLead";        
        $postData['TYPE'] = "93";
        $postData['Debt'] = "15000";
        $postData['Mode'] = "full";
        $postData['Force_IPR_Buyer'] = "1";
        $postData['Landing_Page'] = "landing";
        $postData['IP_Address'] = "160.84.125.140";        
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Primary_Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip'];  
        $postData['Phone'] = $data['phone'];  
        $result = $this->curl($postData,$url);       
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }

    public function camp8Post($data,$id,$url){
        $postData = array();  
        $postData['username'] = "Touch8";
        $postData['password'] = "Touch8";
        $postData['campaign_id'] = "470";
        $postData['firstname'] = $data['first_name'];
        $postData['lastname'] = $data['last_name']; 
        $postData['phone_number'] = $data['phone']; 
        $postData['address'] = $data['address'];  
        $postData['city'] = $data['city'];        
        $postData['state'] = $data['state'];        
        $postData['zip'] = $data['zip'];   
        $postData['property_value'] = $data['property_value'];     
        $postData['credit'] = $data['credit_rating'];        
        $postData['mortage_balance'] = $data['mortgage_balance'];        
        $postData['interest_rate'] = $data['interest_rate'];        
        $postData['loan_amount'] = $data['loan_amount'];        
        $postData['loan_type'] = $data['loan_type'];        
        $postData['cash_amount'] = $data['cash_amount'];                
        $postData['purpose_of_loan'] = $data['purpose_of_loan'];        
        $postData['loanofficername'] = $data['loanofficername'];  
           
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function PAK_HWtPost($data,$id,$url){
        $postData = array();
        $postData['SRC'] = "PAK_HW";
        $postData['Key'] = "286847303cb3ed156318127a9df491c784c6661c016ada6ae97672a9c7fcab57";
        $postData['API_Action'] = "pingPostLead";
        $postData['Average_Utility_Bill_2'] = "$151-200";
        $postData['Credit'] = "Good";
        $postData['Credit_2'] = "680-700";
        $postData['TYPE'] = "105";
        $postData['Mode'] = "full";
        $postData['Force_IPR_Buyer'] = "1";
        $postData['Landing_Page'] = "www.landing.com";
        $postData['Lead_ID'] = "57649957771";
        $postData['IP_Address'] = "75.2.92.149";         
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip_code'];  
        $postData['Phone'] = $data['phone'];  
        $result = $this->curl($postData,$url);       
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }
 
    public function CHREFREVLPost($data,$id,$url){
        // print_r($data);exit;
        $postData = array();  
        $postData['SRC'] = "PAK_Mortgage_LTDP";
        $postData['Key'] = "f024430cb1a84df1cd3f55a2d11f4ac9739468561aba5eb238ff5e2f2c22e267";
        $postData['API_Action'] = "pingPostLead";        
        $postData['TYPE'] = "79"; 
        $postData['Mode'] = "full";
        $postData['Force_IPR_Buyer'] = "1";
        $postData['Landing_Page'] = "landing";
        $postData['IP_Address'] = "160.84.125.140";       
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Primary_Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip'];  
        $postData['Phone'] = $data['phone'];  
        $postData['Credit_Rating'] = $data['credit_rating'];  
        $postData['Rate'] = $data['rate'];  
        $postData['Loan_Type'] = $data['loan_type'];
        $postData['Property_Value'] = $data['property_value'];    
        $result = $this->curl($postData,$url);        
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }
    public function CO_Debt_under_10k($data,$id,$url){
        // print_r($data);exit;
        $postData = array();  
        $postData['SRC'] = "TS_Debt_2x_Verified";
        $postData['Key'] = "97f010d4b111ed9888b2fbc39c59a5f59c78c63d38cd32f4e85cc3555d3b312a";
        $postData['API_Action'] = "pingPostLead";        
        $postData['TYPE'] = "93"; 
        $postData['Mode'] = "full";
        $postData['Landing_Page'] = "landing";
        $postData['IP_Address'] = "160.84.125.140";  
        $postData['Lead_ID']= "1001316";     
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Primary_Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip'];  
        $postData['Email'] = $data['email']; 
        $postData['Debt'] = $data['debt']; 
        
        $result = $this->curl($postData,$url);        
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }
    public function CO_Debt_over_10k($data,$id,$url){
        // print_r($data);exit;
        $postData = array();  
        $postData['SRC'] = "TS_Debt_2x_Verified";
        $postData['Key'] = "97f010d4b111ed9888b2fbc39c59a5f59c78c63d38cd32f4e85cc3555d3b312a";
        $postData['API_Action'] = "pingPostLead";        
        $postData['TYPE'] = "93"; 
        $postData['Mode'] = "full";
        $postData['Landing_Page'] = "landing";
        $postData['IP_Address'] = "160.84.125.140";  
        $postData['Lead_ID']= "1001316";     
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Primary_Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip'];  
        $postData['Email'] = $data['email']; 
        $postData['Debt'] = $data['debt']; 
        
        $result = $this->curl($postData,$url);        
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }
    public function CO_Debt_Over_18k($data,$id,$url){
        // print_r($data);exit;
        $postData = array();  
        $postData['SRC'] = "TS_Debt_2x_Verified";
        $postData['Key'] = "97f010d4b111ed9888b2fbc39c59a5f59c78c63d38cd32f4e85cc3555d3b312a";
        $postData['API_Action'] = "pingPostLead";        
        $postData['TYPE'] = "93"; 
        $postData['Mode'] = "full";
        $postData['Landing_Page'] = "landing";
        $postData['IP_Address'] = "160.84.125.140";  
        $postData['Lead_ID']= "1001316";     
        $postData['First_Name'] = $data['first_name'];
        $postData['Last_Name'] = $data['last_name'];
        $postData['Primary_Phone'] = $data['phone']; 
        $postData['Address'] = $data['address'];  
        $postData['City'] = $data['city'];  
        $postData['State'] = $data['state'];  
        $postData['Zip'] = $data['zip'];  
        $postData['Email'] = $data['email']; 
        $postData['Debt'] = $data['debt']; 
        
        $result = $this->curl($postData,$url);        
        $this->posting($postData,$data['clients'],$id,$result);       
         
    }

    public function RevLgPost($data,$id,$url){
        $postData = array();   
        $postData['firstname'] = $data['last_name'];
        $postData['lastname'] = $data['last_name']; 
        $postData['MobilePhone'] = $data['phone']; 
        $postData['address'] = $data['address'];  
        $postData['city'] = $data['city'];        
        $postData['state'] = $data['state'];        
        $postData['zip'] = $data['zip'];   
        $postData['property_value'] = $data['property_value'];     
        $postData['credit'] = $data['credit_rating'];        
        $postData['mortage_balance'] = $data['mortgage_balance'];        
        $postData['interest_rate'] = $data['interest_rate'];        
        $postData['loan_amount'] = $data['loan_amount'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function WarmDebtPost($data,$id,$url){
        $postData = array();   
        $postData['firstname'] = $data['first_name'];
        $postData['lastname'] = $data['last_name']; 
        $postData['MobilePhone'] = $data['phone']; 
        $postData['address'] = $data['address'];  
        $postData['city'] = $data['city'];        
        $postData['state'] = $data['state'];        
        $postData['zip'] = $data['zip'];   
        $postData['property_value'] = $data['property_value'];     
        $postData['credit'] = $data['credit_rating'];        
        $postData['mortage_balance'] = $data['mortgage_balance'];        
        $postData['interest_rate'] = $data['interest_rate'];        
        $postData['loan_amount'] = $data['loan_amount'];                 
        $postData['loan_type'] = $data['loan_type'];                 
        $postData['cash_amount'] = $data['cash_amount'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function Qms360Post($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "hecm307295";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE"; 

        $postData['RECEIVING_REP'] = $data['recieving_rep'];
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['income'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Qms363Post($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "hecm193084";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE"; 

        $postData['RECEIVING_REP'] = $data['recieving_rep'];
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['income'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,"");  
    }

    public function Rev2374Post($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "040622LB195";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";  

        $postData['RECEIVING_REP'] = $data['recieving_rep'];
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['income'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        // $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function emr_1380_debt($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "DEBT";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = $data['r_transfer_to_1380'];
        $postData['RECEIVING_REP'] = $data['recieving_rep'];
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['r_INCOME'] = $data['income']; 
        $postData['TOTAL_DEBT'] = $data['zip']; 
        $postData['DEBT_TYPE_1'] = $data['debt_type']; 
        $postData['CREDITOR_1'] = $data['creditor'];   
        $postData['DEBT_AMT_1'] = $data['debt_amt_1'];     
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];        
        $postData['LATE_PAYMENTS'] = $data['late_payment'];  
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2397Post($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "071722LB155";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";  
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function Rev2398Post($data,$id,$url){
        $postData = array();     

        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "072022LB141";
        $postData["RECEIVING_REP"] = "Christiana";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";  
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function Rev2399Post($data,$id,$url){
        $postData = array();   

        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "062322LB188";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    
    }
    public function RvQll($data,$id,$url){
        $postData = array();   

    
        $postData['firstname'] = $data['first_name'];
        $postData['lastname'] = $data['last_name']; 
        $postData['phone'] = $data['phone']; 
        $postData['email'] = $data['email']; 
        $postData['leadfulladdress'] = $data['address'];  
        $postData['LoanAmount'] = $data['loan_amount']; 
        $postData['bormortgageinterestRate'] = $data['interest_rate'];  
        $postData['loncashOutAmt'] = $data['cash_out'];  
        $postData['incmarketvalue'] = $data['property_value'];    
        $postData['city'] = $data['city'];        
        $postData['state'] = $data['state'];        
        $postData['zip'] = $data['zip']; 
                                     
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }



    public function Rev2344Post($data,$id,$url){
        $postData = array();   

        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "020722LB153";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function Rev2391Post($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "011723LB930";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["RECEIVING_REP"] = "John";
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['income'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = "Call Transferred Successfully";                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function REVLB2405Post($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "082322LB165";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"] = "Call Transferred Successfully";
        $postData["oid"]="00D5Y0000024bob";
        $postData["country_code"]="US";
        $postData["lead_source"]="Lead Balance";
        $postData["00N5Y00000TOUsv"]="Live Transfer";
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function REVLB2406Post($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "081222LB140";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = $data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2408Post($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "082322LB157";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["RECEIVING_REP"] = "Craig";
 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2412Post($data,$id,$url){
        $postData = array();  
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "101322LB145";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["RECEIVING_REP"] = "George";
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2409Post($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "091922LB130";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["RECEIVING_REP"] = "Chris";
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['r_CALL_TRANSFER_STATUS'] = $data['call_transfer_status'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2414($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "111422LB100";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip'];         
		$postData['DOB'] = $data['dob']; 		
		$postData['EMPLOYED'] = $data['EMPLOYED']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                                   
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
	public function Rev2415($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";        
		$postData["RECEIVING_REP_FIRST_NAME"] = "Steve";

        $postData["r_TRANSFERRED_TO"] = "110222LB165";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['DOB'] = $data['dob']; 		
		$postData['EMPLOYED'] = $data['EMPLOYED']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function Rev2416($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";        
		$postData["RECEIVING_REP_FIRST_NAME"] = "Jeff";

        $postData["r_TRANSFERRED_TO"] = "102722LB183";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['DOB'] = $data['dob']; 		
		$postData['EMPLOYED'] = $data['EMPLOYED']; 
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function RevLB2420($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";        
		// $postData["RECEIVING_REP_FIRST_NAME"] = "Jeff";
        $postData["r_TRANSFERRED_TO"] = $data['transferred_to'];
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['DOB'] = $data['dob']; 		
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function RevLB2417($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";        
		// $postData["RECEIVING_REP_FIRST_NAME"] = "Jeff";
        $postData["r_TRANSFERRED_TO"] = $data['transferred_to_lb2417'];
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['DOB'] = $data['dob']; 		
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
    public function RevLB2432($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "MORTGAGE";
        $postData["form_tools_form_id"] = "2";        
		$postData["RECEIVING_REP"] = "Elizabeth";
        $postData["r_TRANSFERRED_TO"] = "022823LB184";
        $postData["r_SVC_TYPE"] = "REVERSE MORTGAGE";
        $postData["r_CALL_TRANSFER_STATUS"]="Call-Verified Lead"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
		$postData['PHONE_2'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['DOB'] = $data['dob']; 		
        $postData['rd_MTG_BAL'] = $data['mortgage_balance'];   
        $postData['rc_PROP_VALUE'] = $data['property_value'];     
        $postData['CASH_OUT'] = $data['cash_out'];        
        $postData['LOAN_AMT'] = $data['loan_amount'];               
        $postData['LTV'] = $data['ltv'];               
        $postData['r_CREDIT_RATING'] = $data['credit_rating'];               
        $postData['r_INTEREST_RATE'] = $data['interest_rate'];                 
        $postData['r_RATE_TYPE'] = $data['rate_type'];                 
        $postData['r_PROPERTY_TYPE'] = $data['property_type'];                 
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];                 
        $postData['LATE_PAYMENTS'] = $data['late_payment'];                 
        $postData['AGE'] = $data['age'];                 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function fsd_105_debt($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "DEBT";
        $postData["form_tools_form_id"] = "2";        
        $postData["r_TRANSFERRED_TO"] = "debt2095170";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['TOTAL_DEBT'] = $data['debt']; 		
        $postData['r_INCOME'] = $data['income']; 	
		$postData['DEBT_TYPE_1'] = $data['debt_type']; 
        $postData['CREDITOR_1'] = $data['creditor'];   
        $postData['DEBT_AMT_1'] = $data['debt_amt_1'];     
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];        
        $postData['LATE_PAYMENTS'] = $data['late_payment'];               
        $postData['CALL_NOTES'] = $data['notes'];               
                      
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function lb2438debt($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "DEBT";
        $postData["form_tools_form_id"] = "2";        
        $postData["r_TRANSFERRED_TO"] = "032123LB280";
        $postData["RECEIVING_REP"] = "Sergio";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['TOTAL_DEBT'] = $data['total_debt']; 		
        $postData['r_INCOME'] = $data['income']; 	
		$postData['DEBT_TYPE_1'] = $data['debt_type']; 
        $postData['CREDITOR_1'] = $data['creditor'];     
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];        
        $postData['LATE_PAYMENTS'] = $data['late_payment'];               
        $postData['CALL_NOTES'] = $data['notes'];               
                      
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

       public function lb2441debt($data,$id,$url) {
        $postData = array();   
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "DEBT";
        $postData["form_tools_form_id"] = "2";        
        $postData["RECEIVING_REP"] = "Jeff";
        $postData["r_TRANSFERRED_TO"] = "030323LB177";
        $postData["r_CALL_TRANSFER_STATUS"]="Call Transferred Successfully"; 
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['TOTAL_DEBT'] = $data['total_debt']; 		
        $postData['r_INCOME'] = $data['income']; 	
		$postData['DEBT_TYPE_1'] = $data['debt_type']; 
        $postData['CREDITOR_1'] = $data['creditor'];     
        $postData['MONTHLY_PAYMENT'] = $data['monthly_payment'];        
        $postData['LATE_PAYMENTS'] = $data['late_payment'];               
        $postData['CALL_NOTES'] = $data['notes'];               
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    } 
    public function lb2441debt_pay($data,$id,$url) {
        $postData = array();   
    
        $postData["LEAD_TYPE"] = "DEBT";      
        $postData["RECEIVING_REP"] = "Jeff";
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
		$postData['TOTAL_DEBT'] = $data['total_debt']; 		
        $postData['r_INCOME'] = $data['income']; 	
		$postData['DEBT_TYPE_1'] = $data['debt_type'];                
        $postData['CALL_NOTES'] = $data['notes'];               
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    } 
    


    public function fsd_105_debt_ringba($data,$id,$url){
        $postData = array();   
 
        $postData["leadsource"] = "PennieMgmt";
        $postData['firstname'] = $data['first_name'];
        $postData['lastname'] = $data['last_name']; 
        $postData['callerid'] = $data['phone']; 
        $postData['email'] = $data['email']; 
        $postData['address2'] = $data['address'];  
        $postData['city'] = $data['city'];        
        $postData['state'] = $data['state'];        
        $postData['zip'] = $data['zip']; 
		$postData['esttotalDebt'] = $data['debt']; 		
        $postData['netincome'] = $data['income']; 	
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }
	
	
	public function EMR_1378($data,$id,$url){
        $postData = array();   
 
        $postData["CODE"] = "47532489";
        $postData["LEAD_TYPE"] = "DEBT";
        $postData["form_tools_form_id"] = "2";
        $postData["r_TRANSFERRED_TO"] = "FC-871549";
        $postData['r_CALL_TRANSFER_STATUS'] = "Call Transferred Successfully";   
        $postData["RECEIVING_REP"] = "";
        $postData['r_FIRST_NAME'] = $data['first_name'];
        $postData['r_LAST_NAME'] = $data['last_name']; 
        $postData['PHONE_1'] = $data['phone']; 
        $postData['re_EMAIL'] = $data['email']; 
        $postData['r_ADDRESS'] = $data['address'];  
        $postData['r_CITY'] = $data['city'];        
        $postData['r_STATE'] = $data['state'];        
        $postData['r_ZIP'] = $data['zip']; 
        $postData['r_INCOME'] = @$data['incom'];                 
        $postData['r_TRANSFERRED_BY'] = $data['transfer_by'];                 
               
		$postData['TOTAL_DEBT'] = $data['debt'];        
		$postData['DEBT_TYPE_1'] = $data['debt_type'];                 
        $postData['CREDITOR_1'] = $data['creditor'];         
		$postData['DEBT_AMT_1'] = $data['debt_amt_1'];                 
        $postData['CALL_NOTES'] = $data['notes'];                 
        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function he_lend($data,$id,$url){
        $postData = array();   
        $postData['firstname'] = $data['first_name'];
        $postData['	lastname'] = $data['last_name']; 
        $postData['phone'] = $data['phone']; 
        $postData['email'] = $data['email']; 
        $postData['prStreetAddress'] = $data['address'];  
        $postData['prCity'] = $data['city'];        
        $postData['prState'] = $data['state'];        
        $postData['prZipCode'] = $data['zip']; 
        $postData['loncashOutAmt'] = @$data['cash_out'];                 
        $postData['altmarketltv'] = $data['ltv'];                 
		$postData['currentLoanblnc'] = $data['loan_balance'];        
		$postData['proborroweropinion'] = $data['house_value'];    
        $postData['qkappestAppraisalVal']  = $data['house_value'];
        $postData['loncurrentloanbalnc']  = $data['loan_balance'];

        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result);  
    }

    public function MTG_R($data,$id,$url){ 
        if($data['loan_type'] == "FHA"){
            $postData["SourceCode"] = "Federal_Savings_Bank_Eric_FHA";
            $postData["LeadSource"] = "Federal Savings Bank Eric"; 
        }elseif($data['loan_type']  == "VA"){
            $postData["SourceCode"] = "Federal_Savings_Bank_Eric_VA";
            $postData["LeadSource"] = "Federal Savings Bank Eric";
        }
        $postData["Affiliate"] = "Touchstone";
        $postData["PaysPMI"]="1";
        $postData["Disability"]="1";
        $postData["CampLejeune"]="0";

        
        $postData['Officer'] = @$data['loanofficername'];
        $postData['LeadID'] = @$data['leadid_token'];
        $postData['LoanType'] = @$data['loan_type'];  
        $postData['Phone1'] = @$data['phone'];  
        $postData['LoanBal'] = @$data['loan_balance'];  
        $postData['Rate'] = @$data['interest_rate'];  
        $postData['LTV'] = @$data['ltv'];  
        $postData['Debt'] = @$data['debt'];  
        //$postData['Affiliate'] = @$data['Affiliate'];  
        $postData['Agent'] = @$data['agent'];   
        //$postData['CampLejeune'] = @$data['CampLejeune'];  
        $postData['FirstName'] = @$data['first_name'];  
        $postData['LastName'] = @$data['last_name'];  
        $postData['Email'] = @$data['email'];  
        $postData['Street'] = @$data['address'];  
        $postData['City'] = @$data['city'];  
        $postData['StateCd'] = @$data['state'];  
        $postData['ZipCd'] = @$data['zip'];  
        $postData['HomeValue'] = @$data['house_value'];  
        $postData['LoanAmt'] = @$data['loan_amount'];  
        $postData['RateType'] = @$data['rate_type'];  
        $postData['PropertyType'] = @$data['property_type'];  
        $postData['Lender'] = @$data['lender'];  
        $postData['Credit'] = @$data['credit_score'];  
        $postData['BehindPmts'] = @$data['BehindPmts'];  
        $postData['Bankruptcy'] = @$data['bankrupty'];  
        // $postData['PaysPMI'] = @$data['PaysPMI'];  
        // $postData['Disability'] = @$data['Disability'];  
        $postData['Employment'] = @$data['employment'];  
        //$postData['Recording_URL'] = @$data['Recording_URL'];  
        $postData['Comments'] = @$data['notes'];     


        $result = $this->curl($postData,$url);
        $this->posting($postData,$data['clients'],$id,$result); 
    }


    

    public function curl($postData,$url){
        $queryString = http_build_query($postData);  
        $url=$url."?".$queryString;   
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-Type', 'application/json'));
        $result = curl_exec ($ch);
        curl_close($ch);
        return $result;
    }

    public function posting($postData,$product_id,$id,$result){        
        $project = Project::with('client')->where('project_code',$product_id)->first();    
        $cleintPost = new ClientPosting();
        $cleintPost->sale_id = $id;
        $cleintPost->client_id = $project->client->id;
        $cleintPost->campaign_id = "3";
        $cleintPost->post_data = json_encode($postData);
        $cleintPost->post_response = $result; 
        $cleintPost->save();
        return true;
    }   
}