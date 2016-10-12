<?php

namespace App\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;
use MrRio\ShellWrap as sh;

class CapturePhotoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:capture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Capture a Photo';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      
      $tz_object = new \DateTimeZone(env('TIMEZONE'));

      $datetime = new \DateTime();
      $datetime->setTimezone($tz_object);
      $dateString = $datetime->format("Y-m-d-H-i-s");
      
      $workingPath = env('PHOTO_PATH');
      
      $filename = $dateString . '.jpg';
      
      $filePath = $workingPath . $filename;
      
      $nowFilePath = $workingPath . 'now.jpg';
      
      sh::raspistill('-o', $filePath, '-roi', '0.3,0.35,0.4,0.4');
      
      try{
        sh::rm($nowFilePath);
      } catch( \Exception $e ) {}
        
      sh::ln('-s', $filePath, $nowFilePath);
      
      $this->info('photo captured');
    }
}
