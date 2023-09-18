<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Support\Facades\DB;
// use Composer\Semver\Comparator;

use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $outputLog;
    protected $appVersion;
    

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->appVersion = config('author.app_version');
        $this->env = config('app.env');

        //Check if mac based activation key is required or not.
        $this->macActivationKeyChecker = false;
        if (file_exists(__DIR__ . '/MacActivationKeyChecker.php')) {
            include_once(__DIR__ . '/MacActivationKeyChecker.php');
            $this->macActivationKeyChecker = $mac_is_enabled;
        }

        $this->installSettings();
    }

    /**
     * Initialize all install functions
     *
     */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Check if project is already installed then show 404 error
     *
     */
    private function isInstalled()
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            abort(404);
        }
    }

    /**
     * This function deletes .env file.
     *
     */
    private function deleteEnv()
    {
        $envPath = base_path('.env');
        if ($envPath && file_exists($envPath)) {
            unlink($envPath);
        }
        return true;
    }

    /**
     * This function deletes .env file.
     *
     */
    private function allowedTabs()
    {
        return [
            'home',
            'server-requirements',
            'permissions',
            'database',
            'launch'
        ];
    }

    /**
     * Installation
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab = 'home')
    {
        //Check for .env file
        if( $tab!='launch' )
            $this->isInstalled();
        $this->installSettings();

        if(!in_array( $tab, $this->allowedTabs() ))
            return abort(404);
        
        $tabIndex = array_search($tab, $this->allowedTabs());
        
        //Check if .env.example is present or not.
        $env_example = base_path('.env.example');
        if (!file_exists($env_example)) {
            die("<b>.env.example file not found in <code>$env_example</code></b> <br/><br/> - In the downloaded codebase you will find .env.example file, please upload it and refresh this page.");
        }

        return view('install.'.$tab, compact( 'tab', 'tabIndex' ));
    }

    public function checkServer(){

        // OpenSSL PHP Extension
        $requirements['openssl'] = extension_loaded("openssl");

        // PDO PHP Extension
        $requirements['pdo'] = defined('PDO::ATTR_DRIVER_NAME');

        // Mbstring PHP Extension
        $requirements['mbstring'] = extension_loaded("mbstring");

        // Tokenizer PHP Extension
        $requirements['tokenizer'] = extension_loaded("tokenizer");

        // XML PHP Extension
        $requirements['xml'] = extension_loaded("xml");

        // CTYPE PHP Extension
        $requirements['ctype'] = extension_loaded("ctype");

        // JSON PHP Extension
        $requirements['json'] = extension_loaded("json");

        // BCMath
        $requirements['bcmath'] = extension_loaded("bcmath");

        foreach($requirements as $key => $value){
            if(!$value)
                return redirect()->back()->with('error', __('Server doesn\'t meet requirements'));
        }
        
        
        return redirect('install/permissions');

    }

    public function checkPermission()
    {
        $requirements['/storage/framework'] = substr(sprintf('%o', fileperms( storage_path('framework')) ), -4) >= 775 ;
        $requirements['/storage/logs'] = substr(sprintf('%o', fileperms( storage_path('logs')) ), -4) >= 775 ;
        $requirements['/bootstrap/cache'] = substr(sprintf('%o', fileperms( base_path('bootstrap/cache')) ), -4) >= 775 ;
        $requirements['/public/uploads'] = substr(sprintf('%o', fileperms( public_path('uploads')) ), -4) >= 775 ;

        foreach($requirements as $key => $value){
            if(!$value)
                return redirect()->back()->with('error', __('File Permissions required !'));
        }
        
        return redirect('install/database');
        
    }

    public function processDatabase(Request $request)
    {
        
        //Check for .env file
        $this->isInstalled();
        $this->installSettings();

        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');
            
            $validatedData = $request->validate(
                [
                    'APP_NAME' => 'required',
                    'DB_DATABASE' => 'required',
                    'DB_USERNAME' => 'required',
                    // 'DB_PASSWORD' => 'required',
                    'DB_HOST' => 'required',
                    'DB_PORT' => 'required'
                ],
                [
                    'APP_NAME.required' => 'App Name is required',
                    'DB_DATABASE.required' => 'Database Name is required',
                    'DB_USERNAME.required' => 'Database Username is required',
                    // 'DB_PASSWORD.required' => 'Database Password is required',
                    'DB_HOST.required' => 'Database Host is required',
                    'DB_PORT.required' => 'Database port is required',
                ]
            );

            $this->outputLog = new BufferedOutput;

            $input = $request->only(['APP_NAME', 'APP_TITLE', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'ENVATO_PURCHASE_CODE',
                'ENVATO_EMAIL', 'ENVATO_USERNAME', 'MAIL_DRIVER',
                'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_ENCRYPTION',
                'MAIL_USERNAME', 'MAIL_PASSWORD']);

            $input['APP_DEBUG'] = "false";
            $input['APP_URL'] = url("/");
            $input['APP_ENV'] = 'live';

            //Check for database details
            $mysql_link = @mysqli_connect($input['DB_HOST'], $input['DB_USERNAME'], $input['DB_PASSWORD'], $input['DB_DATABASE'], $input['DB_PORT']);
            if (mysqli_connect_errno()) {
                $msg = "<b>ERROR</b>: Failed to connect to MySQL: " . mysqli_connect_error();
                $msg .= "<br/>Provide correct details for 'Database Host', 'Database Port', 'Database Name', 'Database Username', 'Database Password'.";
                return redirect()
                    ->back()
                    ->with('error', $msg);
            }          

            //Get .env file details and write the contents in it.
            $envPathExample = base_path('.env.example');
            $envPath = base_path('.env');

            $env_lines = file($envPathExample);
            foreach ($input as $index => $value) {
                foreach ($env_lines as $key => $line) {
                    //Check if present then replace it.
                    if (strpos($line, $index) !== false) {
                        $env_lines[$key] = $index . '="' . $value . '"' . PHP_EOL;
                    }
                }
            }
            
            // Remove false & automate the process of creating .env file.
            $fp = fopen($envPath, 'w');
            fwrite($fp, implode('', $env_lines));
            fclose($fp);

            return redirect('install/run-db');

        } catch (Exception $e) {
            $this->deleteEnv();

            return redirect()->back()
                ->with('error', 'Something went wrong, please try again!!');
        }
    }

    public function runDB()
    {
        echo "Installation in progress, Please do not refresh, go back or close the browser.";

        $this->runArtisanCommands();

        return redirect('install/launch');
    }

    public function confirmUpdate()
    { ?>
        Its recommended to Backup the database before updating, so that you can restore in case of any error. 
        <br>
        <br>
        <form action="<?php echo url('install/update/do_update') ?>" onsubmit="return confirm('Are you sure you want to update ?');" enctype="multipart/form-data" method="POST">
            <?php echo csrf_field() ?>
            <label>Update SQL File : </label>
            <input type="file" required name="sql_file" />
            <button type="submit">click to update</button>
        </form>
    <?php }

    public function update()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $file = file_get_contents($_FILES['sql_file']['tmp_name']);

        \DB::unprepared($file);

        return redirect("/install/update/success");
    }

    public function updated_success()
    {
        echo "updated success fully !  <button onclick=\"window.location.href='".url('/')."'\">go to home</button>";
    }

    //Generate key, migrate and seed
    private function runArtisanCommands()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();
        
        DB::statement('SET default_storage_engine=INNODB;');
        Artisan::call('migrate:fresh', ["--force"=> true]);
        Artisan::call('db:seed');
        //Artisan::call('storage:link');
    }




}
