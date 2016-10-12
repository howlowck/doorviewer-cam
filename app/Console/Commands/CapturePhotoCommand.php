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
      $workingPath = env('PHOTO_PATH');
      $filename = date("Y-m-d-H-i-s") . '.jpg';
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
