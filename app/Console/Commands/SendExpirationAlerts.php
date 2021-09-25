<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\License;
use App\Models\Project;
use App\Models\ImplementationPlan;
use App\Models\Task;
use App\Models\Subtask;

use App\Models\Recipients\AlertRecipient;
use App\Models\Setting;
use App\Notifications\ExpiringAssetsNotification;
use App\Notifications\ExpiringLicenseNotification;

use App\Notifications\ExpiringProjectNotification;
use App\Notifications\ExpiringImplemntationPlanNotification;
use App\Notifications\ExpiringTaskNotification;
use App\Notifications\ExpiringSubtaskNotification;

use Illuminate\Console\Command;

class SendExpirationAlerts extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:expiring-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expiring warrantees and service agreements, and sends out an alert email.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings  = Setting::getSettings();
        $threshold = $settings->alert_interval;

        if (($settings->alert_email != '') && ($settings->alerts_enabled == 1)) {

            // Send a rollup to the admin, if settings dictate
            $recipients = collect(explode(',', $settings->alert_email))->map(function ($item, $key) {
                return new AlertRecipient($item);
            });

            // Expiring Assets
            $assets = Asset::getExpiringWarrantee($threshold);
            if ($assets->count() > 0) {
                $this->info(trans_choice('mail.assets_warrantee_alert', $assets->count(), ['count' => $assets->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringAssetsNotification($assets, $threshold));
            }

            // Expiring licenses
            $licenses = License::getExpiringLicenses($threshold);
            if ($licenses->count() > 0) {
                $this->info(trans_choice('mail.license_expiring_alert', $licenses->count(), ['count' => $licenses->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringLicenseNotification($licenses, $threshold));
            }

            // Expiring  Project
            $projects = Project::getExpiringProject($threshold);
            if ($projects->count() > 0) {
                $this->info(trans_choice('mail.project_expiring_alert', $projects->count(), ['count' => $projects->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringProjectNotification($projects, $threshold));
            }
            // Expiring  implementationplan
            $implementationplans = ImplementationPlan::getExpiringImplementationPlan($threshold);
            if ($implementationplans->count() > 0) {
                $this->info(trans_choice('mail.implementationplan_expiring_alert', $implementationplans->count(), ['count' => $implementationplans->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringImplementationPlanNotification($implementationplans, $threshold));
            }

            // Expiring  Task
            $tasks = Task::getExpiringTask($threshold);
            if ($tasks->count() > 0) {
                $this->info(trans_choice('mail.task_expiring_alert', $tasks->count(), ['count' => $tasks->count(), 'threshold' => $threshold]));
                \Notification::send($recipients, new ExpiringTaskNotification($tasks, $threshold));
            }

             // Expiring  subtask
             $subtasks = Subtask::getExpiringTask($threshold);
             if ($subtasks->count() > 0) {
                 $this->info(trans_choice('mail.subtask_expiring_alert', $subtasks->count(), ['count' => $subtasks->count(), 'threshold' => $threshold]));
                 \Notification::send($recipients, new ExpiringSubtaskNotification($subtasks, $threshold));
             } 
  


        } else {
            if ($settings->alert_email == '') {
                $this->error('Could not send email. No alert email configured in settings');
            } elseif (1 != $settings->alerts_enabled) {
                $this->info('Alerts are disabled in the settings. No mail will be sent');
            }
        }
    }
}
