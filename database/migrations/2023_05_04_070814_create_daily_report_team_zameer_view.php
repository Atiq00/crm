<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW `daily_report_team_zameer` AS select `p`.`name` AS `projectname`,`c`.`name` AS `clientname`,count(`sm`.`id`) AS `salecount`,count(`sm`.`id`) * case when `sm`.`project_code` = 'PRO0115' then 0.6 when `sm`.`project_code` = 'PRO0148' then 0.8 when `sm`.`project_code` = 'PRO0149' then 0.8 when `sm`.`project_code` = 'PRO0105' then 0.8 when `sm`.`project_code` = 'PRO0078' then 0.5 when `sm`.`project_code` = 'PRO0036' then 0.6 when `sm`.`project_code` = 'PRO0177' then 0.5 when `sm`.`project_code` = 'PRO0178' then 0.5 else 0 end AS `prorated_value`,cast(`sm`.`created_at` as date) AS `Date` from ((`crmv4`.`sale_mortgages` `sm` join `crmv4`.`projects` `p` on(`p`.`project_code` = `sm`.`project_code`)) join `crmv4`.`clients` `c` on(`c`.`client_code` = `sm`.`client_code` and `sm`.`project_code` in ('PRO0115','PRO0148','PRO0149','PRO0105','PRO0078','PRO0036','PRO0177','PRO0178') and `sm`.`user_id` in (918257,106583,998079,673361,312999,859319,430447,579785,720869,945347,737445,97161,142555,279757,595801,616971,56789,886397,964466,940627,915783,769373,214465,314149,124012,287217,990093,479611,102492,207649,286,438149,165125,607651,68105,475827,110431,865609,31833,188785,123007,657384,854495,209307,739021))) group by `p`.`name`,cast(`sm`.`created_at` as date)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `daily_report_team_zameer`");
    }
};
